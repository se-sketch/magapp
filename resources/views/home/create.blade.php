@extends('layouts.app')

@section('title', 'Add order')

@section('content')


<div class="card" style="max-width: 600px;">
 	
 	<div class="px-5 py-2 bg-gray-400 border">
 		<font size="4">Новый заказ</font>
 	</div>

 	<div class="card-body">
 		<div class="row">
 			<div class="col-12">
 				@include('home.confirmorder')
 			</div>
 		</div>
 	</div>

 	<div class="card-body bg-gray-300">
		
		<div class="row">
		    <div class="col-12">
		        
		        <form action="{{ route('home.storeorder') }}" method="post" class="pb-2">

		         	@include('home.editform')

		        </form>
		    </div>
		</div>

 	</div>
</div>



@endsection