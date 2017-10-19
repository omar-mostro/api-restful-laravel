<?php

namespace App\Http\Controllers\Product;

use App\Category;
use App\Http\Controllers\ApiController;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return $this->showAll($product->categories);
    }


    public function update(Request $request, Product $product, Category $category)
    {
        //Existen 3 metodos
        // sync: que remplaza la relacion en la tabla con una nueva
        // attach: que añade una nueva categoria pero si es el mismo id tambien lo añade
        // syncWithoutDetaching: que añade sin repetir
        $product->categories()->syncWithoutDetaching($category->id);

        return $this->showAll($product->categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Category $category)
    {

        //Validación para que un producto este relacionado con una categoria
        if (! $product->categories()->find($category->id))

            return $this->errorResponse('La catgegoria especificacda no es una categoria de este producto', 404);

        $product->categories()->detach($category->id);

        return $this->showAll($product->categories);



    }
}
