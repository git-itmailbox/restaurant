@extends('layout')

@section('content')
    <div class="alert alert-info alert-dismissable fade in" id="info" style="display: none;">
        <strong>Info!</strong> Данные по оплате заказа обновлены. <span class="updated_time"></span>
    </div>
    <div class="col-md-8 col-md-offset-2 ">


        <h2>Заказ № {{$order['order_number']}} </h2>
        <div class="row">
            <div class="col-md-12">к оплате: <span class="label label-default well-sm summ_uah_rest">{{$order->summ_uah_rest()}}  </span> грн
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">Для оплаты отправьте ровно:
                {{ Form::text('summ_btc_rest', $order->summ_btc_rest(), ['readonly'=>'', 'id'=>'summ_btc_rest','class'=>'' ])}}
                <span class="label label-default">btc </span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-10">
                {{ Form::text('address', $order['address'], ['readonly'=>'', 'class'=>'form-control' ])}}
                {{ Form::hidden('id', $order['id'], ['id'=>'order_id', 'class'=>'form-control' ])}}
            </div>
        </div>
        <div class="row  text-center ">
            <div class="col-md-8 col-sm-8 col-xs-10">
                <div class=" qrcode jumbotron">
                    <div class="container">
                        <img src="data:image/png;base64,{!!  DNS2D::getBarcodePNG($query, "QRCODE", 10,10) !!}" alt="barcode" style="width:100%;"/>
                    </div>

                </div>
            </div>
        </div>
    </div>

@stop

@section('footer')
    <script>
        $( document ).ready(function() {
            $("#info").hide();

            var pusher = new Pusher("{{env("PUSHER_KEY")}}", {cluster: 'eu'})
            var channel = pusher.subscribe('test-channel');
            var uah_rest = $(".summ_uah_rest");
            var btc_rest = $("#summ_btc_rest");
            var orderId = $("#order_id").val();
            channel.bind('income', function (data) {
                if (orderId == data.id) {
                    $.get("/api/order/" + data.id, function (orderData) {
                        uah_rest.text(orderData.uah_rest);
                        btc_rest.val(orderData.btc_rest);
                        $(".updated_time").text(orderData.updated_at.date);
                        $("#info").fadeToggle();
                        setTimeout(function () {
                            $("#info").fadeToggle('slow');

                        }, 10000);
                        console.log(orderData);
                    });
                }
            });

        });

    </script>
@stop
