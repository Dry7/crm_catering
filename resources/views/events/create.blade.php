@extends('layouts.app')

@section('contentheader_title', 'Создать мероприятие')

@section('htmlheader_title')
    Создать мероприятие
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! Form::open(['route' => 'events.store', 'files' => true]) !!}
                    @include('events._form', [
                        'event' => $event, 'statuses' => $statuses, 'clients' => $clients, 'formats' => $formats, 'places' => $places,
                        'products' => $products, 'categories' => $categories, 'staff' => $staff, 'is_admin' => $is_admin, 'taxes' => $taxes,
                        'templates' => $templates
                    ])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
