@extends('layouts.app')

@section('contentheader_title', 'Редактировать место - ' . $place->name)

@section('htmlheader_title')
    Редактировать место - {{ $place->name }}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! Form::open(['route' => ['places.update', $place->id], 'method' => 'PUT']) !!}
                    @include('places._form', ['place' => $place])
                {!! Form::hidden('id', $place->id) !!}
                {!! Form::close() !!}
                <div class="box-footer">
                {!! Form::open(['route' => ['places.destroy', $place->id], 'method' => 'DELETE']) !!}
                    {!! Form::submit('Удалить', ['class' => 'btn btn-danger', 'onclick' => 'return confirm("Вы действительно хотите удалить это место?");']) !!}
                {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
