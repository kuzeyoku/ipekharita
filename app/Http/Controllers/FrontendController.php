<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Project;
use App\Models\BlogPost;
use App\Models\Reference;
use App\Models\SiteModal;
use App\Models\Category;
use App\Models\Page;
use App\Models\Faq;
use App\Services\CommentService;
use App\Services\MessageService;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function __construct(
        protected CommentService $commentService,
        protected MessageService $messageService
    ) {
    }

    /**
     * Display the homepage.
     */
    public function index(): View
    {
        $services = Service::with('translations')->active()->ordered()->get();
        $projects = Project::with('translations')->ordered()->take(3)->get();
        $posts = BlogPost::with('translations')->latest()->take(3)->get();
        $references = Reference::active()->ordered()->get();
        $activeModal = SiteModal::with('translations')->active()->latest()->first();

        return view('frontend.index', compact('services', 'projects', 'posts', 'references', 'activeModal'));
    }

    /**
     * Display the about us page.
     */
    public function about(): View
    {
        $references = Reference::active()->ordered()->get();
        return view('frontend.about', compact('references'));
    }

    /**
     * Display the services listing page with module-specific FAQs.
     */
    public function services(): View
    {
        $services = Service::with('translations')->active()->ordered()->get();
        $faqs = Faq::with('translations')->active()->forModule('service')->ordered()->get();

        return view('frontend.services', compact('services', 'faqs'));
    }

    /**
     * Display the service detail page with service-specific or general FAQs.
     */
    public function serviceDetail(?string $slug = null): View|RedirectResponse
    {
        if (empty($slug)) {
            return redirect()->route('services');
        }

        $service = Service::with('translations')->whereSlug($slug)->first();

        if (!$service) {
            return redirect()->route('services');
        }

        $allServices = Service::with('translations')->active()->ordered()->get();
        $otherServices = $allServices;
        $faqs = Faq::with('translations')->active()->forModule('service', $service->id)->ordered()->get();

        return view('frontend.service-detail', compact('service', 'allServices', 'otherServices', 'faqs'));
    }

    /**
     * Display the projects listing page with optional category filtering and project FAQs.
     */
    public function projects(Request $request): View
    {
        $categories = Category::with('translations')
            ->where('type', 'project')
            ->active()
            ->ordered()
            ->get();

        $selectedCatSlug = $request->get('category') ?? $request->get('kategori');
        $selectedCategory = null;

        $query = Project::with(['categoryRel.translations', 'translations'])
            ->orderBy('order', 'asc')
            ->latest();

        if ($selectedCatSlug) {
            $selectedCategory = Category::with('translations')
                ->whereSlug($selectedCatSlug)
                ->where('type', 'project')
                ->first();

            if ($selectedCategory) {
                $query->where('category_id', $selectedCategory->id);
            }
        }

        $projects = $query->get();
        $references = Reference::active()->ordered()->get();
        $faqs = Faq::with('translations')->active()->forModule('project')->ordered()->get();

        return view('frontend.projects', compact('projects', 'categories', 'selectedCatSlug', 'selectedCategory', 'references', 'faqs'));
    }

    /**
     * Display the project detail page.
     */
    public function projectDetail(?string $slug = null): View|RedirectResponse
    {
        if (empty($slug)) {
            return redirect()->route('projects');
        }

        $project = Project::with('translations')->whereSlug($slug)->first();

        if (!$project) {
            return redirect()->route('projects');
        }

        $faqs = Faq::with('translations')->active()->forModule('project', $project->id)->ordered()->get();

        return view('frontend.project-detail', compact('project', 'faqs'));
    }

    /**
     * Display the blog listing page with pagination and optional category filtering.
     */
    public function blog(Request $request): View
    {
        $categories = Category::with('translations')
            ->where('type', 'blog')
            ->active()
            ->ordered()
            ->get();

        $selectedCatSlug = $request->get('category') ?? $request->get('kategori');
        $selectedCategory = null;

        $query = BlogPost::with(['category.translations', 'translations', 'approvedComments'])
            ->where('is_published', true)
            ->latest();

        if ($selectedCatSlug) {
            $selectedCategory = Category::with('translations')
                ->whereSlug($selectedCatSlug)
                ->where('type', 'blog')
                ->first();

            if ($selectedCategory) {
                $query->where('category_id', $selectedCategory->id);
            }
        }

        $posts = $query->paginate(9)->withQueryString();

        return view('frontend.blog', compact('posts', 'categories', 'selectedCatSlug', 'selectedCategory'));
    }

    /**
     * Display the blog post detail page.
     */
    public function blogDetail(?string $slug = null): View|RedirectResponse
    {
        if (empty($slug)) {
            return redirect()->route('blog');
        }

        $post = BlogPost::with(['translations', 'approvedComments'])->whereSlug($slug)->first();

        if (!$post) {
            return redirect()->route('blog');
        }

        return view('frontend.blog-detail', compact('post'));
    }

    /**
     * Store a user comment on a blog post.
     */
    public function storeComment(StoreCommentRequest $request, string $slug): RedirectResponse
    {
        $post = BlogPost::whereSlug($slug)->firstOrFail();
        $validated = $request->validatedClean();

        $validated['blog_post_id'] = $post->id;
        $validated['ip_address'] = $request->ip();
        $validated['is_approved'] = false;

        $this->commentService->create($validated);

        return back()->with('success', __('Yorumunuz başarıyla gönderildi. Yönetici onayından sonra yayınlanacaktır.'));
    }

    /**
     * Display the contact & quote page.
     */
    public function contact(): View
    {
        $services = Service::with('translations')->active()->ordered()->get();
        return view('frontend.contact', compact('services'));
    }

    /**
     * Store a general contact message.
     */
    public function storeMessage(StoreMessageRequest $request): RedirectResponse
    {
        $validated = $request->validatedClean();

        $this->messageService->create($validated);

        return back()->with('success', __('Mesajınız başarıyla iletilmiştir. Yetkili mühendislerimiz en kısa sürede dönüş yapacaktır.'));
    }

    /**
     * Store a project quote request.
     */
    public function storeQuote(StoreQuoteRequest $request): RedirectResponse
    {
        $validated = $request->validatedClean();

        $this->messageService->create($validated);

        return back()->with('success', __('Teklif talebiniz başarıyla alınmıştır. Proje mühendislerimiz teknik şartname doğrultusunda sizinle irtibata geçecektir.'));
    }

    /**
     * Display static/custom pages (KVKK, Privacy Policy, etc.).
     */
    public function pageDetail(?string $slug = null): View|RedirectResponse
    {
        if (empty($slug)) {
            return redirect()->route('home');
        }

        $page = Page::with('translations')->whereSlug($slug)->active()->first();

        if (!$page) {
            return redirect()->route('home');
        }

        return view('frontend.page-detail', compact('page'));
    }
}
