<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Services\PageService;
use App\Http\Requests\Admin\Page\StorePageRequest;
use App\Http\Requests\Admin\Page\UpdatePageRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageController extends BaseAdminController
{
    public function __construct(protected PageService $pageService)
    {
    }

    public function index(): View
    {
        $pages = $this->pageService->getPaginated(10, ['translations']);
        return $this->renderView('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        return $this->renderView('admin.pages.create');
    }

    public function store(StorePageRequest $request): RedirectResponse
    {
        $data = $request->except(['_token', 'image']);
        $data['is_active'] = $request->has('is_active');

        $this->pageService->create($data, $request->file('image'));

        return $this->redirectSuccess('admin.pages.index', 'Sabit sayfa başarıyla oluşturuldu.');
    }

    public function edit(Page $page): View
    {
        return $this->renderView('admin.pages.edit', compact('page'));
    }

    public function update(UpdatePageRequest $request, Page $page): RedirectResponse
    {
        $data = $request->except(['_token', '_method', 'image', 'remove_image']);
        $data['is_active'] = $request->has('is_active');

        $this->pageService->update(
            $page,
            $data,
            $request->file('image'),
            $request->has('remove_image')
        );

        return $this->redirectSuccess('admin.pages.index', 'Sabit sayfa bilgileri başarıyla güncellendi.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        $this->pageService->delete($page);
        return $this->redirectSuccess('admin.pages.index', 'Sabit sayfa başarıyla silindi.');
    }
}
