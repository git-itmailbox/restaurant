<?php
use App\Order;
use App\PaymentStatus;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/home', ['uses' => 'MainController@home', 'as'=> 'home']);
Route::post('/saveorder', ['uses' => 'MainController@saveOrder', 'as'=> 'order.store']);
Route::get('/payinfo/{id}',['uses' => 'MainController@payInfo',]);
Route::get('/orderinfo/{id}',['uses' => 'MainController@orderInfo',]);



Route::get('/create', 'MainController@createOrder');
Route::get('/getaddress', 'MainController@getaddress');
Route::get('/getrates', 'RatesController@getRates');

Route::get('/getstatusof/{id}', function ($id) {
    return Order::find($id)->paymentStatus->name;
});

//Route::resource('orders', "MainController");
Route::get('/getorderby/{id}', function ($id) {
    return PaymentStatus::find($id)->orders;
});
