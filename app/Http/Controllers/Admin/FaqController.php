<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use App\Models\Service;
use App\Models\Project;
use App\Services\FaqService;
use App\Http\Requests\Admin\Faq\StoreFaqRequest;
use App\Http\Requests\Admin\Faq\UpdateFaqRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class FaqController extends BaseAdminController
{
    public function __construct(protected FaqService $faqService)
    {
    }

    /**
     * Display a listing of FAQs with optional module filtering.
     */
    public function index(Request $request): View
    {
        $moduleType = $request->get('module_type');
        $query = Faq::with(['translations', 'service.translations', 'project.translations']);

        if (!empty($moduleType) && in_array($moduleType, ['general', 'service', 'project'])) {
            $query->where('module_type', $moduleType);
        }

        $faqs = $query->orderBy('module_type')->orderBy('order')->orderBy('id', 'desc')->paginate(15)->withQueryString();

        return $this->renderView('admin.faqs.index', compact('faqs', 'moduleType'));
    }

    /**
     * Show form for creating a new FAQ.
     */
    public function create(): View
    {
        $services = Service::with('translations')->where('is_active', true)->orderBy('order')->get();
        $projects = Project::with('translations')->orderBy('order')->get();

        return $this->renderView('admin.faqs.create', compact('services', 'projects'));
    }

    /**
     * Store a newly created FAQ in storage.
     */
    public function store(StoreFaqRequest $request): RedirectResponse
    {
        $data = $request->except('_token');
        $data['is_active'] = $request->has('is_active');

        $this->faqService->create($data);

        return $this->redirectSuccess('admin.faqs.index', 'SSS kaydı başarıyla oluşturuldu.');
    }

    /**
     * Show form for editing an existing FAQ.
     */
    public function edit(Faq $faq): View
    {
        $faq->load('translations');
        $services = Service::with('translations')->where('is_active', true)->orderBy('order')->get();
        $projects = Project::with('translations')->orderBy('order')->get();

        return $this->renderView('admin.faqs.edit', compact('faq', 'services', 'projects'));
    }

    /**
     * Update the specified FAQ in storage.
     */
    public function update(UpdateFaqRequest $request, Faq $faq): RedirectResponse
    {
        $data = $request->except(['_token', '_method']);
        $data['is_active'] = $request->has('is_active');

        $this->faqService->update($faq, $data);

        return $this->redirectSuccess('admin.faqs.index', 'SSS kaydı başarıyla güncellendi.');
    }

    /**
     * Remove the specified FAQ from storage.
     */
    public function destroy(Faq $faq): RedirectResponse
    {
        $this->faqService->delete($faq);

        return $this->redirectSuccess('admin.faqs.index', 'SSS kaydı silindi.');
    }
}
