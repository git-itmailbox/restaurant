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


Route::post('/home', ['uses' => 'MainController@home', 'as'=> 'home']);
Route::post('/saveorder', ['uses' => 'MainController@saveOrder', 'as'=> 'order.store']);
Route::get('/payinfo/{id}',['uses' => 'MainController@payInfo',]);
Route::get('/orderinfo/{id}',['uses' => 'MainController@orderInfo',]);
Route::get('/orders', ['uses' => 'MainController@orders',]);
Route::get('/history', ['uses' => 'MainController@history',]);
Route::get('/order/{id}', ['uses' => 'MainController@getOrderById',]);
Route::get('/create', 'MainController@createOrder');
Route::get('/getrates', 'RatesController@getRates');

Route::get('/getstatusof/{id}', function ($id) {
    return Order::find($id)->paymentStatus->name;
});




//Route::resource('orders', "MainController");
Route::get('/getorderby/{id}', function ($id) {
    return PaymentStatus::find($id)->orders;
});

Route::get('/broadcast', function() {
    broadcast(new TestEvent('Broadcasting in Laravel using Pusher!'));

    return view('welcome');
});

Route::get('/bridge', function() {
    $pusher = App::make('pusher');

    $pusher->trigger( 'test-channel',
        'income',
        array('id' => '2'));

    return view('welcome');
});

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TestEvent implements ShouldBroadcast
{
    public $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function broadcastOn()
    {
        return ['test-channel'];
    }
}