<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Spatie\Searchable\Searchable;
// use Spatie\Searchable\SearchResult;
class Consultation extends Model

// implements Searchable
{
    use HasFactory;
    public $table = "consultations";
    protected $guarded = ['id'];

    public function pets()
    {
        return $this->belongsToMany('App\Models\Pet', $table = 'consultations', 'id', 'pet_id')->withTimestamps();
    }

    public function disease()
    {
        return $this->hasOne('App\Models\Disease', 'id', 'disease_id');
    }

    // public function getSearchResult(): SearchResult
    // {

    //     return new SearchResult(
    //         $this,
    //         $this->comments,
    //         $this->created_at,


    //     );
    // }
}
