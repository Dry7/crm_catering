@extends('layouts.app')

@section('contentheader_title', 'Создать услугу')

@section('htmlheader_title')
    Создать услугу
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! Form::open(['route' => 'services.store']) !!}
                    @include('services._form', ['service' => $service])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
