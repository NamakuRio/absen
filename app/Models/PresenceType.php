<?php

namespace App\Models;

use App\Traits\PresenceTypeTrait;
use Illuminate\Database\Eloquent\Model;

class PresenceType extends Model
{
    use PresenceTypeTrait;

    protected $fillable = ['name'];
}
