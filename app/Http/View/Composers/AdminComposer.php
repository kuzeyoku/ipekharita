<?php

declare(strict_types=1);

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Comment;
use App\Models\Message;
use App\Services\TranslationService;

class AdminComposer
{
    public function __construct(protected TranslationService $translationService)
    {
    }

    /**
     * Bind administrative counter and active locales data to the admin views.
     */
    public function compose(View $view): void
    {
        $pendingCommentsCount = Comment::where('is_approved', false)->count();
        $unreadMessagesCount = Message::where('is_read', false)->count();
        $activeLocales = $this->translationService->getAvailableLocales();

        $view->with([
            'pendingCommentsCount' => $pendingCommentsCount,
            'unreadMessagesCount'  => $unreadMessagesCount,
            'activeLocales'        => $activeLocales,
        ]);
    }
}
