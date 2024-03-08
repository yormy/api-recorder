<?php

namespace Yormy\ApiRecorder\Services\Resolvers;

use Jenssegers\Agent\Agent;

class UserAgentResolver
{
    public static function get(): string
    {
        $agent = new Agent();
        $platform = $agent->platform();
        $userAgent = $platform.' '.$agent->version($platform);

        $browser = $agent->browser();
        $userAgent .= $browser.' '.$agent->version($browser);

        return $userAgent;
    }
}
