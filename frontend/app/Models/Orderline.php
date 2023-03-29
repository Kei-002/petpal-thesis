<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderline extends Model
{
    use HasFactory;
    protected $table = 'orderlines';

    protected $primaryKey = 'id';
    // protected $hidden = ['id'];
    public $timestamps = false;
    protected $fillable = ['orderinfo_id', "product_id", "quantity"];
    // public function pets()
    // {
    //     return $this->hasMany('App\Models\Pet',  'id', 'pet_id');
    // }

    // public function groomservices()
    // {
    //     return $this->hasMany('App\Models\GroomServices', 'id', 'service_id');
    // }

    public function products()
    {
        return $this->hasMany('App\Models\Products', 'id', 'product_id');
    }

    public function orders()
    {
        return $this->belongsTo('App\Models\Order', "orderinfo_id");
    }
}
