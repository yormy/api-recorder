<?php

namespace Yormy\ApiRecorder\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
