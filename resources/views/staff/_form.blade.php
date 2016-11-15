<div class="box-body">
    @include('common.errors')
    <div class="form-group">
        {!! Form::label('job', 'Должность') !!}
        {!! Form::select('job', ['admin' => 'Администратор', 'manager' => 'Менеджер', 'cook' => 'Повар'], $user->job, ['id' => 'job', 'class' => 'form-control', 'size' => 3, 'require' => 'require']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('surname', 'Фамилия') !!}
        {!! Form::text('surname', $user->surname, ['class' => 'form-control', 'id' => 'surname', 'placeholder' => 'Введите фамилию']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('name', 'Имя') !!}
        {!! Form::text('name', $user->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Введите имя']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('patronymic', 'Отчество') !!}
        {!! Form::text('patronymic', $user->patronymic, ['class' => 'form-control', 'id' => 'patronymic', 'placeholder' => 'Введите отчество']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('username', 'Логин') !!}
        {!! Form::text('username', $user->username, ['class' => 'form-control', 'id' => 'username', 'placeholder' => 'Введите логин', 'require' => 'require']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('password', 'Пароль') !!}
        {!! Form::text('password', $user->password, ['class' => 'form-control', 'id' => 'password', 'placeholder' => 'Введите пароль', 'require' => 'require']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('email', 'E-mail') !!}
        {!! Form::email('email', $user->email, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Введите e-mail']) !!}
    </div>
    <div class="checkbox">
        <label>
            {!! Form::hidden('active', 0) !!}
            {!! Form::checkbox('active', 1, $user->active) !!}
            Доступ
        </label>
    </div>
    <div class="checkbox">
        <label>
            {!! Form::hidden('work_hours', 0) !!}
            {!! Form::checkbox('work_hours', 1, $user->work_hours) !!}
            Доступ только в рабочее время
        </label>
    </div>
    <div class="form-group">
        {!! Form::label('photography', 'Фотография') !!}
        @if($user->photo_has)
            <br />
            <img src="{{ $user->photo_url }}" class="photo" style="max-width: 200px;" />
        @endif
        {!! Form::file('photography') !!}
    </div>
</div>

<div class="box-footer">
    {!! Form::submit('Сохранить', ['class' => 'btn btn-primary']) !!}
</div>