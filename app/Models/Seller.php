<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'nik', 'phone', 'address', 'ktp_photo_url', 'notes'])]
class Seller extends Model
{
    use SoftDeletes;

    public function purchaseTransactions(): HasMany
    {
        return $this->hasMany(PurchaseTransaction::class);
    }
}
