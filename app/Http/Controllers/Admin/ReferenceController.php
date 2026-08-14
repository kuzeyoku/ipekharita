<?php

namespace App\Http\Controllers\Admin;

use App\Models\Reference;
use App\Services\ReferenceService;
use App\Http\Requests\Admin\Reference\StoreReferenceRequest;
use App\Http\Requests\Admin\Reference\UpdateReferenceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReferenceController extends BaseAdminController
{
    public function __construct(protected ReferenceService $referenceService)
    {
    }

    public function index(): View
    {
        $references = $this->referenceService->getPaginated(10);
        return $this->renderView('admin.references.index', compact('references'));
    }

    public function create(): View
    {
        return $this->renderView('admin.references.create');
    }

    public function store(StoreReferenceRequest $request): RedirectResponse
    {
        $data = $request->except(['_token', 'image']);
        $data['is_active'] = $request->has('is_active');

        $this->referenceService->create($data, $request->file('image'));

        return $this->redirectSuccess('admin.references.index', 'Referans kurumu başarıyla eklendi.');
    }

    public function edit(Reference $reference): View
    {
        return $this->renderView('admin.references.edit', compact('reference'));
    }

    public function update(UpdateReferenceRequest $request, Reference $reference): RedirectResponse
    {
        $data = $request->except(['_token', '_method', 'image', 'remove_image']);
        $data['is_active'] = $request->has('is_active');

        $this->referenceService->update(
            $reference,
            $data,
            $request->file('image'),
            $request->has('remove_image')
        );

        return $this->redirectSuccess('admin.references.index', 'Referans bilgileri başarıyla güncellendi.');
    }

    public function destroy(Reference $reference): RedirectResponse
    {
        $this->referenceService->delete($reference);
        return $this->redirectSuccess('admin.references.index', 'Referans kaydı silindi.');
    }
}
