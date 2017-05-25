@extends('layout')

@section('content')

    <h2 class="well well-lg">История заказов</h2>

    <table class="table table-responsive table-striped">
        <thead>
        <tr>
            <th>Дата</th>
            <th>#</th>
            <th>к оплате, грн</th>
            <th>оплачено, грн</th>
            <th>отстаток, грн</th>
            <th>Статус</th>
            <th>Описание заказа</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr data-order-id="{{$order->id}}">
                @include('orders.h_orderrow', ['order' => $order])
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
