<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['seller_id', 'admin_id', 'purchase_number', 'transaction_date', 'subtotal_amount', 'deduction_amount', 'total_amount', 'payment_method', 'status', 'notes'])]
class PurchaseTransaction extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return ['transaction_date' => 'datetime'];
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(GeneratedDocument::class, 'reference_id')->where('reference_type', 'purchase_transaction');
    }
}
