@extends('frontend.pages.user.master')
@section('sub-content')

<div class="container margin-top-20">
    @include('frontend.layouts.messages')
    <h2>Welcome {{$user->name}}</h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi quaerat inventore culpa fugit, voluptate odit repellat mollitia cum itaque ipsa nemo veniam quas, eaque non. Deserunt modi rerum atque. Quisquam?</p>
</div>

@endsection