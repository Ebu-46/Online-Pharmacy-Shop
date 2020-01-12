<form class="form-inline" action="{{ route('cart.store')}}" method="post">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <button type="submit" class="btn btn-warning cart-button">Add to cart</button>
</form>