@extends('frontend.layouts.master')
@section('content')

<div class="container mt-2">
    <div class="row">
        <div class="col-md-4">
            <div class="list-group">
                <a href="" class="list-group-item">
                    <img src="{{ asset('images/users/user.png') }}" width="100">
                </a>
                <a href="{{route('dashboard')}}" class="list-group-item {{Route::is('dashboard') ? 'active':''}}">Dasshboard</a>
                <a href="{{route('user.edit')}}" class="list-group-item {{Route::is('user.edit') ? 'active':''}}">Edit Profile</a>
                <a href="{{route('logout')}}" class="list-group-item"
                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card card-body">
                @yield('sub-content')
            </div>
            
        </div>

    </div>
    
</div>

@endsection