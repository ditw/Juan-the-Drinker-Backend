<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Support\Facades\Route;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $e)
    {
        if ($request->is('api*')) {
            //set Accept request header to application/json
             $request->headers->set('Accept', 'application/json');
        }
 
        if ($e instanceof NotFoundHttpException) {
            return response()->json(['error' => 'Not Found Http Exception'], 404);
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->json(['error' => 'Model Not Found Exception'], 406);
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return response()->json(['error' => 'Method Not Allowed Http Exception'], 405);
        }
        
         // Default to the parent class' implementation of handler
         return parent::render($request, $e);
    }

}
