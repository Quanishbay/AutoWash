<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use  hasFactory;
    protected $fillable = ['name', 'description', 'car_wash_id'];
}
