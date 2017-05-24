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
                    <a href="/payinfo/{{$order->id}}">
                        <span class="label label-warning">payinfo</span>
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
        channel.bind('my-event', function (data) {
            alert(data.text);
        });

        channel.bind('income', function (data) {
            var row = $('tr[data-order-id="' + data.id + '"]');
            if (row.length == 0) {
                console.log('no such order id!');
                console.log(data);
                return false;
            }
            if (data.status > 1 && data.status < 6) {
                var status = $(row.find("td:first .label")[0]);
                clearLabels(status);
                setLavbels(status, data.status);
                console.log(status);
            }
        });


        function clearLabels(el) {
            el.removeClass("label-default label-warning label-success");

        }

        function setLavbels(el, statusId) {
            if (statusId == 2 || statusId == 4)
                el.addClass("label-warning");

            if (statusId == 3 || statusId == 5)
                el.addClass("label-success");
        }
    </script>
@stop
