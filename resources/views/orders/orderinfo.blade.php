@extends('layout')

@section('content')
    <div class="col-md-10 col-md-offset-1 ">

        {{link_to('/', $title = "К списку заказов", ['class'=> 'btn btn-default'])}}


        <ul class="list-group">
            <li class="list-group-item">
                Номер:
                <span class="label label-primary">14</span>

            </li>
            <li class="list-group-item">
                Описание
                <span class="label label-primary">14</span>
            </li>
            <li class="list-group-item">
                Статус:
                <span class="label label-primary">14</span>
            </li>
            <li class="list-group-item">
                Создан:
                <span class="label label-primary">14</span>
            </li>
            <li class="list-group-item">
                Изменен:
                <span class="label label-primary">14</span>
            </li>
            <li class="list-group-item">
                Сумма (грн):
                <span class="label label-primary">14</span>
            </li>
            <li class="list-group-item">
                Сумма (btc):
                <span class="label label-primary">14</span>
            </li>
            <li class="list-group-item">
                <span class="badge">14</span>
                Адрес:
            </li>
        </ul>


        <h2>Заказ № {{$order['order_number']}} </h2>
        <div class="row">
            <div class="col-md-12">к оплате: <span class="label label-default">{{$order['summ_uah']}} грн </span></div>
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

            </div>
        </div>
    </div>

@stop