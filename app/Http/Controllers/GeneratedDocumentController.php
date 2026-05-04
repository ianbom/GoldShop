<?php

namespace App\Http\Controllers;

use App\Models\GeneratedDocument;
use App\Services\DocumentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GeneratedDocumentController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('generated-documents/index', ['documents' => GeneratedDocument::with(['template', 'generatedBy'])->latest()->paginate(10)]);
    }

    public function show(GeneratedDocument $document): Response
    {
        return Inertia::render('generated-documents/show', ['document' => $document->load(['template', 'generatedBy'])]);
    }

    public function mark(Request $request, GeneratedDocument $document, DocumentService $service): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', 'in:printed,signed']]);
        $service->mark($document, $data['status']);

        return back()->with('success', 'Document marked.');
    }
}
