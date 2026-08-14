<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CommentService extends BaseService
{
    protected string $modelClass = Comment::class;

    /**
     * Get paginated comments with blogPost relation eager-loaded.
     */
    public function getPaginatedWithPost(int $perPage = 15): LengthAwarePaginator
    {
        return Comment::with('blogPost')->latest()->paginate($perPage);
    }

    /**
     * Toggle the approval status of a comment.
     */
    public function toggleApprove(Comment $comment): bool
    {
        return $comment->update(['is_approved' => !$comment->is_approved]);
    }
}
