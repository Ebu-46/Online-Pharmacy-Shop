<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>
            @yield('title','Online Pharmacy Shop')
        </title>
        @include('frontend.partials.styles')
    </head>

    <body>
        <div class="wrapper">
            {{--navigation--}}

            @include('frontend.partials.nav')

            @yield('content')
            
            @include('frontend.partials.footer')

        </div>
        @include('frontend.partials.scripts')
        @yield('scripts')
    </body>

</html>