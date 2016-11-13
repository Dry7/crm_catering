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
                        <a href="{{ route('events.create') }}" class="btn btn-success">Добавить мероприятие</a>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-md-2">
                            Фильтры
                        </div>
                        <div class="col-md-2">
                            <b>Статус проекта:</b><br />
                            {!! Form::select('filter_status_id', $statuses, null, ['id' => 'filter_status_id', 'size' => 4, 'class' => 'form-control filter', 'multiple' => true, 'title' => 'Выделить несколько элементов можно зажав Ctrl и кликнув на нужные элементы. Снять выделение можно зажав Ctrl и кликнув на элемент.']) !!}
                        </div>
                        <div class="col-md-2">
                            <b>Компания:</b><br />
                            {!! Form::select('filter_client_id', $clients, null, ['id' => 'filter_client_id', 'size' => 4, 'class' => 'form-control filter', 'multiple' => true, 'title' => 'Выделить несколько элементов можно зажав Ctrl и кликнув на нужные элементы. Снять выделение можно зажав Ctrl и кликнув на элемент.']) !!}
                        </div>
                        <div class="col-md-2">
                            <b>Направление:</b><br />
                            {!! Form::select('filter_format_id', $formats, null, ['id' => 'filter_format_id', 'size' => 4, 'class' => 'form-control filter', 'multiple' => true, 'title' => 'Выделить несколько элементов можно зажав Ctrl и кликнув на нужные элементы. Снять выделение можно зажав Ctrl и кликнув на элемент.']) !!}
                        </div>
                        <div class="col-md-2">
                            <b>Место проведения:</b><br />
                            {!! Form::select('filter_place_id', $places, null, ['id' => 'filter_place_id', 'size' => 4, 'class' => 'form-control filter', 'multiple' => true, 'title' => 'Выделить несколько элементов можно зажав Ctrl и кликнув на нужные элементы. Снять выделение можно зажав Ctrl и кликнув на элемент.']) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::button('Подобрать', ['class' => 'btn btn-primary']) !!}
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
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($events as $event)
                        <tr>
                            <td data-search="{{ $event->status }}" data-order="{{ $event->status }}"><a href="#" data-type="select" data-pk="{{ $event->id }}" data-name="status_id">{{ $event->status }}</a></td>
                            <td data-search="{{ is_object($event->client) ? $event->client->name : '' }}" data-order="{{ is_object($event->client) ? $event->client->name : '' }}">
                                <a href="#" data-type="select" data-pk="{{ $event->id }}" data-name="client_id">{{ is_object($event->client) ? $event->client->name : '' }}</a>
                            </td>
                            <td data-order="{{ $event->date }}"><a href="{{ route('events.edit', $event->id) }}">@date($event->date)</a></td>
                            <td data-search="{{ $event->format }}" data-order="{{ $event->format }}">
                                <a href="#" data-type="select" data-pk="{{ $event->id }}" data-name="format_id">{{ $event->format }}</a>
                            </td>
                            <td data-search="{{ $event->persons }}" data-order="{{ $event->persons }}">
                                <a href="#" data-type="text" data-pk="{{ $event->id }}" data-name="persons">{{ $event->persons }}</a>
                            </td>
                            <td data-search="{{ $event->tables }}" data-order="{{ $event->tables }}">
                                <a href="#" data-type="text" data-pk="{{ $event->id }}" data-name="tables">{{ $event->tables }}</a>
                            </td>
                            <td data-search="{{ is_object($event->place) ? $event->place->name : '' }}" data-order="{{ is_object($event->place) ? $event->place->name : '' }}">
                                <a href="#" data-type="select" data-pk="{{ $event->id }}" data-name="place_id">{{ is_object($event->place) ? $event->place->name : '' }}</a>
                            </td>
                            <td>
                                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-primary">Редактировать</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection