@extends('layouts.app')

@section('title', 'Cart')

@section('content')


<div class="card" class="ml-5 mr-5">
    <div class="card-header">
        <font size="4">
            CART
        </font>
    </div>

    <div class="card-body ml-2">
        @include('home.cart')
    </div>

</div>


@endsection