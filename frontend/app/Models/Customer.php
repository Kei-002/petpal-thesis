<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Searchable\Searchable;
// use Spatie\Searchable\SearchResult;


class Customer extends Model
// implements Searchable
{
    use HasFactory;
    use softDeletes;

    // public $table = "customer";

    protected $guarded = ['id'];
    public static $rules = [
        'fname' => 'required',
        'lname' => 'required',
        'addressline' => 'required',
        'phone' => 'digits_between:3,8',
        'img_path' => 'required'
    ];

    public function pets()
    {
        return $this->hasMany('App\Models\Pet');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // public function getSearchResult(): SearchResult
    // {

    //     return new SearchResult(
    //         $this,
    //         $this->customer_name,

    //     );
    // }
}
