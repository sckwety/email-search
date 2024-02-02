<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Email Search</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="bg-secondary">
<div class="container">
    <div class="d-flex vh-100">
        <div class="m-auto">
            <form action="{{ route('email-search') }}" method="post">
                @csrf
                <h1 class="text-center">Emails Search</h1>
                <div class="row g-3 justify-content-center">
                    <div class="col-sm-7">
                        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}"
                               value="{{ old('name') }}"
                               name="name" placeholder="Name" aria-label="Name">
                        @if($errors->has('name'))
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-7">
                        <input type="text" class="form-control {{ $errors->has('company') ? 'is-invalid' : ''}}"
                               value="{{ old('company') }}"
                               name="company" placeholder="Company" aria-label="Company">
                        @if($errors->has('company'))
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('company') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-7">
                        <input type="text" class="form-control {{ $errors->has('linkedInProfileUrl') ? 'is-invalid' : ''}}"
                               value="{{ old('linkedInProfileUrl') }}"
                               name="linkedInProfileUrl" placeholder="LinkedIn profile URL" aria-label="LinkedIn profile URL">
                        @if($errors->has('linkedInProfileUrl'))
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('linkedInProfileUrl') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-7">
                        @if(Session::has('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                                @if(Session::has('result'))
                                    <pre>@php print_r(Session::get('result')) @endphp</pre>
                                @endif
                            </div>
                        @endif
                        <div class="d-flex">
                            <button class="btn btn-primary m-auto">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
