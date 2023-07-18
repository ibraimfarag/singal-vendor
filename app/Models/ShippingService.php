<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingService extends Model
{
    protected $fillable = ['title','price','status'];
    public $timestamps = false;

}
