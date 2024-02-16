<?php

namespace App\Events;

use App\Services\Api\StatsService as ApiStatsService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Services\StatsService;

class UserSaved
{
    use Dispatchable, SerializesModels;

    public function __construct()
    {
        $statsService = new ApiStatsService();
        $statsService->updateStatsCache();
    }
}