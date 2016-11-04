<div class="box-body">
    @include('common.errors')
    <div class="form-group">
        {!! Form::label('name', 'Название *') !!}
        {!! Form::text('name', $product->name, ['id' => 'name', 'class' => 'form-control', 'placeholder' => 'Введите название', 'require' => 'require']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('name_en', 'Название на английском') !!}
        {!! Form::text('name_en', $product->name_en, ['id' => 'name_en', 'class' => 'form-control', 'placeholder' => 'Введите название на английском']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('weight', 'Выход, гр. за порцию *') !!}
        {!! Form::number('weight', $product->weight, ['class' => 'form-control', 'id' => 'weight', 'placeholder' => 'Введите выход, гр. за порцию']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('cost', 'Себестоимость за порцию, RUB') !!}
        {!! Form::number('cost', $product->cost, ['class' => 'form-control', 'id' => 'cost', 'placeholder' => 'Введите себестоимость за порцию, RUB']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('markup', 'Наценка') !!}
        {!! Form::number('markup', $product->markup, ['class' => 'form-control', 'id' => 'markup', 'placeholder' => 'Введите наценку, %']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('price', 'Цена за порцию, RUB') !!}
        {!! Form::number('price', $product->price, ['class' => 'form-control', 'id' => 'price', 'placeholder' => 'Введите цену за порцию, RUB']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('kitchen_id', 'Кухня') !!}
        {!! Form::select('kitchen_id', $kitchens, $product->kitchen_id, ['class' => 'form-control', 'id' => 'kitchen_id', 'placeholder' => 'Выберите кухню']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('type_id', 'Тип блюда') !!}
        {!! Form::select('type_id', $types, $product->type_id, ['class' => 'form-control', 'id' => 'type_id', 'placeholder' => 'Выберите тип блюда']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('photography', 'Фотография') !!}
        @if($product->photo_has)
            <br />
            <img src="{{ $product->photo_url }}" class="photo" style="max-width: 200px;" />
        @endif
        {!! Form::file('photography') !!}
    </div>
</div>

<div class="box-footer">
    {!! Form::submit('Сохранить', ['class' => 'btn btn-primary']) !!}
</div>