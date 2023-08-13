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
        public readonly array $response,
        public readonly array $params,
        public readonly string $hasFile,
    ) {
    }
}

