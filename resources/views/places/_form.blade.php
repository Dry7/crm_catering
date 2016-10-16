<div class="box-body">
    @include('common.errors')
    <div class="form-group">
        {!! Form::label('name', 'Название *') !!}
        {!! Form::text('name', $place->name, ['id' => 'name', 'class' => 'form-control', 'placeholder' => 'Введите название', 'require' => 'require']) !!}
    </div>
</div>

<div class="box-footer">
    {!! Form::submit('Сохранить', ['class' => 'btn btn-primary']) !!}
</div>