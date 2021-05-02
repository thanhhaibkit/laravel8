@if (isset($errors) && $errors->any())
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif

@if (session('status'))
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-{{ session('status.type') }} alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('status.message') }}
                </div>
            </div>
        </div>
    </div>
@endif

@if ($errMsg = \Session::get('errMsg'))
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ $errMsg }}
                </div>
            </div>
        </div>
    </div>
@endif
