<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesTransactionStoreRequest;
use App\Models\DocumentTemplate;
use App\Models\InventoryItem;
use App\Models\SalesTransaction;
use App\Services\DocumentService;
use App\Services\SaleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SalesTransactionController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->string('search')->toString();

        return Inertia::render('sales/index', [
            'filters' => ['search' => $search],
            'sales' => SalesTransaction::query()
                ->when($search, fn ($q) => $q->whereAny(['sales_number', 'buyer_name', 'buyer_phone'], 'like', "%$search%"))
                ->latest()->paginate(10)->withQueryString(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('sales/create', ['inventory' => InventoryItem::where('status', 'available')->orderBy('sku')->get()]);
    }

    public function store(SalesTransactionStoreRequest $request, SaleService $service): RedirectResponse
    {
        $sale = $service->create($request->validated(), $request->user()->id);

        return to_route('sales.show', $sale)->with('success', 'Sale saved.');
    }

    public function show(SalesTransaction $sale): Response
    {
        return Inertia::render('sales/show', [
            'sale' => $sale->load(['admin', 'items.inventoryItem']),
            'templates' => DocumentTemplate::where('is_active', true)->where('document_type', 'sales_invoice')->get(),
            'documents' => $sale->documents()->with('template')->latest()->get(),
        ]);
    }

    public function edit(SalesTransaction $sale): Response
    {
        return Inertia::render('sales/edit', ['sale' => $sale->load('items')]);
    }

    public function update(): RedirectResponse
    {
        abort(422, 'Draft edit not implemented in MVP.');
    }

    public function destroy(SalesTransaction $sale): RedirectResponse
    {
        $sale->delete();

        return to_route('sales.index')->with('success', 'Sale deleted.');
    }

    public function cancel(SalesTransaction $sale, SaleService $service): RedirectResponse
    {
        $service->cancel($sale);

        return back()->with('success', 'Sale cancelled.');
    }

    public function generateDocument(Request $request, SalesTransaction $sale, DocumentService $service): RedirectResponse
    {
        $data = $request->validate(['document_template_id' => ['required', 'exists:document_templates,id']]);
        $service->generate(DocumentTemplate::findOrFail($data['document_template_id']), $sale, $request->user()->id);

        return back()->with('success', 'Document generated.');
    }
}
