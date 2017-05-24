@extends('layout')

@section('content')
    <div class="col-md-6 col-md-offset-3 ">


        <h2>Заказ № {{$order['order_number']}} </h2>
        <div class="row">
            <div class="col-md-12">к оплате: <span class="label label-default">{{$order['summ_uah']/100}} грн </span></div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">Для оплаты отправьте ровно:
                {{ Form::text('summ_btc', $order['summ_btc'], ['readonly'=>'', 'class'=>'' ])}}
                <span class="label label-default">btc </span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">{{ Form::text('address', $order['address'], ['readonly'=>'', 'class'=>'form-control' ])}}</div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {!! DNS2D::getBarcodeHTML($query, "QRCODE") !!}

            </div>
        </div>
    </div>

@stop