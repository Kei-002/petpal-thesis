<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GroomServices;

class GroomComments extends Model
{
    use HasFactory;
    public $table = "gscomments";
    protected $fillable = [
        'comments',
        'guestname',
        'groomservices_id',
    ];

    public function groomservices()
    {
        return $this->belongsTo(Groomservices::class);
    }
}
