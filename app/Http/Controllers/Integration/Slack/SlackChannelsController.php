<?php

namespace App\Http\Controllers\Integration\Slack;

use App\Http\Controllers\Controller;
use App\Http\Requests\SlackNotificationRequest;
use App\Http\Resources\SlackResources\SlackChannelResource;
use App\Integrations\Slack\Services\SlackService;
use App\Models\SlackNotification;
use App\Traits\InertiaFlashMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class SlackChannelsController extends Controller
{
    use InertiaFlashMessage;
    function index(Request $request, SlackService $slack_service)
    {
        try {
            $channels = $slack_service
                ->token(auth()->user()->getConnectecAppToken('slack'))
                ->getChannels();


            if ($request->hasHeader('X-Inertia')) {
                return Inertia::render('settings/ConnectedApps', [
                    'channels' => SlackChannelResource::collection($channels),
                ]);
            }

            response()->json([
                'channels' => SlackChannelResource::collection($channels),
            ]);
        } catch (\Throwable $th) {
            Log::error('Something went wrong while fetching slack data from API');
            $this->error('Something went wrong while fetching slack channels');
            throw $th;
        }
    }

    function store(SlackNotificationRequest $request)
    {
        try {
            foreach ($request->assignedDepartmentChannels as $value) {
                $fluent_data = fluent($value);

                SlackNotification::updateOrCreate(
                    [
                        'department' => $fluent_data->department,
                        'channel_id' => $fluent_data->channelId,
                    ],
                    [
                        'department' => $fluent_data->department,
                        'channel_id' => $fluent_data->channelId,
                        'channel_name' => $fluent_data->channelName
                    ]
                );
            }
            $this->success("All selected departments have been linked with thier channels successfully :)");
            return Inertia::render('settings/ConnectedApps');
        } catch (\Throwable $th) {
            dd($th);
            Log::error('Something went wrong while attaching department to a slack channel');
            $this->error('Something went wrong while attaching department -> channel');
            return Inertia::render('settings/ConnectedApps');
        }

    }

    function update(SlackNotification $channel)
    {

    }

    function destroy(SlackNotification $channel)
    {

    }
}