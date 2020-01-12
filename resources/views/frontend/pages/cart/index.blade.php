@extends('frontend.layouts.master')

@section('content')
  <div class="main-panel">
    <div class="content-wrapper">

      <div class="card ml-2 mt-2 mr-2">
        <div class="card-header">
          My Cart
        </div>
        <div class="card-body ml-2 mt-2 mr-2">
            @include('frontend.layouts.messages')  
          <table class="table table-bordered table-striped">
              <tr>
                  <th>No.</th>
                  <th>Product Title</th>
                  <th>Product Image</th>
                  <th>Product Quantity</th>
                  <th>Unit Price</th>
                  <th>Sub Total Price</th>
                  <th>Delete</th>
              </tr>
              @php $total_price=0; @endphp
              @foreach($carts as $cart)
                <tr>
                  @php $product=$cart->product; @endphp
                    <td>{{$loop->index +1 }}</td>
                    <td>
                      <a href="{{ route('product.show',$product->slug) }}">
                        {{ $product->title }}
                      </a>
                    </td>
                    <td>
                        @if($product->images->count()>0)
                          <img src="{{asset('images/products/'.$product->images->first()->image )}}" width="80" height="60">
                        @endif
                    </td>

                    <td>
                      <form class="form-inline" action="{!! route('cart.update',$cart->id) !!}" method="post">
                        @csrf
                        <input type="number" name="product_quantity" class="form-control" value="{{ $cart->product_quantity }}">
                        <button type="submit" class="btn btn-success ml-2">Update</button>
                      </form>
                    </td>

                    <td>
                      {{ $product->price }} Taka
                    </td>

                    <td>
                      {{ $product->price*$cart->product_quantity }} Taka
                    </td>
                    @php $total_price+=$product->price*$cart->product_quantity; @endphp
                    {{-- <td>{{ $cart->product_quantity }}</td> --}}
                    <td> 
                        
                        <a href="#deleteModal{{ $cart->id }}" data-toggle="modal"  class="btn btn-danger">Delete</a>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal{{ $cart->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Are you sure to delete?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                      {{-- {!! route('frontend.cart.delete',$cart->id) !!} --}}
                                        <form action="{!! route('cart.delete',$cart->id) !!}" method="post">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger">Permanent Delete</button>
                                        </form>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>
              @endforeach

              <tr>
                <td colspan="4">
                  
                </td>
                <td>
                  <strong>Total Amount :</strong>
                </td>
                <td>
                  <strong>{{$total_price}} Taka</strong>
                </td>
                <td>

                </td>
              </tr>

          </table>
          
          <div class="float-right">
            <a href="{{ route('products')}}" class="btn btn-info btn-lg"> Continue Shopping...</a>
            <a href="{{ route('checkout')}}" class="btn btn-warning btn-lg"> Checkout</a>
          </div>

        </div>
      </div>

    </div>
  </div>
  <!-- main-panel ends -->
@endsection
