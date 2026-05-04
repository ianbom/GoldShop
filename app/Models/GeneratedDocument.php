<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['document_template_id', 'generated_by', 'document_number', 'document_type', 'reference_type', 'reference_id', 'pdf_url', 'status', 'generated_at', 'printed_at', 'signed_at'])]
class GeneratedDocument extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return ['generated_at' => 'datetime', 'printed_at' => 'datetime', 'signed_at' => 'datetime'];
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(DocumentTemplate::class, 'document_template_id');
    }

    public function generatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
