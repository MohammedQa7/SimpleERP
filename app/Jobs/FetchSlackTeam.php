<?php

namespace App\Jobs;

use App\Integrations\Slack\Services\SlackService;
use App\Models\ConnectedApp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FetchSlackTeam implements ShouldQueue
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

            $slack_team = $slack_service->token($this->token)->getTeamInformation();
            $formatted_team_data =
                [
                    'id' => $slack_team['id'],
                    'name' => $slack_team['name'],
                    'url' => $slack_team['url'] ?? null,
                    'is_verified' => $slack_team['is_verified'],
                    'avatar' => $slack_team['icon']['image_68'],
                ];

            // Save the owners data in the DB;
            $connectedApp = ConnectedApp::where('access_token', $this->token)->firstOrFail();
            $connectedApp->update([
                'meta' => array_merge(
                    $connectedApp->meta ?? [],
                    [
                        'slack_team' => [...$formatted_team_data],
                    ]
                ),
            ]);

            DB::commit();
            Log::info('Slack team has been retrived and saved');
        } catch (\Throwable $th) {
            Log::error('Something went wrong while trying to get the teams info from slack api. Reason: ' . $th->getMessage() ?? 'no message was provided');
            DB::rollBack();
            throw $th;
        }
    }
}