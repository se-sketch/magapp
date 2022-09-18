@extends('layouts.app')

@section('title', 'Add nomenclature')

@section('content')


<div class="card" style="max-width: 450px;">
 	<div class="card-header">
 		<font size="4" class="mr-5">
 			Новый товар
 		</font>
 	</div>

 	<div class="card-body">

		<div class="row">
		    <div class="col-12">
		        
		        <form action="{{ route('nomenclatures.store') }}" method="post" class="pb-2"
		        enctype="multipart/form-data">

		         @include('nomenclatures.form')

		        </form>
		    </div>
		</div>

 	</div>
</div>


@endsection