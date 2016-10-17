@extends('layouts.app')

@section('contentheader_title', 'Мероприятия')

@section('htmlheader_title')
    Мероприятия
@endsection

@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="input-box">
                        <a href="{{ route('products.create') }}" class="btn btn-success">Добавить мероприятие</a>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            Фильтры
                        </div>
                        <div class="col-md-2">
                            {!! Form::select('filter_status_id', $statuses, null, ['id' => 'filter_status_id', 'size' => 4, 'class' => 'form-control filter', 'multiple' => true]) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::select('filter_client_id', $clients, null, ['id' => 'filter_client_id', 'size' => 4, 'class' => 'form-control filter', 'multiple' => true]) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::select('filter_format_id', $formats, null, ['id' => 'filter_format_id', 'size' => 4, 'class' => 'form-control filter', 'multiple' => true]) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::select('filter_place_id', $places, null, ['id' => 'filter_place_id', 'size' => 4, 'class' => 'form-control filter', 'multiple' => true]) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::button('Подобрать') !!}
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-hover datatable" id="events" data-page-length="50">
                        <thead>
                        <tr>
                            <th>Статус</th>
                            <th>Компания</th>
                            <th>Дата</th>
                            <th>Формат мероприятия</th>
                            <th>Количество персон</th>
                            <th>Количество столов</th>
                            <th>Место проведения</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($events as $event)
                        <tr>
                            <td data-search="{{ $event->status }}" data-order="{{ $event->status }}">{{ $event->status }}</td>
                            <td data-search="{{ is_object($event->client) ? $event->client->name : '' }}" data-order="{{ is_object($event->client) ? $event->client->name : '' }}">{{ is_object($event->client) ? $event->client->name : '' }}</td>
                            <td data-order="{{ $event->date }}"><a href="{{ route('events.edit', $event->id) }}">@date($event->date)</a></td>
                            <td data-search="{{ $event->format }}" data-order="{{ $event->format }}">{{ $event->format }}</td>
                            <td data-search="{{ $event->persons }}" data-order="{{ $event->persons }}">{{ $event->persons }}</td>
                            <td data-search="{{ $event->tables }}" data-order="{{ $event->tables }}">{{ $event->tables }}</td>
                            <td data-search="{{ is_object($event->place) ? $event->place->name : '' }}" data-order="{{ is_object($event->place) ? $event->place->name : '' }}">{{ is_object($event->place) ? $event->place->name : '' }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection