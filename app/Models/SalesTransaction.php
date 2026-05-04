<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['admin_id', 'sales_number', 'buyer_name', 'buyer_phone', 'transaction_date', 'subtotal_amount', 'discount_amount', 'total_amount', 'payment_method', 'status', 'notes'])]
class SalesTransaction extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return ['transaction_date' => 'datetime'];
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(SalesItem::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(GeneratedDocument::class, 'reference_id')->where('reference_type', 'sales_transaction');
    }
}
