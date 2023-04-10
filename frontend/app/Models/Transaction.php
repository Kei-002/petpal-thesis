<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactioninfos';
    // protected $primaryKey = 'id';
    protected $guarded = ['id'];
    // public $timestamps = false;
    protected $fillable = ['customer_id'];

    // const CREATED_AT = 'transaction_placed';
    // const UPDATED_AT = 'transaction_paid';

    // protected $fillable = ['customer_id','transaction_placed','status'];
    // protected $fillable = ['customer_id', 'status'];


    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function receipt()
    {
        return $this->belongsTo('App\Models\Receipt');
    }

    public function transactionlines()
    {
        return $this->hasMany('App\Models\Transactionline', "transactioninfo_id");
    }
}
