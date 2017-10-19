<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     * Se obtiene la lista de las transacciones que tiene un comprador
     */
    public function index(Buyer $buyer)
    {
        return $this->showAll($buyer->transactions);
    }


}
