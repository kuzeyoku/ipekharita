<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Message;
use App\Models\Comment;
use App\Models\VisitorStat;

class DashboardService
{
    /**
     * Compile all statistics, unread messages, and visitor metrics for the admin dashboard.
     */
    public function getDashboardData(): array
    {
        $messagesCount = Message::count();
        $unreadMessagesCount = Message::where('is_read', false)->count();
        $unreadMessages = Message::where('is_read', false)->get();
        $recentMessages = Message::latest()->take(5)->get();

        $commentsCount = Comment::count();
        $pendingCommentsCount = Comment::where('is_approved', false)->count();

        $visitorStats = [
            'today'      => VisitorStat::getTodayCount(),
            'todayViews' => VisitorStat::getTodayViews(),
            'week'       => VisitorStat::getWeekCount(),
            'month'      => VisitorStat::getMonthCount(),
            'total'      => VisitorStat::getTotalCount(),
            'totalViews' => VisitorStat::getTotalViews(),
        ];

        $chartData = VisitorStat::getDailyTrendData(7);

        return [
            'messagesCount'        => $messagesCount,
            'unreadMessagesCount'  => $unreadMessagesCount,
            'unreadMessages'       => $unreadMessages,
            'recentMessages'       => $recentMessages,
            'commentsCount'        => $commentsCount,
            'pendingCommentsCount' => $pendingCommentsCount,
            'visitorStats'         => $visitorStats,
            'chartData'            => $chartData,
        ];
    }
}
