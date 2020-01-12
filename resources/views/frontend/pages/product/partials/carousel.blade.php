<div id="myCarousel" class="carousel slide" data-ride="carousel">

  <!-- Indicators -->
  <ul class="carousel-indicators">
    @php $i=0; @endphp
    @foreach ($product->images as $image)
        <li data-target="#myCarousel" data-slide-to="{{ $i }}" class="{{ $i==0 ? 'active':'' }}"></li>
        @php $i++; @endphp
    @endforeach 
  </ul>
  
  <!-- The slideshow -->
  <div class="carousel-inner">
    @php $i=0; @endphp
    @foreach ($product->images as $image)
        <div class="carousel-item {{ $i==0 ? 'active':'' }}">
            <img src="{{asset('images/products/'.$image->image)}}" alt="Los Angeles" width="600" height="500">
        </div>
        @php $i++; @endphp
    @endforeach

  </div>
  
  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#myCarousel" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
</div>