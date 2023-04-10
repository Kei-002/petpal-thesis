<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactionline extends Model
{
    protected $table = 'transactionlines';

    protected $primaryKey = 'id';
    // protected $hidden = ['id'];
    public $timestamps = false;
    protected $fillable = ['transactioninfo_id', "pet_id", "service_id"];
    public function pets()
    {
        return $this->belongsTo('App\Models\Pet', 'pet_id');
    }

    // public function groomservices()
    // {
    //     return $this->hasMany('App\Models\GroomServices', 'id', 'service_id');
    // }

    public function services()
    {
        return $this->hasMany('App\Models\GroomServices', 'id', 'service_id');
    }

    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction', "transactioninfo_id");
    }
}
