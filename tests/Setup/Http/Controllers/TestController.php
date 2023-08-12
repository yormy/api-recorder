<?php

namespace Yormy\ApiIoTracker\Tests\Setup\Http\Controllers;

use Illuminate\Routing\Controller;
use Yormy\ApiIoTracker\Models\LogHttpIncoming;
use Yormy\ApiIoTracker\Models\LogHttpOutgoing;

class TestController extends Controller
{
    public function getRoute()
    {
        $logIncom = LogHttpIncoming::all();
        $logOut = LogHttpOutgoing::all();

        return 'getroute return values';
    }

    public function postRoute()
    {
        $logIncom = LogHttpIncoming::all();
        $logOut = LogHttpOutgoing::all();

        return 'postroute return values';
    }
}
