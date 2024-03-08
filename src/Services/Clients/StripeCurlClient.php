<?php

namespace Yormy\ApiRecorder\Services\Clients;

use Yormy\ApiRecorder\Observers\Events\PlainRequestEvent;

class StripeCurlClient extends \Stripe\HttpClient\CurlClient
{
    public function request($method, $absUrl, $headers, $params, $hasFile)
    {
        [$rbody, $rcode, $rheaders] = parent::request($method, $absUrl, $headers, $params, $hasFile);

        event(new PlainRequestEvent(
            method: $method,
            url: $absUrl,
            headers: $headers,
            body: $params,
            responseCode: $rcode,
            responseHeaders: json_encode($rheaders),
            responseBody: $rbody,
            hasFile: $hasFile
        ));

        return [$rbody, $rcode, $rheaders];
    }
}
