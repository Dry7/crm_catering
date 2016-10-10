@extends('layouts.app')

@section('contentheader_title', 'Клиенты')

@section('htmlheader_title')
    Клиенты
@endsection

@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="input-box">
                        <a href="{{ route('clients.create') }}" class="btn btn-success">Добавить клиента</a>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-hover datatable">
                        <thead>
                        <tr>
                            <th>Компания</th>
                            <th>Телефон (раб)</th>
                            <th>Телефон (моб)</th>
                            <th>E-mail</th>
                            <th>Контактное Лицо</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clients as $client)
                        <tr>
                            <td><a href="{{ route('clients.edit', $client->id) }}">{{ $client->name }}</a></td>
                            <td>{{ $client->phone_work }}</td>
                            <td>{{ $client->phone_mobile }}</td>
                            <td>{{ $client->email }}</td>
                            <td>{{ $client->fio }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection