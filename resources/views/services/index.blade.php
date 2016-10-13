@extends('layouts.app')

@section('contentheader_title', 'Услуги')

@section('htmlheader_title')
    Услуги
@endsection

@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="input-box">
                        <a href="{{ route('services.create') }}" class="btn btn-success">Добавить услугу</a>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-hover datatable">
                        <thead>
                        <tr>
                            <th>Название</th>
                            <th>Выход, гр. за порцию</th>
                            <th>Цена за порцию, RUB</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($services as $service)
                        <tr>
                            <td><a href="{{ route('services.edit', $service->id) }}">{{ $service->name }}</a></td>
                            <td>@weight($service->weight)</td>
                            <td>@price($service->price)</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection