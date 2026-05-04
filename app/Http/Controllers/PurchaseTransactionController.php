<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseTransactionStoreRequest;
use App\Models\DocumentTemplate;
use App\Models\PurchaseTransaction;
use App\Models\Seller;
use App\Services\DocumentService;
use App\Services\PurchaseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PurchaseTransactionController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->string('search')->toString();

        return Inertia::render('purchases/index', [
            'filters' => ['search' => $search],
            'purchases' => PurchaseTransaction::with('seller')
                ->when($search, fn ($q) => $q->where('purchase_number', 'like', "%$search%")->orWhereHas('seller', fn ($s) => $s->whereAny(['name', 'nik'], 'like', "%$search%")))
                ->latest()->paginate(10)->withQueryString(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('purchases/create', ['sellers' => Seller::orderBy('name')->get(['id', 'name', 'nik', 'phone'])]);
    }

    public function store(PurchaseTransactionStoreRequest $request, PurchaseService $service): RedirectResponse
    {
        $purchase = $service->create($request->validated(), $request->user()->id);

        return to_route('purchases.show', $purchase)->with('success', 'Purchase saved.');
    }

    public function show(PurchaseTransaction $purchase): Response
    {
        return Inertia::render('purchases/show', [
            'purchase' => $purchase->load(['seller', 'admin', 'items.inventoryItem']),
            'templates' => DocumentTemplate::where('is_active', true)->whereIn('document_type', ['purchase_invoice', 'purchase_agreement', 'goods_receipt'])->get(),
            'documents' => $purchase->documents()->with('template')->latest()->get(),
        ]);
    }

    public function edit(PurchaseTransaction $purchase): Response
    {
        return Inertia::render('purchases/edit', ['purchase' => $purchase->load('items'), 'sellers' => Seller::orderBy('name')->get()]);
    }

    public function update(): RedirectResponse
    {
        abort(422, 'Draft edit not implemented in MVP.');
    }

    public function destroy(PurchaseTransaction $purchase): RedirectResponse
    {
        $purchase->delete();

        return to_route('purchases.index')->with('success', 'Purchase deleted.');
    }

    public function cancel(PurchaseTransaction $purchase, PurchaseService $service): RedirectResponse
    {
        $service->cancel($purchase);

        return back()->with('success', 'Purchase cancelled.');
    }

    public function generateDocument(Request $request, PurchaseTransaction $purchase, DocumentService $service): RedirectResponse
    {
        $data = $request->validate(['document_template_id' => ['required', 'exists:document_templates,id']]);
        $service->generate(DocumentTemplate::findOrFail($data['document_template_id']), $purchase, $request->user()->id);

        return back()->with('success', 'Document generated.');
    }
}
