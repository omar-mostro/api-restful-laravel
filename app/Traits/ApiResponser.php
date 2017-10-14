<?php
/**
 * Created by PhpStorm.
 * User: mostro
 * Date: 14/10/17
 * Time: 12:25 AM
 */

namespace App\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ApiResponser
{

    private function successResponse($data, $code)
    {

        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code)
    {

        return response()->json([
            'error' => $message,
            'code' => $code],
            $code);
    }

    protected function showAll(Collection $collection, $code = 200)
    {

        return $this->successResponse(['data'=>$collection], $code);

    }

    protected function showOne(Model $collection, $code = 200)
    {

        return $this->successResponse(['data'=>$collection], $code);

    }

}