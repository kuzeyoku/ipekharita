<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VisitorStat extends Model
{
    protected $fillable = ['date', 'views', 'unique_visitors'];

    /**
     * Record a visit (0 overhead, single indexed query)
     */
    public static function recordHit(bool $isUnique = false): void
    {
        $todayStr = Carbon::today()->format('Y-m-d');
        
        try {
            $stat = static::firstOrCreate(
                ['date' => $todayStr],
                ['views' => 0, 'unique_visitors' => 0]
            );

            $stat->increment('views');

            if ($isUnique) {
                $stat->increment('unique_visitors');
            }
        } catch (\Throwable $e) {
            // Ignore DB write locks gracefully
        }
    }

    public static function getTodayCount(): int
    {
        $todayStr = Carbon::today()->format('Y-m-d');
        return (int) (static::where('date', $todayStr)->value('unique_visitors') ?? 0);
    }

    public static function getTodayViews(): int
    {
        $todayStr = Carbon::today()->format('Y-m-d');
        return (int) (static::where('date', $todayStr)->value('views') ?? 0);
    }

    public static function getWeekCount(): int
    {
        $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');

        return (int) (static::whereBetween('date', [$startOfWeek, $endOfWeek])->sum('unique_visitors') ?? 0);
    }

    public static function getMonthCount(): int
    {
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');

        return (int) (static::whereBetween('date', [$startOfMonth, $endOfMonth])->sum('unique_visitors') ?? 0);
    }

    public static function getTotalCount(): int
    {
        return (int) (static::sum('unique_visitors') ?? 0);
    }

    public static function getTotalViews(): int
    {
        return (int) (static::sum('views') ?? 0);
    }

    /**
     * Get daily trend analytics for the last N days (for Chart.js)
     */
    public static function getDailyTrendData(int $days = 7): array
    {
        $labels = [];
        $viewsData = [];
        $uniqueData = [];

        $turkishMonths = [
            1 => 'Oca', 2 => 'Şub', 3 => 'Mar', 4 => 'Nis', 5 => 'May', 6 => 'Haz',
            7 => 'Tem', 8 => 'Ağu', 9 => 'Eyl', 10 => 'Eki', 11 => 'Kas', 12 => 'Ara'
        ];

        $startDate = Carbon::today()->subDays($days - 1)->format('Y-m-d');
        $endDate = Carbon::today()->format('Y-m-d');

        $records = static::whereBetween('date', [$startDate, $endDate])
            ->get()
            ->keyBy('date');

        for ($i = $days - 1; $i >= 0; $i--) {
            $dateObj = Carbon::today()->subDays($i);
            $dateStr = $dateObj->format('Y-m-d');
            $label = $dateObj->format('j') . ' ' . ($turkishMonths[$dateObj->month] ?? '');

            $record = $records->get($dateStr);

            $labels[] = $label;
            $viewsData[] = $record ? (int) $record->views : 0;
            $uniqueData[] = $record ? (int) $record->unique_visitors : 0;
        }

        return [
            'labels' => $labels,
            'views' => $viewsData,
            'unique' => $uniqueData,
        ];
    }
}
