<td class="status">
    <span class="label
    @if ($order->payment_status_id == 1)
            label-default
        @elseif ($order->payment_status_id == 2 || $order->payment_status_id == 4)
            label-warning
        @elseif($order->payment_status_id == 3 || $order->payment_status_id == 5)
            label-success
        @endif
            ">{{$order->paymentStatus->name}} </span>
</td>
<td class="order_number"> {{$order->order_number}} </td>
<td class="summ_uah"> {{($order->summ_uah) / 100}}  </td>
<td class="paid_uah">{{$order->paid_uah / 100}}</td>
<td class="order_info">
    <a class="btn btn-primary" href="/orderinfo/{{$order->id}}">
        <span class="glyphicon glyphicon-info-sign"></span>
    </a>
</td>
<td class="actions">
    <div class="col-md-4 text-center">

        @if ($order->payment_status_id == 1)
            @include('orders.buttons.new')
        @elseif ($order->payment_status_id == 2 || $order->payment_status_id == 4)
            @include('orders.buttons.topay')
        @elseif($order->payment_status_id == 3 || $order->payment_status_id == 5)
            <span class="glyphicon glyphicon-ok"></span>
        @endif
    </div>
    <div class="col-md-4  text-center">
        <a class="btn btn-warning btn-sm" href="/tohistory/{{$order->id}}">
            Закрыть заказ
        </a>
    </div>



</td>