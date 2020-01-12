@extends('admin.layouts.master')

@section('content')
  <div class="main-panel">
    <div class="content-wrapper">

      <div class="card">
        <div class="card-header">
          Add Category
        </div>
        <div class="card-body">
          <form action="{{ route('admin.category.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @include('admin.partials.messages')
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" name="name" id="name" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Description</label>
              <textarea name="description" rows="8" cols="80" class="form-control"></textarea>
            </div>

            <div class="form-group">
              <label for="exampleInputPassword1">Parent Category</label>
              <select class="form-control" name="parent_id" id="">
                <option value="">Primay Category</option>
                @foreach($main_categories as $main_category)
                  <option value="{{ $main_category->id}}">{{ $main_category->name}}</option>
                  
                @endforeach
              </select>
            </div>
            
            <div class="form-group">
              <label for="category_image">Category Image</label>
             
              <input type="file" class="form-control" name="category_image" id="category_image" aria-describedby="emailHelp" placeholder="Enter email">
              
            </div>

            <button type="submit" class="btn btn-primary">Add Category</button>
          </form>
        </div>
      </div>

    </div>
  </div>
  <!-- main-panel ends -->
@endsection
