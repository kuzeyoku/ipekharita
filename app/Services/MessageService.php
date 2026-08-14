<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Message;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MessageService extends BaseService
{
    protected string $modelClass = Message::class;

    /**
     * Get paginated messages ordered by latest.
     */
    public function getPaginatedMessages(int $perPage = 15): LengthAwarePaginator
    {
        return Message::latest()->paginate($perPage);
    }

    /**
     * Mark a message as read if unread.
     */
    public function markAsRead(Message $message): void
    {
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }
    }
}
