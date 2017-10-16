<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    const PRODUCTO_DISPONOBLE = 'disponible';
    const PRODUCTO_NO_DISPONIBLE = 'no disponible';

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [

        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id'

        ];

    public function estaDisponible()
    {

        return $this->status == Product::PRODUCTO_DISPONOBLE;

    }

    public function categories()
    {
        //relacion muchos a muchos
        return $this->belongsToMany(Category::class);
    }

    //seller por que solo es un vendedor
    public function seller()
    {

        //belongs to porque un producto pertenece a un vendedor
        //el que tiene la llave foranea lleva el belongs to
        return $this->belongsTo(Seller::class);

    }


    public function transactions()
    {

        return $this->hasMany(Transaction::class);
    }
}
