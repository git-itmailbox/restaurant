@extends('layout')

@section('content')
    <div class="col-md-6 col-md-offset-3 ">


        <h2>Заказ № {{$order['order_number']}} </h2>
        <div class="row">
            <div class="col-md-12">к оплате: <span class="label label-default">{{$order->summ_uah_rest()}} грн </span></div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">Для оплаты отправьте ровно:
                {{ Form::text('summ_btc_rest', $order->summ_btc_rest(), ['readonly'=>'', 'class'=>'' ])}}
                <span class="label label-default">btc </span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">{{ Form::text('address', $order['address'], ['readonly'=>'', 'class'=>'form-control' ])}}</div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1 text-center img-responsive">
            <div class="">
                {!! DNS2D::getBarcodeHTML($query, "QRCODE") !!}

            </div>
            </div>
        </div>
    </div>

@stop