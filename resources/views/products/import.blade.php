@extends('layouts.app')

@section('contentheader_title', 'Импорт товаров')

@section('htmlheader_title')
    Импорт товаров
@endsection

@section('main-content')

    @if($message)
    <div class="alert alert-success">
        <ul>
            <li>Товары успешно добавлены</li>
        </ul>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! Form::open(['route' => ['products.import'], 'method' => 'POST', 'files' => true]) !!}
                <div class="box-body">
                    @include('common.errors')
                    <div class="form-group">
                        {!! Form::label('file', 'Файл') !!}
                        {!! Form::file('file') !!}
                    </div>
                </div>

                <div class="box-footer">
                    {!! Form::submit('Импортировать', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
