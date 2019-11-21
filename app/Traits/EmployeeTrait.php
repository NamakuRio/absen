<?php

namespace App\Traits;

use App\Models\Presence;
use App\Models\User;

trait EmployeeTrait
{
    public function createPresence()
    {
        $data = [
            'total_time' => '0'
        ];

        $this->presence()->create($data);

        return $this;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function presence()
    {
        return $this->hasOne(Presence::class);
    }
}
