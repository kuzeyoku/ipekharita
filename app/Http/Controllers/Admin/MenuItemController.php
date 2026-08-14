<?php

namespace App\Http\Controllers\Admin;

use App\Models\MenuItem;
use App\Services\MenuItemService;
use App\Http\Requests\Admin\MenuItem\StoreMenuItemRequest;
use App\Http\Requests\Admin\MenuItem\UpdateMenuItemRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MenuItemController extends BaseAdminController
{
    public function __construct(protected MenuItemService $menuItemService)
    {
    }

    public function index(): View
    {
        // Auto-seed default menus if table is empty
        if (MenuItem::count() === 0) {
            (new \Database\Seeders\MenuItemSeeder())->run();
        }

        $topMenus = $this->menuItemService->getTopMenus();
        $allParents = $this->menuItemService->getAllParents();

        return $this->renderView('admin.menus.index', compact('topMenus', 'allParents'));
    }

    public function store(StoreMenuItemRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['order'] = $validated['order'] ?? (MenuItem::max('order') + 1);
        $validated['is_active'] = $request->has('is_active');
        $validated['parent_id'] = $request->filled('parent_id') ? $request->parent_id : null;

        $this->menuItemService->create($validated);

        return $this->redirectSuccess('admin.menus.index', 'Menü elemanı başarıyla eklendi.');
    }

    public function update(UpdateMenuItemRequest $request, MenuItem $menu): RedirectResponse
    {
        // Prevent setting self as parent
        if ($request->filled('parent_id') && (int)$request->parent_id === $menu->id) {
            return redirect()->back()->with('error', 'Bir menü kendisinin alt menüsü olamaz.');
        }

        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active');
        $validated['parent_id'] = $request->filled('parent_id') ? $request->parent_id : null;

        $this->menuItemService->update($menu, $validated);

        return $this->redirectSuccess('admin.menus.index', 'Menü elemanı başarıyla güncellendi.');
    }

    public function destroy(MenuItem $menu): RedirectResponse
    {
        $this->menuItemService->delete($menu);

        return $this->redirectSuccess('admin.menus.index', 'Menü elemanı ve varsa alt menüleri silindi.');
    }
}
