<?php

use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\Api\admin\CommentController as CommentController;
use App\Http\Controllers\Api\admin\DebtController as DebtController;
use App\Http\Controllers\Api\admin\AssistantController as AssistantController;
use App\Http\Controllers\Api\admin\OrderController as OrderController;
use App\Http\Controllers\Api\admin\ProductController as ProductController;
use App\Http\Controllers\Api\admin\ProviderController as ProviderController;
use App\Http\Controllers\Api\admin\RoleController as RoleController;
use App\Http\Controllers\Api\admin\TypeController as TypeController;
use App\Http\Controllers\Api\admin\ClientController as ClientController;

use App\Http\Controllers\Api\assistent\CommentController as AssistantCommentController;
use App\Http\Controllers\Api\assistent\DebtController as AssistantDebtController;

use App\Http\Controllers\Api\client\OrderController as ClientOrderController;
use App\Http\Controllers\Api\client\CommentController as ClientCommentController;
use App\Http\Controllers\Api\client\ProductController as ClientProductController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\SellerController;


use App\Http\Controllers\Api\UserController;
use App\Http\Middleware\JwtMiddleware;
use App\Mail\ConfirmationMailable;
use App\Mail\RegistroMailable;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//AUTH JWT USER
Route::post('/login/manager',[UserController::class, 'authenticate']);
Route::post('/register/manager',[UserController::class,'register']);
Route::get('/perfil/manager',[UserController::class,'getAuthenticatedUser']);

//AUTH JWT USER - CLIENT
Route::post('/login',[UserController::class, 'authenticate']);
Route::post('/register',[UserController::class,'register']);
Route::get('/perfil',[UserController::class,'getAuthenticatedUser']);//borrar

//MIDDLEWARE DE AUTENTICACION JWT

Route::middleware('jwt.verify')->group(function()
{
    //Obtener usuario autenticado
    Route::get('/perfil', [UserController::class, 'getAuthenticatedUser']);
    Route::get('/logout',[UserController::class, 'logout']);
    //Products
    Route::get('/products',[ProductController::class,'index']);
    Route::post('/products',[ProductController::class,'store']);
    Route::get('/products/{product}',[ProductController::class,'show']);
    Route::put('/products/{product}',[ProductController::class,'update']);
    Route::delete('/products/{product}',[ProductController::class,'destroy']);
    //Providers
    Route::get('/providers',[ProviderController::class,'index']);
    Route::post('/providers',[ProviderController::class,'store']);
    Route::get('/providers/{provider}',[ProviderController::class,'show']);
    Route::put('/providers/{provider}',[ProviderController::class,'update']);
    Route::delete('/providers/{provider}',[ProviderController::class,'destroy']);
    //Orders
    Route::get('/orders',[OrderController::class, 'index']);
    Route::post('/orders',[OrderController::class, 'store']);
    Route::get('/orders/{order}',[OrderController::class, 'show']);
    Route::put('/orders/{order}',[OrderController::class, 'update']);
    Route::delete('/orders/{order}',[OrderController::class, 'destroy']);
    //Debts
    Route::get('/debts',[DebtController::class, 'index']);
    Route::post('/debts',[DebtController::class, 'store']);
    Route::get('/debts/{debt}',[DebtController::class, 'show']);
    Route::put('/debts/{debt}',[DebtController::class, 'update']);
    Route::delete('/debts/{debt}',[DebtController::class, 'destroy']);
    //Comments
    Route::get('/comments',[CommentController::class,'index']);
    Route::post('/comments',[CommentController::class,'store']);
    Route::get('/comments/{comment}',[CommentController::class,'show']);
    Route::put('/comments/{comment}',[CommentController::class,'update']);
    Route::delete('/comments/{comment}',[CommentController::class,'destroy']);
    //Roles
    Route::get('/roles',[RoleController::class,'index']);
    Route::post('/roles',[RoleController::class,'store']);
    Route::get('/roles/{rol}',[RoleController::class,'show']);
    Route::put('/roles/{rol}',[RoleController::class,'update']);
    Route::delete('/roles/{rol}',[RoleController::class,'destroy']);
    //Types
    Route::get('/types',[TypeController::class,'index']);
    Route::post('/types',[TypeController::class,'store']);
    Route::get('/types/{type}',[TypeController::class,'show']);
    Route::put('/types/{type}',[TypeController::class,'update']);
    Route::delete('/types/{type}',[TypeController::class,'destroy']);
    //Clients
    Route::get('/clients',[ClientController::class,'index']);
    Route::post('/clients',[ClientController::class,'store']);
    Route::get('/clients/{client}',[ClientController::class,'show']);
    Route::put('/clients/{client}',[ClientController::class,'update']);
    Route::delete('/clients/{client}',[ClientController::class,'destroy']);
    //Assistants
    Route::get('/assistants',[AssistantController::class,'index']);
    Route::post('/assistants',[AssistantController::class,'store']);
    Route::get('/assistants/{assistant}',[AssistantController::class,'show']);
    Route::put('/assistants/{assistant}',[AssistantController::class,'update']);
    Route::delete('/assistants/{assistant}',[AssistantController::class,'destroy']);

    //Debt -> ASSISTANT
    Route::get('/debts-assistant',[AssistantDebtController::class,'index']);
    Route::post('/debts-assistant',[AssistantDebtController::class,'store']);
    Route::get('/debts-assistant/{debt}',[AssistantDebtController::class, 'show']);
    Route::put('/debts-assistant/{debt}',[AssistantDebtController::class, 'update']);
    Route::delete('/debts-assistant/{debt}',[AssistantDebtController::class, 'destroy']);

    //Comments -> CLIENT
    Route::get('/comments-client',[ClientCommentController::class,'index']);
    Route::get('/comments-client-own',[ClientCommentController::class,'indexOwn']);
    Route::post('/comments-client',[ClientCommentController::class,'store']);
    Route::get('/comments-client/{comment}',[ClientCommentController::class, 'show']);
    Route::put('/comments-client/{comment}',[ClientCommentController::class, 'update']);
    Route::delete('/comments-client/{comment}',[ClientCommentController::class, 'destroy']);
    //Orders -> CLIENT
    Route::get('/orders-client',[ClientOrderController::class, 'index']);
    Route::post('/orders-client',[ClientOrderController::class, 'store']);
    Route::get('/orders-client/{order}',[ClientOrderController::class, 'show']);
    Route::put('/orders-client/{order}',[ClientOrderController::class, 'update']);
    Route::delete('/orders-client/{order}',[ClientOrderController::class, 'destroy']);
    //Products -> CLIENT
    Route::get('/products-client',[ClientProductController::class, 'index']);
    Route::get('/products-client/{product}',[ClientProductController::class, 'show']);

    Route::get('/nuevo', function(){
        $user=Auth::user();
        $email = new ConfirmationMailable($user);
        Mail::to('ferkevin@gmail.com')->send($email);
        return 'mensaje ok';
    });

    
});


//EMAILS
Route::get('/registro',function(){
    $correo = new RegistroMailable;
    Mail::to("direccion de correo electronico")->send($correo);
    return 'mensaje enviado';
});


//seller FILLABLE
Route::get('/sellers',[SellerController::class,'index']);
Route::post('/sellers',[SellerController::class,'store']);

//Products
/* Route::get('/products',[ProductController::class,'index']);
Route::post('/products',[ProductController::class,'store']);
Route::get('/products/{product}',[ProductController::class,'show']);
Route::put('/products/{product}',[ProductController::class,'update']);
Route::delete('/products/{product}',[ProductController::class,'destroy']); */

//Provider
/* Route::get('/providers',[ProviderController::class,'index']);
Route::post('/providers',[ProviderController::class,'store']);
Route::get('/providers/{provider}',[ProviderController::class,'show']);
Route::put('/providers/{provider}',[ProviderController::class,'update']);
Route::delete('/providers/{provider}',[ProviderController::class,'destroy']); */

//Comments
//Route::get('/comments',[CommentController::class,'index']);
//Route::post('/comments',[CommentController::class,'store']);
//Route::get('/comments/{comment}',[CommentController::class,'show']);
//Route::put('/comments/{comment}',[CommentController::class,'update']);
//Route::delete('/comments/{comment}',[CommentController::class,'destroy']);

//Orders
/* Route::get('/orders',[OrderController::class, 'index']);
Route::post('/orders',[OrderController::class, 'store']);
Route::get('/orders/{order}',[OrderController::class, 'show']);
Route::put('/orders/{order}',[OrderController::class, 'update']);
Route::delete('/orders/{order}',[OrderController::class, 'destroy']); */

//Debts
/* Route::get('/debts',[DebtController::class, 'index']);
Route::post('/debts',[DebtController::class, 'store']);
Route::get('/debts/{debt}',[DebtController::class, 'show']);
Route::put('/debts/{debt}',[DebtController::class, 'update']);
Route::delete('/debts/{debt}',[DebtController::class, 'destroy']); */

//Managers
Route::get('/managers',[ManagerController::class, 'index']);
Route::post('/managers',[ManagerController::class, 'store']);
Route::get('/managers/{manager}',[ManagerController::class, 'show']);
Route::put('/managers/{manager}',[ManagerController::class, 'update']);
Route::delete('/managers/{manager}',[ManagerController::class, 'destroy']);


//Route::middleware('auth:sanctum')

//Autenticacion
Route::post('/login1', [AuthController::class, 'login']);
//Proteccion de ruta con middleware
Route::middleware('auth:sanctum')->group(function()
{
    Route::post('/logout', [AuthController::class, 'logout']);
});