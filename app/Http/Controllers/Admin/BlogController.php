<?php

namespace App\Http\Controllers\Admin;

use App\Models\BlogPost;
use App\Models\Category;
use App\Services\BlogService;
use App\Http\Requests\Admin\Blog\StoreBlogRequest;
use App\Http\Requests\Admin\Blog\UpdateBlogRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BlogController extends BaseAdminController
{
    public function __construct(protected BlogService $blogService)
    {
    }

    public function index(): View
    {
        $posts = BlogPost::with(['category.translations', 'translations'])->latest()->paginate(10);
        return $this->renderView('admin.blog.index', compact('posts'));
    }

    public function create(): View
    {
        $categories = Category::where('type', 'blog')->where('is_active', true)->orderBy('order')->get();
        return $this->renderView('admin.blog.create', compact('categories'));
    }

    public function store(StoreBlogRequest $request): RedirectResponse
    {
        $data = $request->except(['_token', 'image']);
        $data['is_published'] = $request->has('is_published');
        $data['published_at'] = $data['is_published'] ? now() : null;

        $this->blogService->create($data, $request->file('image'));

        return $this->redirectSuccess('admin.blog.index', 'Blog makalesi yayınlandı ve görsel WebP formatında kaydedildi.');
    }

    public function edit(BlogPost $blog): View
    {
        $categories = Category::where('type', 'blog')->where('is_active', true)->orderBy('order')->get();
        return $this->renderView('admin.blog.edit', compact('blog', 'categories'));
    }

    public function update(UpdateBlogRequest $request, BlogPost $blog): RedirectResponse
    {
        $data = $request->except(['_token', '_method', 'image', 'remove_image']);
        $data['is_published'] = $request->has('is_published');

        $this->blogService->update(
            $blog,
            $data,
            $request->file('image'),
            $request->has('remove_image')
        );

        return $this->redirectSuccess('admin.blog.index', 'Blog makalesi başarıyla güncellendi.');
    }

    public function destroy(BlogPost $blog): RedirectResponse
    {
        $this->blogService->delete($blog);
        return $this->redirectSuccess('admin.blog.index', 'Blog yazısı ve görseli silindi.');
    }
}
