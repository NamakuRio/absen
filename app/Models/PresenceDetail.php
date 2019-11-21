<?php

namespace App\Models;

use App\Traits\PresenceDetailTrait;
use Illuminate\Database\Eloquent\Model;

class PresenceDetail extends Model
{
    use PresenceDetailTrait;

    protected $fillable = ['time'];
}
