<?php

namespace App\Services;

use App\Models\PurchaseTransaction;
use App\Models\Seller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PurchaseService
{
    public function __construct(
        private NumberGeneratorService $numbers,
        private InventoryService $inventory,
        private FileUploadService $uploads,
    ) {}

    public function create(array $data, int $adminId): PurchaseTransaction
    {
        return DB::transaction(function () use ($data, $adminId) {
            $seller = isset($data['seller_id'])
                ? Seller::findOrFail($data['seller_id'])
                : Seller::create(Arr::only($data['seller'], ['name', 'nik', 'phone', 'address', 'notes']));

            $items = collect($data['items'])->map(function (array $item, int $index) {
                $estimated = (float) $item['weight_gram'] * (float) $item['price_per_gram'];
                $deduction = (float) ($item['deduction_amount'] ?? 0);

                return array_merge(Arr::except($item, ['product_photo']), [
                    'product_photo_url' => $this->uploads->image(request()->file("items.$index.product_photo"), 'purchase-items'),
                    'estimated_price' => $estimated,
                    'deduction_amount' => $deduction,
                    'final_price' => max($estimated - $deduction, 0),
                ]);
            });

            $subtotal = $items->sum('final_price');
            $deduction = (float) ($data['deduction_amount'] ?? 0);

            $purchase = PurchaseTransaction::create([
                'seller_id' => $seller->id,
                'admin_id' => $adminId,
                'purchase_number' => $this->numbers->purchaseNumber(),
                'transaction_date' => $data['transaction_date'],
                'subtotal_amount' => $subtotal,
                'deduction_amount' => $deduction,
                'total_amount' => max($subtotal - $deduction, 0),
                'payment_method' => $data['payment_method'] ?? null,
                'status' => $data['status'],
                'notes' => $data['notes'] ?? null,
            ]);

            $items->each(fn (array $item) => $purchase->items()->create($item));

            if ($purchase->status === 'completed') {
                $purchase->items->each(fn ($item) => $this->inventory->createFromPurchaseItem($item, $purchase->transaction_date));
            }

            return $purchase->load(['seller', 'items.inventoryItem']);
        });
    }

    public function cancel(PurchaseTransaction $purchase): void
    {
        abort_if($purchase->items()->whereHas('inventoryItem', fn ($q) => $q->where('status', 'sold'))->exists(), 422, 'Purchase has sold inventory.');

        DB::transaction(function () use ($purchase) {
            $purchase->items()->with('inventoryItem')->get()->each(fn ($item) => $item->inventoryItem?->update(['status' => 'cancelled']));
            $purchase->update(['status' => 'cancelled']);
        });
    }
}
