<?php

namespace App\Models;

use App\Traits\PresenceTrait;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use PresenceTrait;

    protected $fillable = ['total_time'];
}
