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

Route::get('/home', 'MainController@home');
Route::get('/getaddress', 'MainController@getaddress');

Route::get('/getstatusof/{id}', function ($id) {
    return Order::find($id)->paymentStatus->name;
});


Route::get('/getorderby/{id}', function ($id) {
    return PaymentStatus::find($id)->orders;
});
