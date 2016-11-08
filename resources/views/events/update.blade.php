@extends('layouts.app')

@section('contentheader_title', 'Редактировать мероприятие')

@section('htmlheader_title')
    Редактировать мероприятие
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! Form::open(['route' => ['events.update', $event->id], 'method' => 'PUT']) !!}
                    @include('events._form', [
                        'event' => $event, 'statuses' => $statuses, 'clients' => $clients, 'formats' => $formats, 'places' => $places,
                        'products' => $products, 'categories' => $categories, 'staff' => $staff, 'is_admin' => $is_admin, 'taxes' => $taxes,
                        'templates' => $templates, 'max_discount' => $max_discount
                    ])
                {!! Form::hidden('id', $event->id) !!}
                {!! Form::close() !!}
                <div class="box-footer">
                {!! Form::open(['route' => ['events.destroy', $event->id], 'method' => 'DELETE']) !!}
                    {!! Form::submit('Удалить', ['class' => 'btn btn-danger', 'onclick' => 'return confirm("Вы действительно хотите удалить это мероприятие?");']) !!}
                {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
