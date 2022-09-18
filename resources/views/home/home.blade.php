@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">

                    <div class="container">
                        <div class="row">
                        
                        @foreach($nomenclatures as $product)
                        <div class="col-sm-4">

                            <a href="{{route('home.show', $product->id)}}">
                                <h3>{{$product->name}}</h3>
                            </a>
                                
                            <p>{{$product->presentPrice()}}</p>
                            
                            <p>
                            <img src="{{URL::to($product->getMainPath())}}"
                            style="max-width: 150px;">
                            </p>

                        </div>
                        @endforeach

                        </div>
                    </div>                    

                </div>
            </div>
        </div>
    </div>
</div>



@endsection
