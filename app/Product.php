<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description','category','quantity','date_available','price','user_id'
    ];

    protected $hidden = [
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    protected $casts = [
        'date_available' => 'datetime',
    ];
}
