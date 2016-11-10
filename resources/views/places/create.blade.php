@extends('layouts.app')

@section('contentheader_title', 'Создать место')

@section('htmlheader_title')
    Создать место
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! Form::open(['route' => 'places.store']) !!}
                    @include('places._form', ['place' => $place])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
