<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentTemplateStoreRequest;
use App\Http\Requests\DocumentTemplateUpdateRequest;
use App\Models\DocumentTemplate;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class DocumentTemplateController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('document-templates/index', ['templates' => DocumentTemplate::latest()->paginate(10)]);
    }

    public function create(): Response
    {
        return Inertia::render('document-templates/create');
    }

    public function store(DocumentTemplateStoreRequest $request): RedirectResponse
    {
        DocumentTemplate::create($request->validated());

        return to_route('document-templates.index')->with('success', 'Template saved.');
    }

    public function show(DocumentTemplate $documentTemplate): Response
    {
        return Inertia::render('document-templates/edit', ['template' => $documentTemplate]);
    }

    public function edit(DocumentTemplate $documentTemplate): Response
    {
        return Inertia::render('document-templates/edit', ['template' => $documentTemplate]);
    }

    public function update(DocumentTemplateUpdateRequest $request, DocumentTemplate $documentTemplate): RedirectResponse
    {
        $documentTemplate->update($request->validated());

        return to_route('document-templates.index')->with('success', 'Template updated.');
    }

    public function destroy(DocumentTemplate $documentTemplate): RedirectResponse
    {
        $documentTemplate->delete();

        return back()->with('success', 'Template deleted.');
    }
}
