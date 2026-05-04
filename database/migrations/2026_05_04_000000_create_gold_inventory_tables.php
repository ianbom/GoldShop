<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 30)->nullable()->after('password');
            $table->string('avatar_url')->nullable()->after('phone');
            $table->softDeletes();
        });

        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->index();
            $table->string('nik', 30)->nullable()->index();
            $table->string('phone', 30)->nullable()->index();
            $table->text('address')->nullable();
            $table->string('ktp_photo_url')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained();
            $table->foreignId('admin_id')->constrained('users');
            $table->string('purchase_number', 100)->unique();
            $table->dateTime('transaction_date')->index();
            $table->decimal('subtotal_amount', 15, 2)->default(0);
            $table->decimal('deduction_amount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->string('payment_method', 50)->nullable();
            $table->string('status', 50)->default('completed')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['seller_id', 'transaction_date']);
            $table->index('admin_id');
        });

        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_transaction_id')->constrained()->cascadeOnDelete();
            $table->string('item_name', 150);
            $table->string('item_type', 100)->nullable()->index();
            $table->decimal('gold_carat', 5, 2)->nullable()->index();
            $table->decimal('weight_gram', 10, 3);
            $table->decimal('price_per_gram', 15, 2);
            $table->decimal('estimated_price', 15, 2)->default(0);
            $table->decimal('deduction_amount', 15, 2)->default(0);
            $table->decimal('final_price', 15, 2)->default(0);
            $table->string('condition', 100)->nullable();
            $table->text('description')->nullable();
            $table->string('product_photo_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_item_id')->nullable()->unique()->constrained();
            $table->string('sku', 100)->unique();
            $table->string('item_name', 150);
            $table->string('item_type', 100)->nullable()->index();
            $table->decimal('gold_carat', 5, 2)->nullable()->index();
            $table->decimal('weight_gram', 10, 3)->nullable();
            $table->decimal('purchase_price', 15, 2)->default(0);
            $table->decimal('selling_price', 15, 2)->nullable();
            $table->string('status', 50)->default('available')->index();
            $table->string('condition', 100)->nullable();
            $table->string('product_photo_url')->nullable();
            $table->dateTime('acquired_at')->nullable()->index();
            $table->dateTime('sold_at')->nullable()->index();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sales_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users');
            $table->string('sales_number', 100)->unique();
            $table->string('buyer_name', 150)->nullable()->index();
            $table->string('buyer_phone', 30)->nullable()->index();
            $table->dateTime('transaction_date')->index();
            $table->decimal('subtotal_amount', 15, 2)->default(0);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->string('payment_method', 50)->nullable();
            $table->string('status', 50)->default('completed')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('admin_id');
        });

        Schema::create('sales_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_transaction_id')->constrained()->cascadeOnDelete();
            $table->foreignId('inventory_item_id')->constrained();
            $table->string('item_name', 150);
            $table->string('sku', 100)->nullable();
            $table->decimal('gold_carat', 5, 2)->nullable();
            $table->decimal('weight_gram', 10, 3)->nullable();
            $table->decimal('purchase_price', 15, 2)->default(0);
            $table->decimal('selling_price', 15, 2);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('final_price', 15, 2)->default(0);
            $table->timestamps();
            $table->index(['sales_transaction_id', 'inventory_item_id']);
        });

        Schema::create('document_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('code', 100)->unique();
            $table->string('document_type', 100)->index();
            $table->longText('html_content')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('generated_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_template_id')->constrained();
            $table->foreignId('generated_by')->constrained('users');
            $table->string('document_number', 100)->unique();
            $table->string('document_type', 100)->index();
            $table->string('reference_type', 100);
            $table->unsignedBigInteger('reference_id');
            $table->string('pdf_url')->nullable();
            $table->string('status', 50)->default('generated')->index();
            $table->dateTime('generated_at')->nullable();
            $table->dateTime('printed_at')->nullable();
            $table->dateTime('signed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['reference_type', 'reference_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('generated_documents');
        Schema::dropIfExists('document_templates');
        Schema::dropIfExists('sales_items');
        Schema::dropIfExists('sales_transactions');
        Schema::dropIfExists('inventory_items');
        Schema::dropIfExists('purchase_items');
        Schema::dropIfExists('purchase_transactions');
        Schema::dropIfExists('sellers');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'avatar_url', 'deleted_at']);
        });
    }
};
