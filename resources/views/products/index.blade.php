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
                    <div class="filter">
                        <div>Кухня:</div>
                        <ul id="filter_kitchen">
                            @foreach($kitchens as $kitchen)
                            <li><a href="javascript:void(0);" onClick="setFilter(this);" data-value="{{ $kitchen->name }}">{{ $kitchen->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="filter">
                        <div>Тип блюда:</div>
                        <ul id="filter_type">
                            @foreach($types as $type)
                            <li><a href="javascript:void(0);" onClick="setFilter(this);" data-value="{{ $type->name }}">{{ $type->name }}</a></li>
                            @endforeach
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
                            <td>{{ is_object($product->kitchen) ? $product->kitchen->name : '' }}</td>
                            <td>{{ is_object($product->type) ? $product->type->name : '' }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection