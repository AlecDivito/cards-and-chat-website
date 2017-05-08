<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public function user()
    {
        $this->belongsTo(User::class);
    }
}
