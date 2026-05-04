<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryItemUpdateRequest;
use App\Models\InventoryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class InventoryItemController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->string('search')->toString();

        return Inertia::render('inventory/index', [
            'filters' => $request->only(['search', 'status', 'item_type', 'gold_carat']),
            'items' => InventoryItem::query()
                ->when($search, fn ($q) => $q->whereAny(['sku', 'item_name', 'item_type'], 'like', "%$search%"))
                ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
                ->when($request->filled('item_type'), fn ($q) => $q->where('item_type', $request->item_type))
                ->when($request->filled('gold_carat'), fn ($q) => $q->where('gold_carat', $request->gold_carat))
                ->latest()->paginate(10)->withQueryString(),
        ]);
    }

    public function show(InventoryItem $inventoryItem): Response
    {
        return Inertia::render('inventory/show', ['item' => $inventoryItem->load('purchaseItem.purchaseTransaction.seller')]);
    }

    public function edit(InventoryItem $inventoryItem): Response
    {
        return Inertia::render('inventory/edit', ['item' => $inventoryItem]);
    }

    public function update(InventoryItemUpdateRequest $request, InventoryItem $inventoryItem): RedirectResponse
    {
        $data = $request->validated();
        $data['sold_at'] = $data['status'] === 'sold' ? ($inventoryItem->sold_at ?: now()) : null;
        $inventoryItem->update($data);

        return to_route('inventory.show', $inventoryItem)->with('success', 'Inventory updated.');
    }
}
