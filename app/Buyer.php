<?php

namespace App;



use App\Scopes\BuyerScope;

class Buyer extends User
{

    //parte del scope
    //cada que se haga una consulta mediante el modelo buyer, se aplicara el scope
    //en este caso que tenga transacciones el comprador
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new BuyerScope);

    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
