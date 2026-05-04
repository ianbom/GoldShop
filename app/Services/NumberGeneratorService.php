<?php

namespace App\Services;

use App\Models\GeneratedDocument;
use App\Models\InventoryItem;
use App\Models\PurchaseTransaction;
use App\Models\SalesTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class NumberGeneratorService
{
    public function purchaseNumber(): string
    {
        return $this->generate('PUR', PurchaseTransaction::class, 'purchase_number');
    }

    public function salesNumber(): string
    {
        return $this->generate('SAL', SalesTransaction::class, 'sales_number');
    }

    public function sku(): string
    {
        return $this->generate('GLD', InventoryItem::class, 'sku');
    }

    public function documentNumber(string $type): string
    {
        $prefix = $type === 'sales_invoice' ? 'SINV' : ($type === 'purchase_invoice' ? 'PINV' : 'DOC');

        return $this->generate($prefix, GeneratedDocument::class, 'document_number');
    }

    /** @param class-string<Model> $model */
    private function generate(string $prefix, string $model, string $column): string
    {
        $date = Carbon::now()->format('Ymd');
        $latest = $model::query()->where($column, 'like', "$prefix-$date-%")->latest('id')->value($column);
        $next = $latest ? ((int) str($latest)->afterLast('-')->toString()) + 1 : 1;

        return sprintf('%s-%s-%04d', $prefix, $date, $next);
    }
}
