<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;

class BuyerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     * Muestra los productos de un comprador
     */
    public function index(Buyer $buyer)
    {
        //Llamamos a la funcion y no a la relacion en transaction
        //osea ocupamos el equry builder asi ya no regresa una coleccion

        //with recive una serie de relaciones

        //El metodo pluck permite trabajar sobre la collecion obteniendo solo una parte
        $products = $buyer->transactions()->with('product')->get()->pluck('product');

        return $this->showAll($products);
    }


}
