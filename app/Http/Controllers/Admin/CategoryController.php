<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Services\CategoryService;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends BaseAdminController
{
    public function __construct(protected CategoryService $categoryService)
    {
    }

    public function index(Request $request): View
    {
        $type = $request->get('type');
        $query = Category::with('translations');

        if ($type) {
            $query->where('type', $type);
        }

        $categories = $query->orderBy('type')->orderBy('order')->paginate(15);
        return $this->renderView('admin.categories.index', compact('categories', 'type'));
    }

    public function create(): View
    {
        return $this->renderView('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data = $request->except('_token');
        $data['is_active'] = $request->has('is_active');

        $this->categoryService->create($data);

        return $this->redirectSuccess('admin.categories.index', 'Kategori başarıyla oluşturuldu.');
    }

    public function edit(Category $category): View
    {
        return $this->renderView('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->except(['_token', '_method']);
        $data['is_active'] = $request->has('is_active');

        $this->categoryService->update($category, $data);

        return $this->redirectSuccess('admin.categories.index', 'Kategori güncellendi.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->categoryService->delete($category);
        return $this->redirectSuccess('admin.categories.index', 'Kategori silindi.');
    }
}
