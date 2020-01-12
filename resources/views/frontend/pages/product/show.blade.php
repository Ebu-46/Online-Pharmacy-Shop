@extends('frontend.layouts.master')

@section('title')
    {{ $product->title}} | Online Phamacy Shop
@endsection

@section('content')

<!-- start slidebar + content -->
            
<div class="container margin-top-20" >
                <div class="row">
                    <div class="col-md-6">
                        @include('frontend.pages.product.partials.carousel')

                        <div class="mt-3">
                            {{-- <p>Category <span class="badge badge-info"> {{App\Models\Category::find($product->category_id)->name}}</span></p>
                            <p>Category <span class="badge badge-info"> {{App\Models\Brand::find($product->brand_id)->name}}</span></p> --}}
                            {{-- //using relational model --}}
                            <p>Category <span class="badge badge-info"> {{$product->category->name}}</span></p>
                            <p>Brand <span class="badge badge-info"> {{$product->brand->name}}</span></p>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="widget">
                            <h3>{{ $product->title }}</h3>
                            <h3>{{ $product->price }} Taka
                                <span class="badge badge-primary">
                                    {{ $product->quantity < 1 ? 'No item is available':$product->quantity.' item in stock' }}
                                </span>
                            </h3>
                            <hr>
                            <div class="product-description">
                                {{ $product->description }}
                            </div>
                        </div>

                    </div>


                </div>
            </div>

            <!-- end slidebar + content -->

@endsection