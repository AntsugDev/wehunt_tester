<?php

use App\Http\Api\Auth\AuthController;
use App\Http\Api\List\ListController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

Route::prefix('auth')->group(function (){
    Route::post('',[AuthController::class,'auth']);
});


Route::middleware(['auth:api',\App\Http\Middleware\ValidateSso::class])->group(function (){

    Route::prefix('at')->group(function () {
        Route::get('refresh',[AuthController::class,'refresh']);
        Route::get('logout',[AuthController::class,'logout']);
    });

    Route::get('list',[ListController::class,'index']);

});


Route::any('/{any}', function () {
    return new JsonResponse(array("data"=>array("errors"=>"Route not found or method unsupported")), 404);
})->where('any', '.*');
