<?php
use App\Order;
use App\PaymentStatus;
use Illuminate\Support\Facades\App;

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

Route::get('/',['uses' => 'MainController@orders',]);

Route::post('/saveorder', ['uses' => 'MainController@saveOrder', 'as'=> 'order.store']);
Route::get('/payinfo/{id}',['uses' => 'MainController@payInfo',]);
Route::get('/orderinfo/{id}',['uses' => 'MainController@orderInfo',]);
Route::get('/orders', ['uses' => 'MainController@orders',]);
Route::get('/history', ['uses' => 'MainController@history',]);
Route::get('/order/{id}', ['uses' => 'MainController@getOrderById',]);
Route::get('/create', 'MainController@createOrder');
Route::get('/getrates', 'RatesController@getRates');
