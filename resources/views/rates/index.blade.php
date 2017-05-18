@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>Курс BTC -> UAH</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 text-center">
        </div>
        <div class="col-md-4 text-center">
            <div class=" col-md-12">
                <h2 class="btc_uah bg-primary">{{ $client_btc_uah }} грн</h2>
            </div>
        </div>
    </div>
@stop