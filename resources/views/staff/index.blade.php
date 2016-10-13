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
                    <div class="pull-right">
                        {{ Form::select('filter_active', [0 => '- Активность -', 1 => 'Только активные', 2 => 'Только неактивные'], 0, ['id' => 'filter_active', 'class' => 'form-control']) }}
                        <br />
                        {{ Form::select('filter_work hours', [0 => '- Доступ в рабочее время -', 1 => 'Есть доступ только в рабочее время', 2 => 'Доступ не ограничен по времени'], 0, ['id' => 'filter_work_hours', 'class' => 'form-control']) }}
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-hover datatable" id="staff">
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
                            <td data-order="{{ $user->active }}" data-active="{{ $user->active }}" data-work-hours="{{ $user->work_hours }}">
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
