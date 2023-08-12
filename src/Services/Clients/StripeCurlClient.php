<?php

namespace Yormy\ApiIoTracker\Services\Clients;

use Yormy\ApiIoTracker\Observers\Events\PlainRequestEvent;

class StripeCurlClient extends \Stripe\HttpClient\CurlClient
{
    public function request($method, $absUrl, $headers, $params, $hasFile)
    {
        event(new PlainRequestEvent($method, $absUrl, $headers, $params, $hasFile));
        return parent::request($method, $absUrl, $headers, $params, $hasFile);
    }
}
