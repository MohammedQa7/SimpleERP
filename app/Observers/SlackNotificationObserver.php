<?php

namespace App\Observers;

use App\Integrations\Slack\Services\SlackService;
use App\Models\SlackNotification;
use Illuminate\Support\Facades\Cache;

class SlackNotificationObserver
{
    /**
     * Handle the SlackNotification "created" event.
     */
    public function created(SlackNotification $slackNotification): void
    {
    }

    /**
     * Handle the SlackNotification "updated" event.
     */
    public function updated(SlackNotification $slackNotification): void
    {
    }

    /**
     * Handle the SlackNotification "deleted" event.
     */
    public function deleted(SlackNotification $slackNotification): void
    {

    }

    /**
     * Handle the SlackNotification "updateOrCreate" event.
     */
    public function saved(SlackNotification $slackNotification): void
    {
        $slack_service = new SlackService();
        Cache::delete($slack_service->getDepartmentChannelsAssignmentCacheKey());
    }
    /**
     * Handle the SlackNotification "restored" event.
     */
    public function restored(SlackNotification $slackNotification): void
    {
        //
    }

    /**
     * Handle the SlackNotification "force deleted" event.
     */
    public function forceDeleted(SlackNotification $slackNotification): void
    {
        //
    }
}