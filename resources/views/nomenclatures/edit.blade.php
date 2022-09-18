@extends('layouts.app')

@section('title', 'Edit details for '.$nomenclature->name)

@section('content')

<div class="card" style="max-width: 1450px;">
 	<div class="card-header">
 		<font size="4" class="mr-5">
 			Карточка товара
 		</font>
 	</div>

 	<div class="card-body">

		<div class="row">
		    <div class="col-12">
		        <form action="{{route('nomenclatures.update', ['nomenclature' => $nomenclature])}}" method="post" enctype="multipart/form-data">

		            @method('patch')
		            @include('nomenclatures.form')

		        </form>
		    </div>
		</div>


 	</div>
</div>


@endsection