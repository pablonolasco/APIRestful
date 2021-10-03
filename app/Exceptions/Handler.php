<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use http\Env;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

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
     * @param \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     * TODO cacha las excpeciones HTTP
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     * TODO metodo para controlar los errores
     */
    public function render($request, Exception $exception)
    {
        // TODO validamos si es de tipo Validation
        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        // TODO if que verifica la excepcion de tipo Model
        if ($exception instanceof ModelNotFoundException) {
            $model = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("No existe ningun registro de tipo {$model} con el id especificado", 404);
        }

        // TODO valida si esta autenticado
        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }

        // TODO valida si tiene permisos
        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse('No posee permisos para ejecutar esta accion', 403);
        }

        // TODO valida la ruta o url
        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('No se encontro la Url especificada', 404);
        }

        // TODO valida el metodo se ha correspondiente al tipo de peticion
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('El metodo especificado en la peticion no es valido', 405);
        }
        // TODO valida cualquier excepcion Http
        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }

        // TODO valida si es una expecion de integridad referencial de sql
        if ($exception instanceof QueryException )
        {
            if($exception->errorInfo[1] === 1451)
            {
                return $this->errorResponse('No se puede eliminar el recurso de forma permante porque esta relacioando con algun otro',409 );
            }
        }

        if (config('app.debug'))
        {
           // dd(config('app.debug') );
            return parent::render($request, $exception);
        }
        return $this->errorResponse('Falla inesperada. Intente luego',500);


    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse('No se ha autenticado', 401);
    }

    /**
     * TODO metodo que sirve para retornar el mensaje de error al hacer las peticiones
     *
     * @param \Illuminate\Validation\ValidationException $e
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
        return $this->errorResponse($errors, 422);
        //return response()->json($errors, 422);

    }
}
