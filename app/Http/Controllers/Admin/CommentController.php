<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CommentController extends BaseAdminController
{
    public function __construct(protected CommentService $commentService)
    {
    }

    public function index(): View
    {
        $comments = $this->commentService->getPaginatedWithPost(15);
        return $this->renderView('admin.comments.index', compact('comments'));
    }

    public function toggleApprove(Comment $comment): RedirectResponse
    {
        $this->commentService->toggleApprove($comment);
        $statusMsg = $comment->is_approved ? 'Yorum onaylandı ve yayına alındı.' : 'Yorum onayı kaldırıldı.';
        return back()->with('success', $statusMsg);
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $this->commentService->delete($comment);
        return $this->redirectSuccess('admin.comments.index', 'Yorum silindi.');
    }
}
