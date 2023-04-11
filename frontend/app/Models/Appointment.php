<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    public $table = "appointments";
    protected $guarded = ['id'];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function consultation()
    {
        return $this->belongsTo('App\Models\Consultation');
    }
}
