<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderline extends Model
{
    use HasFactory;
    protected $table = 'transactionline';

    protected $primaryKey = 'id';
    // protected $hidden = ['id'];
    public $timestamps = true;

    public function pets()
    {
        return $this->hasMany('App\Models\Pet',  'id', 'pet_id');
    }

    public function groomservices()
    {
        return $this->hasMany('App\Models\Groomservices', 'id', 'service_id');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order', $table = 'transactioninfo_transactionline');
    }
}
