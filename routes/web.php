<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentTemplateController;
use App\Http\Controllers\GeneratedDocumentController;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\PurchaseTransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesTransactionController;
use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::resource('sellers', SellerController::class);
    Route::resource('purchases', PurchaseTransactionController::class);
    Route::post('purchases/{purchase}/cancel', [PurchaseTransactionController::class, 'cancel'])->name('purchases.cancel');
    Route::post('purchases/{purchase}/documents', [PurchaseTransactionController::class, 'generateDocument'])->name('purchases.documents.store');
    Route::resource('inventory', InventoryItemController::class)->parameters(['inventory' => 'inventoryItem'])->only(['index', 'show', 'edit', 'update']);
    Route::resource('sales', SalesTransactionController::class);
    Route::post('sales/{sale}/cancel', [SalesTransactionController::class, 'cancel'])->name('sales.cancel');
    Route::post('sales/{sale}/documents', [SalesTransactionController::class, 'generateDocument'])->name('sales.documents.store');
    Route::resource('document-templates', DocumentTemplateController::class);
    Route::get('documents', [GeneratedDocumentController::class, 'index'])->name('documents.index');
    Route::get('documents/{document}', [GeneratedDocumentController::class, 'show'])->name('documents.show');
    Route::post('documents/{document}/mark', [GeneratedDocumentController::class, 'mark'])->name('documents.mark');
    Route::get('reports/purchases', [ReportController::class, 'purchases'])->name('reports.purchases');
    Route::get('reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
});

require __DIR__.'/settings.php';
