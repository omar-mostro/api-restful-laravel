<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Transaction;

class TransactionSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     * Se obtiene el vendedor de la transaccion dada
     */
    public function index(Transaction $transaction)
    {
        return $this->showOne($transaction->product->seller);
    }


}
