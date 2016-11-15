@extends('layouts.app')

@section('contentheader_title', 'Действия менеджеров')

@section('htmlheader_title')
    Действия менеджеров
@endsection

@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Менеджер</th>
                            <th>Действие</th>
                            <th>Элемент</th>
                            <th>Дата</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                        <tr>
                            <td>{{ $log->user->full_name }}</td>
                            <td>{{ $log->event_name }}</td>
                            <td>{{ $log->element_name }}</td>
                            <td>{{ $log->date }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="box-footer">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection