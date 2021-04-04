<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Nonstandard\Uuid;
use Ramsey\Uuid\Provider\Node\RandomNodeProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 
        'description', 
        'embed_url', 
        'viewed',
        'genres',
    ];

    /** 
     * Indicates if the IDs are UUID's. 
     * 
     * @var bool 
     */ 
    public $incrementing = false; 

    public static function boot()
    { 
         parent::boot();

         static::creating(function ($model) {

            $nodeProvider = new RandomNodeProvider();

            $uuid = Uuid::uuid1($nodeProvider->getNode());
            
            $model->id = $uuid; 
         }); 
    } 

}


