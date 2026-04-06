<x-app>
    	<div class="untree_co-section product-section before-footer-section">
		    <div class="container">
		      	<div class="row">

		      		<!-- Start Column 1 -->
					@foreach ($products as $product)
                    <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
                        <a class="product-item" href="cart.html">
                            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid product-thumbnail">
                            <h3 class="product-title">{{ $product->name }}</h3>
                            <strong class="product-price">{{ $product->price }}</strong>
                            <form method="POST" action="{{route('cartadd')}}">
                                @csrf

                                <input type="hidden" name="product_add" value="{{$product->id}}">
                                <span class="icon-cross">
                                    <button class="" style="border: none; background:none;">
                                        <img src="{{ asset('assets/images/cross.svg') }}" class="img-fluid">
                                    </button>
                                </span>

                            </form>
                        </a>
                    </div>
                @endforeach
					<!-- End Column 1 -->

		      	</div>
		    </div>
		</div>
</x-app>