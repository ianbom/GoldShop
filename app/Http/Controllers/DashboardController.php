<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\PurchaseTransaction;
use App\Models\SalesTransaction;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $soldCost = InventoryItem::where('status', 'sold')->sum('purchase_price');
        $salesTotal = SalesTransaction::where('status', 'completed')->sum('total_amount');

        return Inertia::render('dashboard', [
            'stats' => [
                'availableItems' => InventoryItem::where('status', 'available')->count(),
                'soldItems' => InventoryItem::where('status', 'sold')->count(),
                'purchaseTransactions' => PurchaseTransaction::count(),
                'salesTransactions' => SalesTransaction::count(),
                'purchaseValue' => PurchaseTransaction::where('status', 'completed')->sum('total_amount'),
                'salesValue' => $salesTotal,
                'estimatedProfit' => $salesTotal - $soldCost,
            ],
            'recentPurchases' => PurchaseTransaction::with('seller')->latest()->limit(5)->get(),
            'recentSales' => SalesTransaction::latest()->limit(5)->get(),
            'recentInventory' => InventoryItem::latest()->limit(5)->get(),
        ]);
    }
}
