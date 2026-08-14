<?php

namespace App\Http\Controllers\Admin;

use App\Models\SiteModal;
use App\Services\SiteModalService;
use App\Http\Requests\Admin\SiteModal\StoreSiteModalRequest;
use App\Http\Requests\Admin\SiteModal\UpdateSiteModalRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SiteModalController extends BaseAdminController
{
    public function __construct(protected SiteModalService $modalService)
    {
    }

    public function index(): View
    {
        $modals = $this->modalService->getPaginated(10);
        return $this->renderView('admin.site_modals.index', compact('modals'));
    }

    public function create(): View
    {
        return $this->renderView('admin.site_modals.create');
    }

    public function store(StoreSiteModalRequest $request): RedirectResponse
    {
        $data = $request->except(['_token', 'image']);
        $data['is_active'] = $request->has('is_active');

        $this->modalService->create($data, $request->file('image'));

        return $this->redirectSuccess('admin.site-modals.index', 'Duyuru Pop-up penceresi başarıyla oluşturuldu.');
    }

    public function edit(SiteModal $siteModal): View
    {
        return $this->renderView('admin.site_modals.edit', compact('siteModal'));
    }

    public function update(UpdateSiteModalRequest $request, SiteModal $siteModal): RedirectResponse
    {
        $data = $request->except(['_token', '_method', 'image', 'remove_image']);
        $data['is_active'] = $request->has('is_active');

        $this->modalService->update(
            $siteModal,
            $data,
            $request->file('image'),
            $request->has('remove_image')
        );

        return $this->redirectSuccess('admin.site-modals.index', 'Pop-up modal ayarları güncellendi.');
    }

    public function destroy(SiteModal $siteModal): RedirectResponse
    {
        $this->modalService->delete($siteModal);
        return $this->redirectSuccess('admin.site-modals.index', 'Pop-up modal duyurusu silindi.');
    }
}
