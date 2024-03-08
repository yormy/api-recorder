<?php

namespace Yormy\ApiRecorder\Services\Resolvers;

class Encryptor
{
    public static function encrypt(string $value): string
    {
        return encrypt($value);
    }

    public static function decrypt(?string $value): ?string
    {
        if (! $value) {
            return $value;
        }

        return decrypt($value);
    }
}
