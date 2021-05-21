@extends('ui.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
        	 <div class="row">
                  @include('ui.sidebar')
        	 </div>
        </div>
        <div class="col-md-9">
        	<div class="row" id="productList">
                @foreach ($products as $product)
        		<div class="col-md-4">
					<figure class="card card-product-grid">
						<a href="#" class="img-wrap"> 
							<img src="{{asset('assets/images/')}}/{{$product->image}}">
						</a>
						<figcaption class="info-wrap">
							<a href="#" class="title">{{ Str::limit($product->title, 20) }}</a>
							<div class="mt-2">
								<var class="price">${{number_format($product->price, 2)}}</var>
								<a href="#" class="btn btn-sm btn-outline-primary float-right" data-id="{{$product->id}}" id="addToCart">Add to cart <i class="mdi mdi-cart"></i></a>
							</div> 
						</figcaption>
					</figure> 
				</div>
                @endforeach
                
                <div class="col-md-12 text-center">
                	{{ $products->links() }}
                </div>
				
        	</div>
        </div>
    </div>
</div>

@endsection

