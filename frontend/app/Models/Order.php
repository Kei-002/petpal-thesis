<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'transactioninfo';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $fillable = ['customer_id','transaction_placed','status'];

    // const CREATED_AT = 'transaction_placed';
    // const UPDATED_AT = 'transaction_paid';

    // protected $fillable = ['customer_id','transaction_placed','status'];
    protected $fillable = ['customer_id', 'status'];


    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function orderlines()
    {
        return $this->belongsToMany('App\Models\Orderline', $table = 'transactioninfo_transactionline');
    }
}
