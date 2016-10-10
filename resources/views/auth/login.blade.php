@extends('layouts.auth')

@section('htmlheader_title')
    Log in
@endsection

@section('content')
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="/img/logo.png" />
        </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Ошибки</strong><br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($message != '')
        <div class="alert alert-danger">
            <ul>
                <li>{{ $message }}</li>
            </ul>
        </div>
    @endif

    <div class="login-box-body">
    <form action="{{ url('/login') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Логин" name="username"/>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Пароль" name="password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="remember"> Запомнить меня
                    </label>
                </div>
            </div>
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Войти</button>
            </div>
        </div>
    </form>
</div>

</div>

</body>

@endsection
