<td class=""> {{$order->created_at}} </td>
<td class="order_number"> {{$order->order_number}} </td>
<td class="summ_uah"> {{($order->summ_uah) / 100}}  </td>
<td class="paid_uah">{{$order->paid_uah / 100}}</td>
<td class="paid_uah">{{$order->summ_uah_rest() }}</td>

<td class="status">
    @if ($order->payment_status_id == 6)
        <span class="label label-success "> Оплачен </span>
    @elseif($order->payment_status_id == 7)
        <span class="label label-danger ">Недоплачен</span>
    @endif
</td>
<td class="order_info">
    <a class="btn btn-primary" href="/orderinfo/{{$order->id}}">
        <span class="glyphicon glyphicon-info-sign"></span>
    </a>
</td>
