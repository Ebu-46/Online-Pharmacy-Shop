@extends('frontend.layouts.master')
@section('content')

<div class="container margin-top-20">
    @include('frontend.layouts.messages') 
    <div class="card card-body">
      <h2>Confirm items</h2>
      <hr>
      <div class="row">
        <div class="col-md-7">
          @foreach($carts as $cart)
            <p>{{ $cart->product->title }}
            --{{ $cart->product->price }} taka  per item
            --{{ $cart->product_quantity }} item selected
            </p>
          @endforeach
          <p>
            <a href="{{route('cart')}}">Change Cart Items</a>
          </p>
        </div>

        <div class="col-md-5">
          @php $total_price=0; @endphp
          @foreach($carts as $cart)
            @php $total_price+=$cart->product->price*$cart->product_quantity; @endphp
          @endforeach
          <p><strong>Total Price : {{$total_price}} Taka</strong></p>
          <p><strong>Total Price with Shipping Cost(100 Taka) : {{$total_price+100}} Taka</strong></p>
        </div>

      </div>
      
    </div>
    
    <div class="card card-body mt-2">
      <h2>Shipping Address</h2>
      <hr>
      @php $user=Auth::user(); @endphp
      <div class="card">

        <div class="card-body">
            <form method="POST" action="{{ route('checkout.store') }}">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Receiver Name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::check() ? Auth::user()->name:'' }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::check() ? Auth::user()->email:'' }}"  autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                    <div class="col-md-6">
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone_no" required autocomplete="phone_no">

                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="shipping-address" class="col-md-4 col-form-label text-md-right">{{ __('Shipping Address') }}</label>

                    <div class="col-md-6">
                        <input id="shipping-address" type="text" class="form-control" name="shipping_address" required autocomplete="shipping_address">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="payment-method" class="col-md-4 col-form-label text-md-right">{{ __('Payment Method') }}</label>

                    <div class="col-md-6">
                        <select name="payment_short_name" class="form-control" required id="payments" >
                            <option value="">Select a Payment method</option>
                            @foreach (App\Models\Payment::orderBy('priority','asc')->get() as $payment)
                                <option value="{{$payment->short_name}}">{{$payment->name}}</option>
                            @endforeach
                        </select>

                        @foreach (App\Models\Payment::orderBy('priority','asc')->get() as $payment)
                            
                            @if($payment->short_name=="cash_in")
                                <div id="payment_{{$payment->short_name}}" class="alert alert-success hidden mt-2">
                                    <h3>
                                        For Cash in there is nothing necessary. just click Order Now.
                                        <br>
                                        <small>
                                            you will get your product in 2 or 3 hours.
                                        </small>

                                    </h3>
                                </div>
                                    
                            @else
                                @if ($payment->short_name=="bkash")
                                    <div id="payment_{{$payment->short_name}}" class="alert alert-success hidden mt-2">
                                        <h3>
                                            Bkash Payment
                                        </h3>
                                        <p>
                                            <strong>Bkash No : {{$payment->no}}</strong>
                                            <br>
                                            <strong>Account Type : {{$payment->type}}</strong>
                                        </p>

                                        <div class="alert alert-success">
                                            Please send the above money to this Bkash acount no and give your transaction code below there...
                                        </div>
                                        
                                    </div>
                                    
                                @else
                                    <div id="payment_{{$payment->short_name}}" class="alert alert-success hidden mt-2">
                                        <h3>
                                            Rocket Payment
                                        </h3>
                                        <p>
                                            <strong>Rocket No : {{$payment->no}}</strong>
                                            <br>
                                            <strong>Account Type : {{$payment->type}}</strong>
                                        </p>

                                        <div class="alert alert-success">
                                            Please send the above money to this Rocket acount no and give your transaction code below there...
                                        </div>
                                        
                                    </div>
                                @endif
                                
                            @endif
                            
                         @endforeach

                         <input type="text" id="transaction_id" name="transaction_id" class="hidden form form-control" placeholder="Enter transaction code">
                        
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Order Now') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>

</div>

@endsection

@section('scripts')

<script type="text/javascript">
 $("#payments").change(function(){
    $payment_method = $("#payments").val();
    //alert($payment_method);
    if($payment_method=="cash_in"){
        //alert($payment_method);
        $("#payment_cash_in").removeClass('hidden');
        $("#payment_bkash").addClass('hidden');
        $("#payment_rocket").addClass('hidden');
        $("#transaction_id").addClass('hidden');
    }
    else if($payment_method=="bkash"){
        $("#payment_bkash").removeClass('hidden');
        $("#transaction_id").removeClass('hidden');
        $("#payment_cash_in").addClass('hidden');
        $("#payment_rocket").addClass('hidden');
    }
    else if($payment_method=="rocket"){
        $("#payment_rocket").removeClass('hidden');
        $("#transaction_id").removeClass('hidden');
        $("#payment_cash_in").addClass('hidden');
        $("#payment_bkash").addClass('hidden');
    }
    else{
        $("#payment_rocket").addClass('hidden');
        $("#payment_cash_in").addClass('hidden');
        $("#payment_bkash").addClass('hidden');
        $("#transaction_id").addClass('hidden');
    }
    
 })
</script>

@endsection