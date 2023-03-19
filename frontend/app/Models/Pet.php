<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use App\Models\Orderline;

class Pet extends Model
//  implements Searchable
{
    use HasFactory;
    // use softDeletes;
    // public $table = "pet";5 
    protected $guarded = ['id'];
    public static $rules = [
        'pet_name' => 'required',
        'age' => 'required',
        'customer_id' => 'required',
        'img_path' => 'required',
    ];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    // public function consults()
    // {
    //     return $this->hasMany('App\Models\Consultation');
    // }

    // public function orderlines()
    // {
    //     return $this->hasMany(Orderline::class);
    // }

    // public function getSearchResult(): SearchResult
    // {

    //     return new SearchResult(
    //         $this,
    //         $this->pet_name,

    //     );
    // }
}
