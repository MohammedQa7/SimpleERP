<?php
namespace App\Integrations\Slack;

use App\DTO\IntegrationRevokeResult;
use App\DTO\OAuthDTO;
use App\Exceptions\OAuthProviderException;
use App\Integrations\Contracts\IntegrationAuthenticator;
use App\Jobs\FetchSlackOwnerUser;
use App\Jobs\FetchSlackTeam;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Laravel\Socialite\Socialite;

class SlackOAuth implements IntegrationAuthenticator
{
    function redirect()
    {
        return Socialite::driver('slack')
            ->asBotUser()
            ->setScopes([
                'chat:write',
                'chat:write.public',
                'chat:write.customize',
                'channels:read',
                'groups:read',
                'mpim:read',
                'im:read',
                'users:read',
                'team:read',
            ])
            ->redirect();
    }

    function callback()
    {
        $slack_user = Socialite::driver('slack')->asBotUser()->user();

        if (!is_null($slack_user->token)) {
            return new OAuthDTO(
                provider: 'slack',
                name: $slack_user->getName(),
                email: $slack_user->getEmail(),
                avatar: $slack_user->getAvatar(),
                access_token: $slack_user->token,
                refresh_token: $slack_user->refreshToken,
                expires_at: $slack_user->expiresIn,
                attributes: [
                    ...$slack_user->attributes,
                    'approvedScopes' => $slack_user->approvedScopes
                ]
            );
        }

        // If failed.
        return throw new OAuthProviderException(request()->error_description, 'slack');

    }


    public function revoke()
    {
        $status = Http::asForm()
            ->baseUrl('https://slack.com/api')
            ->withToken(auth()->user()->getConnectecAppToken('slack'))
            ->post('auth.revoke')->json();

        return new IntegrationRevokeResult(
            status: $status['ok'],
            code: $status['code'] ?? null,
            message: $status['ok'] ? $status['revoked'] : $status['error'],
        );

    }


    function dispatchJobs()
    {
        $user_token = auth()->user()->getConnectecAppToken('slack');
        FetchSlackOwnerUser::dispatch($user_token);
        FetchSlackTeam::dispatch($user_token);
    }

}