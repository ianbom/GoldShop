<?php

namespace Database\Seeders;

use App\Models\DocumentTemplate;
use Illuminate\Database\Seeder;

class SalesInvoiceTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $html = <<<'HTML'
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
                <div>Sistem Manajemen Penjualan Emas</div>
            </div>
            <div class="title">SALES INVOICE</div>
        </div>

        <div class="meta">
            <div class="label">No Invoice</div><div>: {{ sales_number }}</div>
            <div class="label">Tanggal</div><div>: {{ sales_date }}</div>
            <div class="label">Kepada</div><div>: {{ buyer_name }}</div>
            <div class="label">No Telp</div><div>: {{ buyer_phone }}</div>
            <div class="label">Pembayaran</div><div>: {{ payment_method }}</div>
            <div class="label">Diskon</div><div>: Rp {{ discount_amount }}</div>
        </div>

        <div class="label">Detail Emas</div>
        {{ items_table }}

        <div class="total">Total Penjualan: Rp {{ total_amount }}</div>

        <div class="signatures">
            <div><div class="signature-space"></div><div>Teller 1</div></div>
            <div><div class="signature-space"></div><div>Teller 2</div></div>
            <div><div class="signature-space"></div><div>Nasabah</div></div>
        </div>

        <div class="note">
            <strong>Note:</strong> Dengan ini pelanggan menyetujui keseluruhan data transaksi penjualan, detail emas, SKU, berat, kadar, harga jual, diskon, dan total pembayaran yang tercantum pada invoice ini. Barang yang sudah dibeli dan diterima pelanggan dinyatakan sesuai dengan data pada invoice ini.
        </div>
    </div>
</body>
</html>
HTML;

        DocumentTemplate::updateOrCreate(
            ['code' => 'SINV'],
            ['name' => 'Sales Invoice', 'document_type' => 'sales_invoice', 'html_content' => $html, 'is_active' => true]
        );
    }
}
