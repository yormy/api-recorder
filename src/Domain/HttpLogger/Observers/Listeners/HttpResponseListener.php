<?php

namespace Yormy\ApiIoTracker\Domain\HttpLogger\Observers\Listeners;

use Yormy\ApiIoTracker\Domain\HttpLogger\Models\LogHttpOutgoing;
use Yormy\ApiIoTracker\Domain\HttpLogger\Services\UrlOnlyExcept;
use Yormy\ApiIoTracker\Domain\User\Services\Resolvers\UserResolver;

class HttpResponseListener
{
    public function handle(object $event): void
    {
        $include = UrlOnlyExcept::shouldIncludeREquest($event->request, config('api-io-tracker.httplogger'));

        if (!$include) {
            return;
        }

        $data = [
            'status' => 'OK',
            'url' => $event->request->url(),
            'method' => $event->request->method(),
            'headers' => $event->request->headers(),
            'body' => $event->request->body(),
            'response' => substr($event->response->body(), 0, 6000),
        ];

        $user = UserResolver::getCurrent();
        if ($user) {
            $data['user_id'] = $user->id;
            $data['user_type'] = get_class($user);
        }

        LogHttpOutgoing::create($data);
    }
}
