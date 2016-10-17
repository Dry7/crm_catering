@extends('layouts.app')

@section('contentheader_title', 'Редактировать блюдо - ' . $product->name)

@section('htmlheader_title')
    Редактировать блюдо - {{ $product->name }}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! Form::open(['route' => ['products.update', $product->id], 'method' => 'PUT', 'files' => true]) !!}
                    @include('products._form', ['product' => $product, 'kitchens' => $kitchens, 'types' => $types])
                {!! Form::hidden('id', $product->id) !!}
                {!! Form::close() !!}
                <div class="box-footer">
                {!! Form::open(['route' => ['products.destroy', $product->id], 'method' => 'DELETE']) !!}
                    {!! Form::submit('Удалить', ['class' => 'btn btn-danger', 'onclick' => 'return confirm("Вы действительно хотите удалить это блюдо?");']) !!}
                {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
