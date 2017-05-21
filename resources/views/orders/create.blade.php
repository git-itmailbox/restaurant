
@extends('layout')

@section('content')
    <div class="col-md-6 col-md-offset-3 ">

        <div class="form-group">
            <h1>Новый заказ</h1>
        </div>

        {!! Form::open(['route'=>'order.store']) !!}

        {{ Form::label('order_number', ' Номер заказа:') }}
        {{ Form::text('order_number', null, ['class'=>'form-control'])}}

        {{ Form::label('summ_uah', 'Сумма:') }}
        {{ Form::text('summ_uah', null, ['class'=>'form-control'])}}

        {{ Form::label('description', 'Описание:') }}
        {{ Form::textarea('description', null, ['class'=>'form-control'])}}

        {{ Form::submit('Создать', ['class'=>'btn btn-info '])}}


        {!! Form::close() !!}
    </div>

@stop