<?php

namespace App\Listeners;

use DB;
use Laravel\Passport\Token;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Passport\Events\AccessTokenCreated;

class RevokeOldTokens
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AccessTokenCreated $event
     * @return void
     */
    public function handle(AccessTokenCreated $event)
    {
        $accessToken = Token::where('user_id', $event->userId)
            ->where('id', '!=', $event->tokenId)
            ->where('client_id', $event->clientId)
            ->first();

        // 删除旧的 refresh_token
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', optional($accessToken)->id)
            ->delete();
        // 删除旧的 access_token
        optional($accessToken)->delete();
    }
}
