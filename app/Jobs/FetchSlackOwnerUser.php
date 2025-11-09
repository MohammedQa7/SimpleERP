<?php

namespace App\Jobs;

use App\Integrations\Slack\Services\SlackService;
use App\Models\ConnectedApp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FetchSlackOwnerUser implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    protected $token;
    public $tries = 5;
    public function __construct($token)
    {
        $this->token = $token;
    }

    public function backoff(): array
    {
        return [30, 60, 120];
    }


    /**
     * Execute the job.
     */
    public function handle(SlackService $slack_service): void
    {
        try {
            DB::beginTransaction();

            $slack_members = $slack_service->token($this->token)->getUsers();
            $slack_owner = collect($slack_members['members'])->first(function ($user) {
                return $user['is_primary_owner'] == true;
            });

            $formatted_user_data = $slack_owner
                ? [
                    'id' => $slack_owner['id'],
                    'name' => $slack_owner['name'],
                    'is_primary_owner' => $slack_owner['is_primary_owner'] ?? false,
                    'is_email_confirmed' => $slack_owner['is_email_confirmed'] ?? false,
                    'team_id' => $slack_owner['team_id'] ?? null,
                    'avatar' => $slack_owner['profile']['image_48'],
                ]
                : null;

            // Save the owners data in the DB;
            $connectedApp = ConnectedApp::where('access_token', $this->token)->firstOrFail();
            $connectedApp->update([
                'meta' => array_merge(
                    $connectedApp->meta ?? [],
                    [
                        'slack_owner' => [...$formatted_user_data],
                    ]
                ),
            ]);

            DB::commit();
            Log::info('Slack users has been retrived and saved');
        } catch (\Throwable $th) {
            Log::error('Something went wrong while trying to get the users info from slack api. Reason: ' . $th->getMessage() ?? 'no message was provided');
            DB::rollBack();
            throw $th;
        }
    }
}