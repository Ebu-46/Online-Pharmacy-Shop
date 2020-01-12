@extends('admin.layouts.master')

@section('content')
  <div class="main-panel">
    <div class="content-wrapper">

      <div class="card">
        <div class="card-header">
          Edit Category
        </div>
        <div class="card-body">
          <form action="{{ route('admin.category.update',$category->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @include('admin.partials.messages')
            <div class="form-group">
              <label for="exampleInputEmail1">Name</label>
              <input type="text" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $category->name }}">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Description</label>
              <textarea name="description" rows="8" cols="80" class="form-control">{{ $category->description }}</textarea>
            </div>

            <div class="form-group">
              <label for="exampleInputPassword1">Parent Category</label>
              {{-- @if($category->parent_id == NULL)
                @php $parent_name = "NULL";@endphp
              @else
                @php $parent_name = $category->parent->name;@endphp
              @endif --}}
              <select class="form-control" name="parent_id">
                <option value="">Primay Category</option>
                @foreach($main_categories as $main_category)
                  @if($main_category->id==$category->id) 
                    @continue
                  @endif
                  <option value="{{ $main_category->id}}" {{$main_category->id==$category->parent_id ? 'selected':''}}>{{ $main_category->name}}</option>
                  
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="category_image">Category old Image</label> <br>
              <img src="{!! asset('images/categories/'.$category->image) !!}" width="100">
            </div>
            
            <div class="form-group">
              <label for="category_image">Category New Image</label>
              <div class="row">
                <div class="col-md-4">
                  <input type="file" class="form-control" name="category_image" id="category_image" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
              </div>
              
            </div>

            <button type="submit" class="btn btn-primary">Update Category</button>
          </form>
        </div>
      </div>

    </div>
  </div>
  <!-- main-panel ends -->
@endsection
