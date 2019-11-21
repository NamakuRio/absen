<?php

namespace App\Traits;

use App\Models\Employee;
use App\Models\PresenceDetail;

trait PresenceTrait
{
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function presenceDetails()
    {
        return $this->hasMany(PresenceDetail::class);
    }
}
