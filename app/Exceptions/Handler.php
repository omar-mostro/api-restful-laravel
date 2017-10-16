<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if (config('app.debug')) {
            if ($exception instanceof ValidationException) {
                return $this->convertValidationExceptionToResponse($exception, $request);

            } elseif ($exception instanceof ModelNotFoundException) {

                $modelo = strtolower(class_basename($exception->getModel()));
                return $this->errorResponse("No existe ninguna instancia de {$modelo} con el id especificado", 404);

            } elseif ($exception instanceof AuthenticationException) {
                return $this->convertValidationExceptionToResponse($exception, $request);

            } elseif ($exception instanceof AuthenticationException) {

                return $this->errorResponse('No posee permisos para ejecutar esta accion', 403);

            } elseif ($exception instanceof NotFoundHttpException) {

                return $this->errorResponse('No se encontro la URL especifada', 404);
            } elseif ($exception instanceof MethodNotAllowedHttpException) {

                return $this->errorResponse('El metodo especificado en la peticion no es valido', 405);
            } elseif ($exception instanceof HttpException) {

                return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
            } elseif ($exception instanceof QueryException) {

                $codigo = $exception->errorInfo[1];

                return $this->errorResponse($this->queyTypeError($codigo), 409);


            }


            return parent::render($request, $exception);

        }

        return $this->errorResponse("Falla inesperada, intente mas tarde", 500);


    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {

        return $this->errorResponse('No autenticado', 401);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {


        $errors = $e->validator->errors()->getMessages();
        return $this->errorResponse($errors, 422);

    }

    private function queyTypeError($statusCode)
    {

        switch ($statusCode) {

            case 1451 :
                return ("No se puede eliminar de forma permanente el recurso porque esta relacionado con alg un otro");
                break;

            default:
                return ("Error insesperado en la base de datos");


        }
    }
}
