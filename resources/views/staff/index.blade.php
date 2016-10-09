@extends('layouts.app')

@section('contentheader_title', 'Сотрудники')

@section('htmlheader_title')
    Сотрудники
@endsection

@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            {!! Form::open(['route' => 'staff.save-active']) !!}
            <div class="box">
                <div class="box-header">
                    <div class="input-box">
                        <a href="{{ route('staff.create') }}" class="btn btn-success">Добавить сотрудника</a>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-hover datatable">
                        <thead>
                        <tr>
                            <th>Должность</th>
                            <th>Фамилия</th>
                            <th>Имя</th>
                            <th>Отчество</th>
                            <th>Логин</th>
                            <th>Пароль</th>
                            <th>Доступ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td><a href="{{ route('staff.edit', $user->id) }}">{{ $user->job_label }}</a></td>
                            <td>{{ $user->surname }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->patronymic }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->password }}</td>
                            <td>
                                {{ Form::hidden('active[' . $user->id . ']', 0) }}
                                {{ Form::checkbox('active[' . $user->id . ']', 1, $user->active == 1) }}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="box-footer">
                    <div class="input-box">
                        {!! Form::submit('Сохранить', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
