@extends('layout')

@section('content')

    <h2 class="well well-lg">Заказы</h2>

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
                @include('orders.orderrow', ['order' => $order])
            </tr>
        @endforeach
        </tbody>
    </table>

    {{$orders->links()}}
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
                    row.fadeOut("slow", function () {
                        row.html(datarow).fadeIn();
                    });
                    console.log("Load was performed.");
                });
            }
        });

        $(document).ready(function () {

            $(document).on("click", ".tohistory", function () {
                var row =  $(this).closest("tr");
                var r = confirm("Вы уверены, что хотите закрыть заказ?");
                if (r == true) {
                    $.post('/api/tohistory', {id: $(this).data('id')},
                        function (data) {
                            if (data.result === 'ok')
                            row.fadeOut();
                            else
                                alert("Не удалось закрыть заказ...");
                            console.log(data.order);

                        },
                        "json"
                );

                    console.log($(this).data('id'));
                }

            });
        });


    </script>
@stop