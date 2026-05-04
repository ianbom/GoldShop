<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellerStoreRequest;
use App\Http\Requests\SellerUpdateRequest;
use App\Models\Seller;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SellerController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->string('search')->toString();

        return Inertia::render('sellers/index', [
            'filters' => ['search' => $search],
            'sellers' => Seller::query()
                ->when($search, fn ($q) => $q->whereAny(['name', 'nik', 'phone'], 'like', "%$search%"))
                ->latest()->paginate(10)->withQueryString(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('sellers/create');
    }

    public function store(SellerStoreRequest $request, FileUploadService $uploads): RedirectResponse
    {
        $data = $request->validated();
        $data['ktp_photo_url'] = $uploads->image($request->file('ktp_photo'), 'sellers/ktp');
        Seller::create($data);

        return to_route('sellers.index')->with('success', 'Seller saved.');
    }

    public function show(Seller $seller): Response
    {
        return Inertia::render('sellers/show', ['seller' => $seller->load('purchaseTransactions')]);
    }

    public function edit(Seller $seller): Response
    {
        return Inertia::render('sellers/edit', ['seller' => $seller]);
    }

    public function update(SellerUpdateRequest $request, Seller $seller, FileUploadService $uploads): RedirectResponse
    {
        $data = $request->validated();
        if ($request->hasFile('ktp_photo')) {
            $data['ktp_photo_url'] = $uploads->image($request->file('ktp_photo'), 'sellers/ktp');
        }
        $seller->update($data);

        return to_route('sellers.show', $seller)->with('success', 'Seller updated.');
    }

    public function destroy(Seller $seller): RedirectResponse
    {
        $seller->delete();

        return to_route('sellers.index')->with('success', 'Seller deleted.');
    }
}
