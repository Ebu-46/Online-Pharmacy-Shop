@if ($errors->any())
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif

@if(Session::has('success'))
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{{ Session::get('success') }} </p>
                </div>
            </div>
        </div>
    </div>
@endif

@if(Session::has('Errors'))
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{{ Session::get('Errors') }} </p>
                </div>
            </div>
        </div>
    </div>
@endif