@extends('layouts.app')

@section('contentheader_title', 'Создать блюдо')

@section('htmlheader_title')
    Создать блюдо
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! Form::open(['route' => 'products.store', 'files' => true]) !!}
                    @include('products._form', ['product' => $product, 'kitchens' => $kitchens, 'types' => $types])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
