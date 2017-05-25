@extends('layout')

@section('content')

    <h2></h2>

    <table class="table table-responsive table-striped">
        <thead>
        <tr>
            <th width="15%">Статус</th>
            <th>#</th>
            <th>сумма, грн</th>
            <th>оплачено, грн</th>
            <th>i</th>
            <th>actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr data-order-id="{{$order->id}}">
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
                    <a class="btn btn-warning" href="/payinfo/{{$order->id}}">
                        payinfo
                    </a>

                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

@stop


@section('footer')
    <script>
        var pusher = new Pusher("{{env("PUSHER_KEY")}}", {cluster: 'eu'})
        var channel = pusher.subscribe('test-channel');

        channel.bind('income', function (data) {
            var row = $('tr[data-order-id="' + data.id + '"]');
            if (row.length == 0) {
                console.log('no such order id!');
                console.log(data);
            } else {
                $.get("/order/" + data.id, function (datarow) {
                    row.html(datarow);
                    console.log("Load was performed.");
                });
            }
        });

    </script>
@stop
