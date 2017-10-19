<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Transaction;


class TransactionCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     * Se obtienen las categorias de una transacción especifica
     */
    public function index(Transaction $transaction)
    {

        $categories = $transaction->product->categories;

        return $this->showAll($categories);

    }


}
