<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\PurchaseTransaction;
use App\Models\SalesTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ReportController extends Controller
{
    public function purchases(Request $request): Response
    {
        $query = PurchaseTransaction::with('seller')->withCount('items')->when($request->filled('from'), fn ($q) => $q->whereDate('transaction_date', '>=', $request->from))->when($request->filled('to'), fn ($q) => $q->whereDate('transaction_date', '<=', $request->to))->when($request->filled('status'), fn ($q) => $q->where('status', $request->status));

        return Inertia::render('reports/purchases', ['rows' => (clone $query)->latest()->paginate(15)->withQueryString(), 'total' => (clone $query)->sum('total_amount'), 'filters' => $request->only(['from', 'to', 'status'])]);
    }

    public function sales(Request $request): Response
    {
        $query = SalesTransaction::withCount('items')->when($request->filled('from'), fn ($q) => $q->whereDate('transaction_date', '>=', $request->from))->when($request->filled('to'), fn ($q) => $q->whereDate('transaction_date', '<=', $request->to))->when($request->filled('status'), fn ($q) => $q->where('status', $request->status));

        return Inertia::render('reports/sales', ['rows' => (clone $query)->latest()->paginate(15)->withQueryString(), 'total' => (clone $query)->sum('total_amount'), 'filters' => $request->only(['from', 'to', 'status'])]);
    }

    public function inventory(Request $request): Response
    {
        $query = InventoryItem::query()->when($request->filled('from'), fn ($q) => $q->whereDate('acquired_at', '>=', $request->from))->when($request->filled('to'), fn ($q) => $q->whereDate('acquired_at', '<=', $request->to))->when($request->filled('status'), fn ($q) => $q->where('status', $request->status));

        return Inertia::render('reports/inventory', ['rows' => (clone $query)->latest()->paginate(15)->withQueryString(), 'available' => (clone $query)->where('status', 'available')->count(), 'sold' => (clone $query)->where('status', 'sold')->count(), 'filters' => $request->only(['from', 'to', 'status'])]);
    }
}
