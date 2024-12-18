<?php

use App\Http\Middleware\ValidateSso;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e,$request){
            dd($e);
            $code = ResponseAlias::HTTP_NOT_ACCEPTABLE;
            if ($e->getCode() >= 100 && $e->getCode() <= 599)
                $code = $e->getCode();
            if($e instanceof QueryException){
                $msg = substr($e->getMessage(),0,40).'...';
                $query =array("title" => "Error connect database","message" => "Database not active", "messageOriginal" => $msg);
                if(stristr($request->getUri(),'api') === false)
                    return  response()->view('error',$query);
                else return new JsonResponse(array("data"=>array("errors"=>$query)), $code);
            }
            else if($e instanceof  ValidationException){
                return new JsonResponse(array("data"=>array("errors"=>$e->errors())), $code);
            }
            else if($e instanceof RouteNotFoundException || $e instanceof \Laravel\Passport\Exceptions\AuthenticationException || $e instanceof \Illuminate\Auth\AuthenticationException){
                return new JsonResponse(array("data"=>array("errors" =>"Unauthorized" )), \Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED);

            }
            else {
                return new JsonResponse(array("data"=>array("errors" => $e->getMessage())), is_numeric($code) ? $code : \Symfony\Component\HttpFoundation\Response::HTTP_NOT_IMPLEMENTED);
            }
        });
    })->create();
