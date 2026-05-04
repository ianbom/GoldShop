<?php

namespace App\Services;

use App\Models\InventoryItem;
use App\Models\SalesTransaction;
use Illuminate\Support\Facades\DB;

class SaleService
{
    public function __construct(private NumberGeneratorService $numbers, private InventoryService $inventory) {}

    public function create(array $data, int $adminId): SalesTransaction
    {
        return DB::transaction(function () use ($data, $adminId) {
            $inventoryItems = InventoryItem::query()->whereIn('id', collect($data['items'])->pluck('inventory_item_id'))->lockForUpdate()->get()->keyBy('id');

            $items = collect($data['items'])->map(function (array $item) use ($inventoryItems) {
                $inventory = $inventoryItems->get($item['inventory_item_id']);
                abort_unless($inventory && $inventory->status === 'available', 422, 'Inventory item not available.');
                $discount = (float) ($item['discount_amount'] ?? 0);
                $selling = (float) $item['selling_price'];

                return [
                    'inventory_item_id' => $inventory->id,
                    'item_name' => $inventory->item_name,
                    'sku' => $inventory->sku,
                    'gold_carat' => $inventory->gold_carat,
                    'weight_gram' => $inventory->weight_gram,
                    'purchase_price' => $inventory->purchase_price,
                    'selling_price' => $selling,
                    'discount_amount' => $discount,
                    'final_price' => max($selling - $discount, 0),
                ];
            });

            $subtotal = $items->sum('final_price');
            $discount = (float) ($data['discount_amount'] ?? 0);
            $sale = SalesTransaction::create([
                'admin_id' => $adminId,
                'sales_number' => $this->numbers->salesNumber(),
                'buyer_name' => $data['buyer_name'] ?? null,
                'buyer_phone' => $data['buyer_phone'] ?? null,
                'transaction_date' => $data['transaction_date'],
                'subtotal_amount' => $subtotal,
                'discount_amount' => $discount,
                'total_amount' => max($subtotal - $discount, 0),
                'payment_method' => $data['payment_method'] ?? null,
                'status' => $data['status'],
                'notes' => $data['notes'] ?? null,
            ]);

            $items->each(fn (array $item) => $sale->items()->create($item));

            if ($sale->status === 'completed') {
                $sale->items->each(fn ($item) => $this->inventory->markSold($item->inventoryItem, $sale->transaction_date));
            }

            return $sale->load('items.inventoryItem');
        });
    }

    public function cancel(SalesTransaction $sale): void
    {
        DB::transaction(function () use ($sale) {
            $sale->items()->with('inventoryItem')->get()->each(fn ($item) => $this->inventory->restoreAvailable($item->inventoryItem));
            $sale->update(['status' => 'cancelled']);
        });
    }
}
