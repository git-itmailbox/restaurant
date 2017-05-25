<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use \App\Order;

class TransactionController extends Controller
{
    //

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function income(Request $request)
    {
        $endpoint = "http://localhost:8000/api/income";
        $inputs = json_decode(file_get_contents('php://input'), true);
        if (isset($inputs['type']) && $inputs['type'] == 'verify') {
            echo hash('sha512', $endpoint);
            return;
        } elseif (isset($inputs['type']) && $inputs['type'] == 'btc_deposit') {

        $order = Order::where('address', $request->input('address'))->first();
        if (!$order) return "1"; //не нашли заказа по адресу бтс
        $tr = Transaction::findOrCreate($request->input('transaction'));
        $tr->transaction_num = $request->input('transaction');
        $tr->summ_btc = $request->input('amount');
        $tr->confirmed = $request->input('confirmed');
        $tr->order_id = $order->id;
        $tr->save();

        //вызываем ф-ию суммирования всех приходов по $tr->order_id
        $total_btc = $this->getTotalSummByOrder($tr->order_id);

        $order->paid_btc = $total_btc;
        $order->paid_uah = $total_btc / Config::get('fees.factor') * $order->rate * 100;
        $order->save();

        //check if all transaction confirmed & save new status to order
        $order->payment_status_id = $this->checkStatusOrder($order);
        $order->save();

        $pusher = App::make('pusher');
        $pusher->trigger('test-channel', 'income', ['id' => $order->id]);

    }
        return response("1");
    }

    private function getTotalSummByOrder($orderId)
    {
        $total = \DB::table('transactions')
            ->where('order_id', $orderId)
            ->sum('summ_btc');
        return $total;
    }

    private function isAllTransactionConfirmed($orderId)
    {
        $count = \DB::table('transactions')
            ->where('order_id', $orderId)
            ->count();
        $summ = \DB::table('transactions')
            ->where('order_id', $orderId)
            ->sum('confirmed');
        return $count == $summ;
    }

    private function checkStatusOrder(Order $order)
    {

        if ($order->isPaid() && $this->isAllTransactionConfirmed($order->id))
            $paymentStatus = Config::get('payment_statuses.CONFIRMED_OK');

        if ($order->isPaid() && !$this->isAllTransactionConfirmed($order->id))
            $paymentStatus = Config::get('payment_statuses.UNCONFIRMED_OK');

        if (!$order->isPaid() && $this->isAllTransactionConfirmed($order->id))
            $paymentStatus = Config::get('payment_statuses.CONFIRMED_WRONG');

        if (!$order->isPaid() && !$this->isAllTransactionConfirmed($order->id))
            $paymentStatus = Config::get('payment_statuses.UNCONFIRMED_WRONG');
        return $paymentStatus;
    }


}
