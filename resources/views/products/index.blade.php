@extends('layouts.app')

@section('contentheader_title', 'Меню')

@section('htmlheader_title')
    Меню
@endsection

@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="input-box">
                        <a href="{{ route('products.create') }}" class="btn btn-success">Добавить блюдо</a>
                    </div>
                    <div>
                        <div style="float: left; padding-right: 10px;">Кухня:</div>
                        <ul>
                            <li style="float: left; list-style-type: none; padding-right: 10px;"><a href="javascript:void(0);" style="text-decoration: none; border-bottom: 1px dashed #3c8dbc;">японская</a></li>
                            <li style="float: left; list-style-type: none; padding-right: 10px;"><a href="javascript:void(0);" style="text-decoration: none; border-bottom: 1px dashed #3c8dbc;">русская</a></li>
                            <li style="float: left; list-style-type: none;"><a href="javascript:void(0);" style="text-decoration: none; border-bottom: 1px dashed #3c8dbc;">итальянская</a></li>
                        </ul>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-hover datatable" id="products">
                        <thead>
                        <tr>
                            <th>Название</th>
                            <th>Выход, гр. за порцию</th>
                            <th>Цена за порцию, RUB</th>
                            <th>Кухня</th>
                            <th>Тип блюда</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td><a href="{{ route('products.edit', $product->id) }}">{{ $product->name }}</a></td>
                            <td data-order="{{ $product->weight }}">@weight($product->weight)</td>
                            <td data-order="{{ $product->price }}">@price($product->price)</td>
                            <td>{{ $product->kitchen }}</td>
                            <td>{{ $product->type }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection