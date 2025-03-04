<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'user_id',
        'role',
        'level',
        'message',
        'context',
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }
}
