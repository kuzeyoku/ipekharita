<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\Category;
use App\Services\ProjectService;
use App\Http\Requests\Admin\Project\StoreProjectRequest;
use App\Http\Requests\Admin\Project\UpdateProjectRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectController extends BaseAdminController
{
    public function __construct(protected ProjectService $projectService)
    {
    }

    public function index(): View
    {
        $projects = Project::with(['categoryRel.translations', 'translations'])->orderBy('order', 'asc')->latest()->paginate(10);
        return $this->renderView('admin.projects.index', compact('projects'));
    }

    public function create(): View
    {
        $categories = Category::where('type', 'project')->where('is_active', true)->orderBy('order')->get();
        return $this->renderView('admin.projects.create', compact('categories'));
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $data = $request->except(['_token', 'image']);
        $data['is_completed'] = $request->has('is_completed');

        $this->projectService->create($data, $request->file('image'));

        return $this->redirectSuccess('admin.projects.index', 'Proje başarıyla eklendi ve görsel WebP formatında kaydedildi.');
    }

    public function edit(Project $project): View
    {
        $categories = Category::where('type', 'project')->where('is_active', true)->orderBy('order')->get();
        return $this->renderView('admin.projects.edit', compact('project', 'categories'));
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $data = $request->except(['_token', '_method', 'image', 'remove_image']);
        $data['is_completed'] = $request->has('is_completed');

        $this->projectService->update(
            $project,
            $data,
            $request->file('image'),
            $request->has('remove_image')
        );

        return $this->redirectSuccess('admin.projects.index', 'Proje bilgileri başarıyla güncellendi.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->projectService->delete($project);
        return $this->redirectSuccess('admin.projects.index', 'Proje ve ilişkili görseli silindi.');
    }
}
