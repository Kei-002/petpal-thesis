<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receiptline extends Model
{
    use HasFactory;
    protected $table = 'receiptlines';
    protected $fillable = ['receipt_id', 'item_id'];

    public function orders()
    {
        return $this->belongsTo('App\Models\Order', "order_id");
    }

    public function transactions()
    {
        return $this->belongsTo('App\Models\Transaction', "order_id");
    }
}
