<?php

namespace Database\Seeders;

use App\Models\DocumentTemplate;
use App\Models\GeneratedDocument;
use App\Models\InventoryItem;
use App\Models\PurchaseItem;
use App\Models\PurchaseTransaction;
use App\Models\SalesItem;
use App\Models\SalesTransaction;
use App\Models\Seller;
use App\Models\User;
use App\Services\DocumentService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class GoldShopDemoSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        GeneratedDocument::truncate();
        SalesItem::truncate();
        SalesTransaction::truncate();
        InventoryItem::truncate();
        PurchaseItem::truncate();
        PurchaseTransaction::truncate();
        Seller::truncate();
        Schema::enableForeignKeyConstraints();

        $admin = User::where('email', 'admin@goldshop.test')->firstOrFail();

        $sellers = collect([
            ['name' => 'Budi Santoso', 'nik' => '3174010101800001', 'phone' => '081234567001', 'address' => 'Jl. Melati No. 12, Jakarta', 'notes' => 'Pelanggan lama.'],
            ['name' => 'Siti Aminah', 'nik' => '3273024502850002', 'phone' => '081234567002', 'address' => 'Jl. Cempaka No. 8, Bandung', 'notes' => 'Sering menjual cincin.'],
            ['name' => 'Rudi Hartono', 'nik' => '3374011203900003', 'phone' => '081234567003', 'address' => 'Jl. Kenanga No. 4, Semarang', 'notes' => 'Prefer transfer bank.'],
            ['name' => 'Dewi Lestari', 'nik' => '3578015504920004', 'phone' => '081234567004', 'address' => 'Jl. Mawar No. 19, Surabaya', 'notes' => 'Bawa KTP fisik.'],
            ['name' => 'Agus Wijaya', 'nik' => '3671012201880005', 'phone' => '081234567005', 'address' => 'Jl. Anggrek No. 2, Tangerang', 'notes' => 'Butuh nota lengkap.'],
        ])->map(fn (array $seller) => Seller::create($seller));

        $purchasePlans = [
            [0, '2026-05-01 10:15:00', 'cash', 25000, 'completed', [
                ['Cincin Solitaire', 'cincin', 22, 4.250, 980000, 50000, 'baik'],
                ['Kalung Rantai', 'kalung', 18, 12.750, 805000, 125000, 'gores ringan'],
            ]],
            [1, '2026-05-01 14:40:00', 'transfer', 0, 'completed', [
                ['Gelang Rantai', 'gelang', 22, 8.400, 990000, 75000, 'baik'],
                ['Anting Anak', 'anting', 17, 2.150, 760000, 25000, 'baik'],
            ]],
            [2, '2026-05-02 11:20:00', 'qris', 50000, 'completed', [
                ['Liontin Huruf A', 'liontin', 18, 3.330, 815000, 30000, 'baik'],
                ['Cincin Polos', 'cincin', 24, 5.100, 1085000, 0, 'sangat baik'],
            ]],
            [3, '2026-05-03 09:10:00', 'cash', 100000, 'completed', [
                ['Kalung Italia', 'kalung', 22, 18.250, 995000, 150000, 'baik'],
                ['Gelang Kaku', 'gelang', 20, 10.000, 900000, 100000, 'penyok kecil'],
            ]],
            [4, '2026-05-03 16:30:00', 'debit', 0, 'completed', [
                ['Cincin Kawin', 'cincin', 23, 6.750, 1030000, 25000, 'baik'],
                ['Anting Batu Merah', 'anting', 18, 4.800, 820000, 40000, 'baik'],
            ]],
            [0, '2026-05-04 13:00:00', 'other', 0, 'draft', [
                ['Gelang Draft', 'gelang', 18, 7.200, 800000, 0, 'perlu cek kadar'],
            ]],
            [1, '2026-05-04 15:10:00', 'cash', 0, 'cancelled', [
                ['Kalung Batal', 'kalung', 16, 5.500, 710000, 25000, 'batal transaksi'],
            ]],
        ];

        foreach ($purchasePlans as $index => [$sellerIndex, $date, $payment, $transactionDeduction, $status, $items]) {
            $purchaseItems = collect($items)->map(function (array $item) {
                [$name, $type, $carat, $weight, $pricePerGram, $deduction, $condition] = $item;
                $estimated = $weight * $pricePerGram;

                return [
                    'item_name' => $name,
                    'item_type' => $type,
                    'gold_carat' => $carat,
                    'weight_gram' => $weight,
                    'price_per_gram' => $pricePerGram,
                    'estimated_price' => $estimated,
                    'deduction_amount' => $deduction,
                    'final_price' => $estimated - $deduction,
                    'condition' => $condition,
                    'description' => "Demo item {$name}",
                    'product_photo_url' => null,
                ];
            });

            $subtotal = $purchaseItems->sum('final_price');
            $purchase = PurchaseTransaction::create([
                'seller_id' => $sellers[$sellerIndex]->id,
                'admin_id' => $admin->id,
                'purchase_number' => sprintf('PUR-%s-%04d', Carbon::parse($date)->format('Ymd'), $index + 1),
                'transaction_date' => $date,
                'subtotal_amount' => $subtotal,
                'deduction_amount' => $transactionDeduction,
                'total_amount' => max($subtotal - $transactionDeduction, 0),
                'payment_method' => $payment,
                'status' => $status,
                'notes' => "Demo purchase {$status}.",
            ]);

            $purchaseItems->each(function (array $item) use ($purchase, $status) {
                $purchaseItem = $purchase->items()->create($item);

                if ($status === 'completed') {
                    InventoryItem::create([
                        'purchase_item_id' => $purchaseItem->id,
                        'sku' => sprintf('GLD-%s-%04d', $purchase->transaction_date->format('Ymd'), $purchaseItem->id),
                        'item_name' => $purchaseItem->item_name,
                        'item_type' => $purchaseItem->item_type,
                        'gold_carat' => $purchaseItem->gold_carat,
                        'weight_gram' => $purchaseItem->weight_gram,
                        'purchase_price' => $purchaseItem->final_price,
                        'selling_price' => round($purchaseItem->final_price * 1.18, -3),
                        'status' => 'available',
                        'condition' => $purchaseItem->condition,
                        'product_photo_url' => $purchaseItem->product_photo_url,
                        'acquired_at' => $purchase->transaction_date,
                        'notes' => 'Stok demo dari transaksi pembelian.',
                    ]);
                }
            });
        }

        $availableInventory = InventoryItem::where('status', 'available')->orderBy('id')->get();
        $salesPlans = [
            ['SAL-20260502-0001', 'Maya Putri', '081288880001', '2026-05-02 15:30:00', 'cash', 25000, [$availableInventory[0], $availableInventory[1]]],
            ['SAL-20260503-0001', 'Hendra Kusuma', '081288880002', '2026-05-03 17:05:00', 'transfer', 0, [$availableInventory[2]]],
            ['SAL-20260504-0001', 'Nina Kartika', '081288880003', '2026-05-04 11:45:00', 'qris', 50000, [$availableInventory[3], $availableInventory[4]]],
        ];

        foreach ($salesPlans as [$number, $buyerName, $buyerPhone, $date, $payment, $transactionDiscount, $items]) {
            $saleRows = collect($items)->map(function (InventoryItem $inventory, int $index) {
                $discount = $index === 0 ? 15000 : 0;

                return [
                    'inventory_item_id' => $inventory->id,
                    'item_name' => $inventory->item_name,
                    'sku' => $inventory->sku,
                    'gold_carat' => $inventory->gold_carat,
                    'weight_gram' => $inventory->weight_gram,
                    'purchase_price' => $inventory->purchase_price,
                    'selling_price' => $inventory->selling_price,
                    'discount_amount' => $discount,
                    'final_price' => $inventory->selling_price - $discount,
                ];
            });

            $subtotal = $saleRows->sum('final_price');
            $sale = SalesTransaction::create([
                'admin_id' => $admin->id,
                'sales_number' => $number,
                'buyer_name' => $buyerName,
                'buyer_phone' => $buyerPhone,
                'transaction_date' => $date,
                'subtotal_amount' => $subtotal,
                'discount_amount' => $transactionDiscount,
                'total_amount' => max($subtotal - $transactionDiscount, 0),
                'payment_method' => $payment,
                'status' => 'completed',
                'notes' => 'Demo sales completed.',
            ]);

            $saleRows->each(function (array $row) use ($sale, $date) {
                SalesItem::create(['sales_transaction_id' => $sale->id, ...$row]);
                InventoryItem::whereKey($row['inventory_item_id'])->update(['status' => 'sold', 'sold_at' => $date]);
            });
        }

        InventoryItem::where('status', 'available')->skip(1)->take(1)->update(['status' => 'damaged', 'notes' => 'Demo status rusak ringan.']);
        InventoryItem::where('status', 'available')->skip(2)->take(1)->update(['status' => 'lost', 'notes' => 'Demo status hilang.']);

        $documentService = app(DocumentService::class);
        $purchaseTemplate = DocumentTemplate::where('code', 'PINV')->first();
        $salesTemplate = DocumentTemplate::where('code', 'SINV')->first();

        if ($purchaseTemplate) {
            PurchaseTransaction::where('status', 'completed')->limit(2)->get()->each(fn (PurchaseTransaction $purchase) => $documentService->generate($purchaseTemplate, $purchase, $admin->id));
        }

        if ($salesTemplate) {
            SalesTransaction::limit(2)->get()->each(fn (SalesTransaction $sale) => $documentService->generate($salesTemplate, $sale, $admin->id));
        }

        GeneratedDocument::orderBy('id')->limit(1)->update(['status' => 'printed', 'printed_at' => now()]);
        GeneratedDocument::orderByDesc('id')->limit(1)->update(['status' => 'signed', 'printed_at' => now()->subHour(), 'signed_at' => now()]);
    }
}
