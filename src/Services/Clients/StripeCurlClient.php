<?php

namespace Yormy\ApiIoTracker\Services\Clients;

use Yormy\ApiIoTracker\Observers\Events\PlainRequestEvent;

class StripeCurlClient extends \Stripe\HttpClient\CurlClient
{
    public function request($method, $absUrl, $headers, $params, $hasFile)
    {
        //[$rbody, $rcode, $rheaders] =  parent::request($method, $absUrl, $headers, $params, $hasFile);
        $response =  parent::request($method, $absUrl, $headers, $params, $hasFile);

        event(new PlainRequestEvent($method, $absUrl, $headers, $params, $response,  $hasFile));
return $response;
        return [$rbody, $rcode, $rheaders];
    }
}
