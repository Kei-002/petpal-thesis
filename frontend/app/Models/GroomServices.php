<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Servicesimage;
// use App\Models\Gscomments;
// use App\Models\Orderline;
use App\Models\Orderline;

class GroomServices extends Model
{
    use HasFactory;

    use HasFactory;
    protected $fillable = [
        'groom_name',
        'price',
        'description',
    ];

    // public function images()
    // {
    //     return $this->hasMany(Servicesimage::class);
    // }

    // public function comments()
    // {
    //     return $this->hasMany(Gscomments::class);
    // }
    public function orderlines()
    {
        return $this->hasMany(Orderline::class);
    }
}
