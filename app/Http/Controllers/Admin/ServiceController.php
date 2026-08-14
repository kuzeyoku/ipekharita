<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use App\Services\ServiceService;
use App\Http\Requests\Admin\Service\StoreServiceRequest;
use App\Http\Requests\Admin\Service\UpdateServiceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceController extends BaseAdminController
{
    public function __construct(protected ServiceService $serviceService)
    {
    }

    public function index(): View
    {
        $services = $this->serviceService->getPaginated(10, ['translations']);
        return $this->renderView('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        return $this->renderView('admin.services.create');
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $data = $request->except(['_token', 'image']);
        $data['is_active'] = $request->has('is_active');

        $this->serviceService->create($data, $request->file('image'));

        return $this->redirectSuccess('admin.services.index', 'Hizmet başarıyla oluşturuldu ve görseller optimize edildi.');
    }

    public function edit(Service $service): View
    {
        return $this->renderView('admin.services.edit', compact('service'));
    }

    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        $data = $request->except(['_token', '_method', 'image', 'remove_image']);
        $data['is_active'] = $request->has('is_active');

        $this->serviceService->update(
            $service,
            $data,
            $request->file('image'),
            $request->has('remove_image')
        );

        return $this->redirectSuccess('admin.services.index', 'Hizmet bilgileri başarıyla güncellendi.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $this->serviceService->delete($service);
        return $this->redirectSuccess('admin.services.index', 'Hizmet ve ilişkili görseli silindi.');
    }
}
