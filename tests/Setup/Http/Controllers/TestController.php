<?php

namespace Yormy\ApiIoTracker\Tests\Setup\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Yormy\ApiIoTracker\Domain\HttpLogger\Models\LogHttpIncoming;
use Yormy\ApiIoTracker\Domain\HttpLogger\Models\LogHttpOutgoing;

class TestController extends Controller
{
    public function getRoute()
    {
        $logIncom = LogHttpIncoming::all();
        $logOut = LogHttpOutgoing::all();

        return 'getroute return values';
    }
}
