@extends('layouts.app')

@section('contentheader_title', 'Редактировать клиента - ' . $client->name)

@section('htmlheader_title')
    Редактировать клинета - {{ $client->name }}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! Form::open(['route' => ['clients.update', $client->id], 'method' => 'PUT']) !!}
                    @include('clients._form', ['client' => $client])
                {!! Form::hidden('id', $client->id) !!}
                {!! Form::close() !!}
                <div class="box-footer">
                {!! Form::open(['route' => ['clients.destroy', $client->id], 'method' => 'DELETE']) !!}
                    {!! Form::submit('Удалить', ['class' => 'btn btn-danger', 'onclick' => 'return confirm("Вы действительно хотите удалить этого клиента?");']) !!}
                {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
