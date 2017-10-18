<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Seller;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        return $this->showAll($seller->products);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $seller)
    {
        $rules = [

            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|min:1|integer',
            'image' => 'image|required'
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        $data['status'] = Product::PRODUCTO_NO_DISPONIBLE;
        $data['image'] = '1.jpg';
        $data['seller_id'] = $seller->id;

        return $this->showOne(Product::create($data), 201);


    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller, Product $product)
    {
        $rules = [

            'quantity' => 'min:1|integer',
            'image' => 'image',
            'status' => 'in: ' . Product::PRODUCTO_DISPONOBLE . ' , ' . Product::PRODUCTO_NO_DISPONIBLE
        ];

        $this->validate($request, $rules);

        $this->verificarVendedor($seller, $product);

        $product->fill($request->intersect([

            'name',
            'description',
            'quantity'
        ]));

        if ($request->has('status')) {

            $product->status = $request->status;

            if ($product->estaDisponible() && $product->categories()->count() == 0) {

                return $this->errorResponse('Un producto activo debe tener al menos una categoria', 409);
            }
        }

        if ($product->isClean())
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 499);


        $product->save();

        return $this->showOne($product, 202);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller, Product $product)
    {

        $this->verificarVendedor($seller, $product);

        $product->delete();

        return $this->showOne($product);

    }

    private function verificarVendedor(Seller $seller, Product $product)
    {

        if ($seller->id != $product->seller_id)

            throw new HttpException (422, 'El vendedor especificado no es el vendedor real del producto');

    }
}

