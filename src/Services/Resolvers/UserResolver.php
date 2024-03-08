<?php

namespace Yormy\ApiRecorder\Services\Resolvers;

use Illuminate\Support\Facades\Auth;

class UserResolver
{
    public static function getCurrent()
    {
        return Auth::user();
    }
}
