<?php

namespace Database\Seeders;

use App\Models\DocumentTemplate;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@goldshop.test'],
            ['name' => 'Admin Gold Shop', 'password' => Hash::make('password')]
        );

        $purchaseInvoice = <<<'HTML'
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; color: #111827; font-size: 13px; }
        .page { max-width: 820px; margin: 0 auto; padding: 28px; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #111827; padding-bottom: 14px; margin-bottom: 18px; }
        .brand { font-size: 22px; font-weight: 700; letter-spacing: .04em; }
        .title { font-size: 18px; font-weight: 700; text-align: right; }
        .meta { display: grid; grid-template-columns: 120px 1fr 120px 1fr; gap: 8px 12px; margin-bottom: 22px; }
        .label { font-weight: 700; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #f3f4f6; text-align: left; font-weight: 700; }
        th, td { border: 1px solid #d1d5db; padding: 8px; }
        .total { display: flex; justify-content: flex-end; margin-top: 12px; font-size: 15px; font-weight: 700; }
        .signatures { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; margin-top: 54px; text-align: center; }
        .signature-space { height: 76px; border-bottom: 1px solid #111827; margin-bottom: 8px; }
        .note { margin-top: 28px; border: 1px solid #d1d5db; padding: 12px; line-height: 1.5; }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            <div>
                <div class="brand">GOLD SHOP</div>
                <div>Sistem Manajemen Pembelian Emas</div>
            </div>
            <div class="title">PURCHASE INVOICE</div>
        </div>

        <div class="meta">
            <div class="label">No Invoice</div><div>: {{ purchase_number }}</div>
            <div class="label">Tanggal</div><div>: {{ purchase_date }}</div>
            <div class="label">Kepada</div><div>: {{ seller_name }}</div>
            <div class="label">No Telp</div><div>: {{ seller_phone }}</div>
            <div class="label">NIK</div><div>: {{ seller_nik }}</div>
            <div class="label">Pembayaran</div><div>: {{ payment_method }}</div>
        </div>

        <div class="label">Detail Emas</div>
        {{ items_table }}

        <div class="total">Total Pembelian: Rp {{ total_amount }}</div>

        <div class="signatures">
            <div>
                <div class="signature-space"></div>
                <div>Teller 1</div>
            </div>
            <div>
                <div class="signature-space"></div>
                <div>Teller 2</div>
            </div>
            <div>
                <div class="signature-space"></div>
                <div>Nasabah</div>
            </div>
        </div>

        <div class="note">
            <strong>Note:</strong> Dengan ini pelanggan menyetujui keseluruhan data transaksi, detail emas, berat, kadar, potongan, dan total pembayaran yang tercantum pada invoice ini. Invoice ini sah sebagai bukti transaksi pembelian emas antara pelanggan dan toko.
        </div>
    </div>
</body>
</html>
HTML;

        $templates = [
            ['Purchase Invoice', 'PINV', 'purchase_invoice', $purchaseInvoice],
            ['Purchase Agreement', 'PAGR', 'purchase_agreement', '<html><body><h1>Surat Jual Beli Emas</h1><p>{{ seller_name }} menjual emas pada transaksi {{ purchase_number }} senilai {{ total_amount }}.</p>{{ items_table }}</body></html>'],
            ['Goods Receipt', 'GRCPT', 'goods_receipt', '<html><body><h1>Tanda Terima Barang {{ purchase_number }}</h1>{{ items_table }}</body></html>'],
            ['Sales Invoice', 'SINV', 'sales_invoice', '<html><body><h1>Sales Invoice {{ sales_number }}</h1><p>Buyer: {{ buyer_name }}</p><p>Total: {{ total_amount }}</p>{{ items_table }}</body></html>'],
        ];

        foreach ($templates as [$name, $code, $type, $html]) {
            DocumentTemplate::updateOrCreate(
                ['code' => $code],
                ['name' => $name, 'document_type' => $type, 'html_content' => $html, 'is_active' => true]
            );
        }

        $this->call(PurchaseInvoiceTemplateSeeder::class);
        $this->call(SalesInvoiceTemplateSeeder::class);
        $this->call(GoldShopDemoSeeder::class);
    }
}
