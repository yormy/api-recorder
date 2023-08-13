<?php

namespace Yormy\ApiIoTracker\Observers\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlainRequestEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public readonly string $method,
        public readonly string $url,
        public readonly array $headers,
        public readonly array $body,
        public readonly int $responseCode,
        public readonly string $responseHeaders,
        public readonly string $responseBody,
        public readonly string $hasFile,
    ) {
    }
}

