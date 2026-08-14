<?php

namespace App\Http\Controllers\Admin;

use App\Models\Message;
use App\Services\MessageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MessageController extends BaseAdminController
{
    public function __construct(protected MessageService $messageService)
    {
    }

    public function index(): View
    {
        $messages = $this->messageService->getPaginatedMessages(15);
        return $this->renderView('admin.messages.index', compact('messages'));
    }

    public function show(Message $message): View
    {
        $this->messageService->markAsRead($message);
        return $this->renderView('admin.messages.show', compact('message'));
    }

    public function destroy(Message $message): RedirectResponse
    {
        $this->messageService->delete($message);
        return $this->redirectSuccess('admin.messages.index', 'Mesaj kaydı silindi.');
    }
}
