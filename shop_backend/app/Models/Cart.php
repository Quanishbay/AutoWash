<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'quantity',
        'total',
        'status',
        'category_id'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
