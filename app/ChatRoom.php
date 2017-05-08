<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    protected $table = 'chat_rooms';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
