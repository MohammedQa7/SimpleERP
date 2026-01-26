<?php

namespace App\Integrations\Slack\Services;

use App\Enums\Departments;
use App\Http\Resources\SlackNotificationResource;
use App\Http\Resources\SlackResources\SlackChannelResource;
use App\Http\Resources\SlackResources\SlackTeamResource;
use App\Http\Resources\SlackResources\SlackUserResource;
use App\Integrations\Contracts\IntegrarionProvider;
use App\Models\SlackNotification;
use App\Notifications\SlackChannelNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class SlackService extends IntegrarionProvider
{

    protected ?string $token = null;
    private string $settings_cache = 'integration:slack:settings';
    private string $channels_cache = 'integration:slack:channel';
    private string $department_channel_assignment_cache = 'integration:slack:department-channel-assignment';
    function token($token)
    {
        $this->token = $token;
        return $this;
    }

    protected function client()
    {
        if (!$this->token) {
            throw new \Exception('Slack token is not set.');
        }

        return Http::baseUrl('https://slack.com/api')
            ->withToken($this->token)
            ->asForm();
    }

    function getChannels()
    {
        $channels = Cache::remember($this->channels_cache, now()->addHours(24), function () {
            return $this->client()->get('conversations.list')->json();
        });

        if (!$channels['ok']) {
            Log::error('Error while fetching slack channels, reason: ' . $channels['error']);
            throw new \Exception($channels['error']);
        }
        return $channels['channels'];
    }

    function getUsers()
    {
        $users = $this->client()->get('users.list')->json();

        if (!$users['ok']) {
            throw new \Exception($users['error']);
        }

        return $users;
    }

    function getTeamInformation()
    {
        $team_info = $this->client()->get('team.info')->json();

        if (!$team_info['ok']) {
            throw new \Exception($team_info['error']);
        }

        return $team_info['team'];
    }

    function postMessage(string|array $channel, $text, $header)
    {
        if (is_array($channel) && sizeof($channel) > 0) {
            foreach ($channel as $single_channel) {
                return auth()->user()->notify(new SlackChannelNotification($single_channel, text: $text, header: $header));
            }
        } else {
            return auth()->user()->notify(new SlackChannelNotification($channel, text: $text, header: $header));
        }
    }

    function getAssignedDepartmentsToChannels()
    {
        $slack_notificaion = Cache::remember($this->department_channel_assignment_cache, now()->addHours(24), function () {
            return SlackNotification::get();
        });
        return SlackNotificationResource::collection($slack_notificaion);
    }

    function getSettingsCacheKey()
    {
        return $this->settings_cache;
    }
    function getChannelsCacheKey()
    {
        return $this->channels_cache;
    }
    function getDepartmentChannelsAssignmentCacheKey()
    {
        return $this->department_channel_assignment_cache;
    }

    function hasSettings(): bool
    {
        return true;
    }
    function settings(): array
    {
        Log::info('preparing Slack settings Data');

        $slack_account_info = Cache::remember($this->settings_cache, now()->addDays(2), function () {
            return auth()->user()->connectedApps()->where('service', 'slack')
                ->select('meta')
                ->firstOrFail();
        });

        return [
            'slackUserData' => new SlackUserResource($slack_account_info->meta['slack_owner']),
            'slackTeamData' => new SlackTeamResource($slack_account_info->meta['slack_team']),
            'slackChannelData' => Cache::has($this->channels_cache) ? SlackChannelResource::collection($this->getChannels()) : null,
            'departmentChannelAssignments' => $this->getAssignedDepartmentsToChannels(),
            'departments' => Departments::toArray(),
        ];
    }


}