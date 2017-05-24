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
            <tr>
                <td>
                    <span class="label
                    @if ($order->payment_status_id === 1)
                            label-default
                        @elseif ($order->payment_status_id == 2 || $order->payment_status_id == 4)
                            label-warning
                        @elseif($order->payment_status_id == 3 || $order->payment_status_id == 5)
                            label-success
                        @endif
                   ">{{$order->paymentStatus->name}} </span>
                </td>
                <td> {{$order->order_number}} </td>
                <td> {{$order->summ_uah}}  </td>
                <td>{{$order->summ_ }}</td>
                <td>Doe</td>
                <td>john@example.com</td>
            </tr>
            @endforeach
            </tbody>

    </table>

@stop