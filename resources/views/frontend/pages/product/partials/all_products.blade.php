<div class="row">
    @php $i=0; @endphp
    @foreach ($products as $product)
        <div class="col-md-3">
            <div class="card feature-card mt-2 mb-2">
                {{-- @foreach ($product->images as $image)
                    <a href="{{ route('product.show',$product->slug) }}">
                        <img class="card-img-top feature-img" src="{{asset('images/products/'.$image->image)}}" width="100" height="80">
                    </a>
                    @php $i=1; @endphp
                    @if($i==1) @break; @endif
                @endforeach --}}

                @if($product->images->count()>0)
                    <img class="card-img-top feature-img" src="{{asset('images/products/'.$product->images->first()->image )}}" height="130">
                @else 
                    <img class="card-img-top feature-img" src="{{asset('images/beauties/null.png')}}" height="130">
                @endif

                <div class="card-body">
                    <h4 class="card-title">
                        <a href="{{ route('product.show',$product->slug) }}">
                            {{ $product->title }}
                        </a>
                    </h4>
                    <p class="card-text">Taka {{ $product->price }}</p>
                    @include('frontend.pages.product.partials.cart-button')
                    {{-- <a href="#" class="btn btn-outline-warning">Add to cart</a> --}}
                </div>
            </div>
        </div>

    @endforeach  
</div>

<div class="mt-4 pagination">
    {{ $products->links() }}
</div>