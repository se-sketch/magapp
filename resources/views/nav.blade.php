<ul class="navbar-nav mr-auto">
	@if (Auth::user())

	@if (Auth::user()->can('viewAny', App\Models\Nomenclature::class))
	<li class="nav-item">
		<a class="nav-link" href="{{ route('nomenclatures.index') }}">
			{{ trans_choice('text.nomenclature', 2) }}
		</a>
	</li>
	@endif


	

	<!--
	<a href="{{ url('locale/en') }}" class="{{ App::isLocale('en') ? 'active' : '' }}">EN</a>
	-->


	@endif


	@if (Cart::count())
	<li class="nav-item">
		<a class="nav-link" href="{{ route('home.cart') }}">
			{{ trans_choice('text.cart', 1) }} ({{Cart::count()}})
		</a>
	</li>
	@endif

	

</ul>

