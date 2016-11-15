@extends('layouts.app')

@section('contentheader_title', 'Создать сотрудника')

@section('htmlheader_title')
    Создать сотрудника
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! Form::open(['route' => 'staff.store', 'files' => true]) !!}
                    @include('staff._form', ['user' => $user])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
