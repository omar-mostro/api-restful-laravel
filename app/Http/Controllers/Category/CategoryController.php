<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;


class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return $this->showAll(Category::all());

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'name' => 'required',
            'description' => 'required'
        ];

        $this->validate($request, $rules);


        return $this->showOne(Category::create($request->all()), 201);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
       return $this->showOne($category);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {

        //Con el siguiente metodo validamos que solo se tomen en cuenta los valores name y description (intersect)

        $category->fill($request->intersect([
            'name',
            'description'
        ]));

        //y con isdirty se valida que se envie uno o ambos parametros, tambien valida que el contenido sea diferente al
        //actual

        //is dirty verifica si la instancia a cambiado, is clean lo contrario

        if ($category->isClean()){

            return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);
        }

        $category->save();

        return $this->showOne($category, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->showOne($category, 200);
    }
}
