<div class="box-body">
    @include('common.errors')
    <div class="form-group">
        {!! Form::label('name', 'Название *') !!}
        {!! Form::text('name', $service->name, ['id' => 'name', 'class' => 'form-control', 'placeholder' => 'Введите название', 'require' => 'require']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('weight', 'Выход, гр. за порцию') !!}
        {!! Form::number('weight', $service->weight, ['class' => 'form-control', 'id' => 'weight', 'placeholder' => 'Введите выход, гр. за порцию']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('price', 'Цена за порцию, RUB') !!}
        {!! Form::number('price', $service->price, ['class' => 'form-control', 'id' => 'price', 'placeholder' => 'Введите цена за порцию, RUB']) !!}
    </div>
</div>

<div class="box-footer">
    {!! Form::submit('Сохранить', ['class' => 'btn btn-primary']) !!}
</div>