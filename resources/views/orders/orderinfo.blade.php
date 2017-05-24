@extends('layout')

@section('content')
    <div class="col-md-8 col-md-offset-1 ">

        {{link_to('/', $title = "К списку заказов", ['class'=> 'btn btn-default'])}}


        <div class="list-group ">
            <div class="row list-group-item">
                <div class="col-md-12">

                    <div class="col-md-2">Номер:</div>
                    <div class="col-md-6">
                        <span class="label label-primary">{{$order['order_number']}}</span>
                    </div>
                </div>
            </div>
            <div class="row list-group-item">
                <div class="col-md-12">
                    <div class="col-md-2">Описание</div>
                    <div class="col-md-6">
                        <span class="label label-primary">{{$order['description']}}</span>
                    </div>
                </div>
            </div>
            <div class="row list-group-item ">
                <div class="col-md-12">
                    <div class="col-md-2 ">Статус:</div>
                    <div class="col-md-6 bg-success">
                        <span class="label label-primary">{{$order['paymentStatus']->name}}</span>
                    </div>
                </div>
            </div>
            <div class="row list-group-item">
                <div class="col-md-12">
                    <div class="col-md-2">Создан:</div>
                    <div class="col-md-6">
                        <span class="label label-primary">{{$order['created_at']}}</span>
                    </div>
                </div>
            </div>
            <div class="row list-group-item">
                <div class="col-md-12">
                    <div class="col-md-2">Изменен:</div>
                    <div class=" col-md-6">
                        <span class="label label-primary">{{$order['updated_at']}}</span>
                    </div>
                </div>
            </div>
            <div class="row list-group-item">
                <div class="col-md-12">
                    <div class="col-md-2">
                        Сумма (грн):
                    </div>
                    <div class="col-md-6">
                        <span class="label label-primary">summ_uah</span>
                    </div>
                </div>
            </div>
            <div class="row list-group-item">
                <div class="col-md-12">
                    <div class="col-md-2">
                        Сумма (btc):
                    </div>
                    <div class="col-md-6">
                        <span class="label label-primary">summ_btc</span>
                    </div>
                </div>
            </div>
            <div class="row list-group-item">
                <div class="col-md-12">
                    <div class="col-md-2 ">
                        Адрес:
                    </div>
                    <div class="col-md-6 ">
                        <span class="label label-primary">{{$order['address']}}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop