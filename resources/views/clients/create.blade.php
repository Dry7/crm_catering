@extends('layouts.app')

@section('contentheader_title', 'Создать клиента')

@section('htmlheader_title')
    Создать клиента
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! Form::open(['route' => 'clients.store']) !!}
                    @include('clients._form', ['client' => $client, 'is_admin' => $is_admin, 'staff' => $staff])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
