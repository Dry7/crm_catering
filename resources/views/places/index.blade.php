@extends('layouts.app')

@section('contentheader_title', 'Места')

@section('htmlheader_title')
    Места
@endsection

@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="input-box">
                        <a href="{{ route('places.create') }}" class="btn btn-success">Добавить место</a>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-hover datatable">
                        <thead>
                        <tr>
                            <th>Название</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($places as $place)
                        <tr>
                            <td><a href="{{ route('places.edit', $place->id) }}">{{ $place->name }}</a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection