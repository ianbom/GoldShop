<?php

namespace App\Services;

use App\Models\DocumentTemplate;
use App\Models\GeneratedDocument;
use App\Models\PurchaseTransaction;
use App\Models\SalesTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
    public function __construct(private NumberGeneratorService $numbers) {}

    public function generate(DocumentTemplate $template, Model $reference, int $userId): GeneratedDocument
    {
        abort_unless($template->is_active, 422, 'Template inactive.');

        $documentNumber = $this->numbers->documentNumber($template->document_type);
        $html = $this->render($template, $reference);
        $path = 'generated-documents/'.$documentNumber.'.html';
        Storage::disk('public')->put($path, $html);

        return GeneratedDocument::create([
            'document_template_id' => $template->id,
            'generated_by' => $userId,
            'document_number' => $documentNumber,
            'document_type' => $template->document_type,
            'reference_type' => $reference instanceof PurchaseTransaction ? 'purchase_transaction' : 'sales_transaction',
            'reference_id' => $reference->id,
            'pdf_url' => Storage::url($path),
            'status' => 'generated',
            'generated_at' => now(),
        ]);
    }

    public function mark(GeneratedDocument $document, string $status): void
    {
        abort_unless(in_array($status, ['printed', 'signed'], true), 422, 'Invalid document status.');
        $document->update(['status' => $status, $status.'_at' => now()]);
    }

    private function render(DocumentTemplate $template, Model $reference): string
    {
        $reference->loadMissing($reference instanceof PurchaseTransaction ? ['seller', 'admin', 'items'] : ['admin', 'items']);
        $values = $reference instanceof PurchaseTransaction ? $this->purchaseValues($reference) : $this->salesValues($reference);

        return str($template->html_content ?: '<html><body>{{ items_table }}</body></html>')
            ->replace(array_map(fn ($key) => '{{ '.$key.' }}', array_keys($values)), array_values($values))
            ->toString();
    }

    private function purchaseValues(PurchaseTransaction $purchase): array
    {
        return [
            'purchase_number' => $purchase->purchase_number,
            'purchase_date' => $purchase->transaction_date->format('d/m/Y'),
            'seller_name' => e($purchase->seller->name),
            'seller_nik' => e($purchase->seller->nik),
            'seller_phone' => e($purchase->seller->phone),
            'seller_address' => e($purchase->seller->address),
            'subtotal_amount' => number_format((float) $purchase->subtotal_amount, 0, ',', '.'),
            'deduction_amount' => number_format((float) $purchase->deduction_amount, 0, ',', '.'),
            'total_amount' => number_format((float) $purchase->total_amount, 0, ',', '.'),
            'payment_method' => e($purchase->payment_method),
            'admin_name' => e($purchase->admin->name),
            'items_table' => $this->itemsTable($purchase->items, [
                'item_name' => 'Nama Barang',
                'item_type' => 'Jenis',
                'gold_carat' => 'Karat',
                'weight_gram' => 'Berat (gr)',
                'price_per_gram' => 'Harga / Gram',
                'deduction_amount' => 'Potongan',
                'final_price' => 'Total',
            ]),
        ];
    }

    private function salesValues(SalesTransaction $sale): array
    {
        return [
            'sales_number' => $sale->sales_number,
            'sales_date' => $sale->transaction_date->format('d/m/Y'),
            'buyer_name' => e($sale->buyer_name),
            'buyer_phone' => e($sale->buyer_phone),
            'subtotal_amount' => number_format((float) $sale->subtotal_amount, 0, ',', '.'),
            'discount_amount' => number_format((float) $sale->discount_amount, 0, ',', '.'),
            'total_amount' => number_format((float) $sale->total_amount, 0, ',', '.'),
            'payment_method' => e($sale->payment_method),
            'admin_name' => e($sale->admin->name),
            'items_table' => $this->itemsTable($sale->items, [
                'sku' => 'SKU',
                'item_name' => 'Nama Barang',
                'gold_carat' => 'Karat',
                'weight_gram' => 'Berat (gr)',
                'selling_price' => 'Harga Jual',
                'discount_amount' => 'Diskon',
                'final_price' => 'Total',
            ]),
        ];
    }

    private function itemsTable($items, array $columns): string
    {
        $head = collect($columns)->map(fn ($label) => '<th>'.e($label).'</th>')->implode('');
        $moneyColumns = ['price_per_gram', 'deduction_amount', 'final_price', 'selling_price', 'discount_amount'];
        $rows = $items->map(function ($item) use ($columns, $moneyColumns) {
            $cells = collect($columns)->map(function ($label, $column) use ($item, $moneyColumns) {
                $value = $item->{$column};

                if (in_array($column, $moneyColumns, true)) {
                    $value = 'Rp '.number_format((float) $value, 0, ',', '.');
                }

                return '<td>'.e($value).'</td>';
            })->implode('');

            return '<tr>'.$cells.'</tr>';
        })->implode('');

        return '<table border="1" cellspacing="0" cellpadding="6"><thead><tr>'.$head.'</tr></thead><tbody>'.$rows.'</tbody></table>';
    }
}
