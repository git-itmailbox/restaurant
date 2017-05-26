@extends('layout')

@section('content')
    <div class="col-md-10 col-md-offset-1 ">


        <div class="panel panel-default">
            <div class="panel-heading"><h3>Заказ {{$order['order_number']}}</h3></div>
            <div class="panel-body">
                {{link_to('/', $title = "К списку заказов", ['class'=> 'btn btn-default'])}}

            </div>
            <div class="col-md-12">
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
                                <span class="label label-primary">{{$order['summ_uah'] / 100}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-md-12">
                            <div class="col-md-2">
                                Сумма (btc):
                            </div>
                            <div class="col-md-6">
                                <span class="label label-primary">{{$order['summ_btc'] / Config::get('fees.factor')}}</span>
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


            <table class="table table-responsive table-striped">
                <thead>
                <tr>
                    <th width="15%">Сумма, btc</th>
                    <th>Дата</th>
                    <th>Статус</th>
                    <th>#</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->transactions as $transaction)
                    @include('orders.transaction', ['transaction' => $transaction])
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop