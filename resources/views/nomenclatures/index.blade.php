@extends('layouts.app')

@section('title', 'Nomenclature list')

@section('content')


<font size="4">
    {{trans_choice('text.product', 2)}}
</font>

@can('create', App\Nomenclature::class)
<a href="{{ route('nomenclatures.create') }}" class="btn btn-primary btn-sm mb-1">
    {{__('text.new_product')}}
</a>
@endcan


<table style="width:100%" class="table table-striped table-hover">
    <thead>
        <tr>
            <th>№</th>
            <th>{{__('text.nameitem')}}</th>
            <th>{{__('text.price')}}</th>
            <th>{{__('text.rest')}}</th>
            <th>{{__('text.status')}}</th>
        </tr>
    </thead>    

<tbody>
@foreach($nomenclatures as $nomenclature)
<tr>
    <td>{{$nomenclature->id}}</td>
    <td>
        @can('update', $nomenclature)
            <a href="{{ route('nomenclatures.edit', $nomenclature->id) }}"> 
                <div style="width: 100%;height: 100%">
                    {{$nomenclature->name}}    
                </div>
            </a> 
        @endcan

        @cannot('update', $nomenclature)
        {{$nomenclature->name}}
        @endcan        
    </td>
    <td>{{$nomenclature->price}}</td>
    <td>{{$nomenclature->balance ? 'Есть' : 'Нет'}}</td>
    <td>{{$nomenclature->active ? 'Активный' : 'Нет'}}</td>
</tr>
@endforeach
</tbody>

</table> 

<br>

@can('viewAny', App\Kitnom::class)
    <a href="{{route('kitnoms.index')}}" class="btn btn-outline-dark btn-sm">Набор товаров</a>
@endcan

@endsection