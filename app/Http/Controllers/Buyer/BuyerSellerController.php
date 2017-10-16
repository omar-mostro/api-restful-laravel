<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;

class BuyerSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     * Se obtiene la collecion de vendedores que tiene un comprador
     */
    public function index(Buyer $buyer)
    {
        //unique elimina los elementos repetidos pero deja espacios en blanco
        //para evitar eso usamos values elimina los vacios
        $sellers = $buyer->transactions()->with('product.seller')
            ->get()
            ->pluck('product.seller')
            ->unique('id')
            ->values();

        return $this->showAll($sellers);
    }


}
