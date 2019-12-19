<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Item extends Model
{

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'original',
        'discount',
        'url',
        'hash',
        'path',
        'shop_id',
    ];

    public function shop()
    {
        return $this->belongsTo('App\Shop');
    }

}
