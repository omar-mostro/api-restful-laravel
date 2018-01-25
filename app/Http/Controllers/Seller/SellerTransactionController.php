<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Seller;
use Illuminate\Http\Request;

class SellerTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {


        $categories = $seller->products()
            ->with('transactions')
            ->get()
            ->pluck('categories')
            ->collapse()
            ->unique('id')
            ->values();
        ;

        return $this->showAll($categories);
    }

}
