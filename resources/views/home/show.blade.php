@extends('layouts.app')

@section('title', 'Details for '.$nomenclature->name)

@section('content')


<div class="card" class="ml-5 mr-5">
    <div class="card-header">
        <font size="4">
            {{__('text.nomenclature')}} № {{$nomenclature->id}} {{$nomenclature->name}}
        </font>
    </div>

    <div class="card-body ml-2">


        <div class="row">
            <div clas="col-12">
                <p><strong>{{__('text.name')}}:</strong> 
                    {{$nomenclature->name}} 
                </p>
                
                <p><strong>{{__('text.price')}}:</strong> 
                    {{$nomenclature->presentPrice()}} 
                </p>
            </div>
        </div>


        <div class="container">
            <div class="row">
                @foreach($images as $image)
                    <div class="col-sm-4" id="image_{{$image->id}}">
                        <p>
                            <img src="{{ URL::to($image->getPathName()) }}" 
                                width="200" height="200">
                        </p>
                        
                    </div>
                @endforeach
            </div>        

        </div>

        <div class="container">
            <p>
                {{$nomenclature->description}}
            </p>
        </div>


        <form action="{{route('home.store', ['id' => $nomenclature->id])}}" method="post">
            @csrf
            
            <button type="submit" class="btn btn-primary">
                {{__('text.add_to_cart')}}
            </button>
        </form>

        

    </div>

</div>




@endsection