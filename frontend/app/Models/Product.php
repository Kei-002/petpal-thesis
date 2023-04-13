<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // public $timestamps = false;
    protected $fillable = [
        'groom_name',
        'price',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function stock()
    {
        return $this->hasOne('App\Models\Stock');
    }
}
