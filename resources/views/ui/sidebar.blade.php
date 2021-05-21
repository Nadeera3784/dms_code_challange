<aside class="col-md-12">
	<div class="card mb-3">
		<div class="card-body">
			<h5 class="card-title">Categories</h5>
			<ul class="list-menu">
				<li><a href="{{ url('/') }}">All</a></li>
				@foreach ($categories as $category)
			    	<li><a href="{{ route('category', $category->slug) }}">{{$category->title}} </a></li>
			    @endforeach
			</ul>
		</div>
	</div> 
</aside>