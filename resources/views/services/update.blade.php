@extends('layouts.app')

@section('contentheader_title', 'Редактировать услугу - ' . $service->name)

@section('htmlheader_title')
    Редактировать услугу - {{ $service->name }}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! Form::open(['route' => ['services.update', $service->id], 'method' => 'PUT']) !!}
                    @include('services._form', ['client' => $service])
                {!! Form::hidden('id', $service->id) !!}
                {!! Form::close() !!}
                <div class="box-footer">
                {!! Form::open(['route' => ['services.destroy', $service->id], 'method' => 'DELETE']) !!}
                    {!! Form::submit('Удалить', ['class' => 'btn btn-danger', 'onclick' => 'return confirm("Вы действительно хотите удалить эту услугу?");']) !!}
                {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
