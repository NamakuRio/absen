<?php

namespace App\Traits;

use App\Models\Presence;
use App\Models\PresenceType;

trait PresenceDetailTrait
{
    // public function presenceType()
    // {
    //     return $this->belongsTo(PresenceType::class);
    // }

    public function presence()
    {
        return $this->belongsTo(Presence::class);
    }
}
