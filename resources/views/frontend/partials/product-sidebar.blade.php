<div class="list-group mt-2 ml-5 mr-5">

    @foreach (App\Models\Category::orderBy('name','asc')->where('parent_id',NULL)->get() as $category)
        <a href="#main-{{$category->id}}" class="list-group-item list-group-item-action" data-toggle="collapse"> 
            <img src="{{ asset('images/categories/'.$category->image) }}" alt="" width="50">
            {{ $category->name }} 
        </a>

        <div class="collapse" id="main-{{$category->id}}">
            <div class="sub-rows">
                @foreach (App\Models\Category::orderBy('name','asc')->where('parent_id',$category->id)->get() as $sub_category)
                <a href="#main-{{$category->id}}" class="list-group-item list-group-item-action"> 
                    <img src="{{ asset('images/categories/'.$sub_category->image) }}" alt="" width="30">
                    {{ $sub_category->name }} 
                </a>
            @endforeach
            </div>
            
        </div>
    @endforeach

</div>