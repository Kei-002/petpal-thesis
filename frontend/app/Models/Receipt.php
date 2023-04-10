<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    protected $table = 'receiptinfos';
    protected $fillable = ['total_purchase', 'receipt_path'];

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }
}
