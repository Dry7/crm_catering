<div class="box-body">
    @include('common.errors')
    <div class="row">
        <div class="col-md-6">
            @if($is_admin)
                <div class="form-group">
                    {!! Form::label('user_id', 'Сотрудник') !!}
                    {!! Form::select('user_id', $staff, $event->user_id, ['class' => 'form-control select2', 'id' => 'user_id', 'placeholder' => 'Выберите сотрудника']) !!}
                </div>
            @endif
            <div class="form-group">
                {!! Form::label('status_id', 'Статус *') !!}
                {!! Form::select('status_id', $statuses, $event->status_id, ['class' => 'form-control', 'id' => 'status_id', 'placeholder' => 'Выберите статус']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('client_id', 'Компания') !!}
                {!! Form::select('client_id', $clients, $event->client_id, ['class' => 'form-control select2', 'id' => 'client_id', 'placeholder' => 'Выберите компанию']) !!}
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('date', 'Дата') !!}
                        {!! Form::text('date', $event->date !== null ? $event->date->format('d.m.Y') : '', ['class' => 'form-control datepicker', 'id' => 'date', 'placeholder' => 'Введите дату']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('staff', 'Количество STAFF питания') !!}
                        {!! Form::number('staff', $event->staff, ['class' => 'form-control', 'id' => 'staff', 'placeholder' => 'Введите количество STAFF питания']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('tables', 'Количество столов') !!}
                        {!! Form::number('tables', $event->tables, ['class' => 'form-control', 'id' => 'tables', 'placeholder' => 'Введите количество столов']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('persons', 'Количество персон') !!}
                        {!! Form::number('persons', $event->persons, ['class' => 'form-control', 'id' => 'persons', 'placeholder' => 'Введите количество персон', 'onChange' => 'demo.persons = Number(this.value)']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('place_id', 'Место проведение') !!}
                {!! Form::select('place_id', $places, $event->place_id, ['class' => 'form-control', 'id' => 'place_id', 'placeholder' => 'Выберите место проведение']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('format_id', 'Формат') !!}
                {!! Form::select('format_id', $formats, $event->format_id, ['class' => 'form-control', 'id' => 'format_id', 'placeholder' => 'Выберите формат']) !!}
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('meeting', 'Время встречи гостей') !!}
                        {!! Form::text('meeting', $event->meeting, ['class' => 'form-control time', 'id' => 'meeting']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('main', 'Время основного проекта') !!}
                        {!! Form::text('main', $event->main, ['class' => 'form-control time', 'id' => 'main']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('hot_snacks', 'Время горячей закуски') !!}
                        {!! Form::text('hot_snacks', $event->hot_snacks, ['class' => 'form-control time', 'id' => 'hot_snacks']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('sorbet', 'Время сорбет') !!}
                        {!! Form::text('sorbet', $event->sorbet, ['class' => 'form-control time', 'id' => 'sorbet']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('hot', 'Время горячего') !!}
                        {!! Form::text('hot', $event->hot, ['class' => 'form-control time', 'id' => 'hot']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('dessert', 'Время десерта') !!}
                        {!! Form::text('dessert', $event->dessert, ['class' => 'form-control time', 'id' => 'dessert']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::submit('СохранитьUnit', ['style' => 'display: none;']) !!}

    <h3>Меню</h3>

    @section('categories')
        categories
        <div id="categories">
            <menu-categories :categories='{{ $categories->toJson() }}' :category='{{ $categories->first()->toJson() }}'></menu-categories>
        </div>
        <script type="text/x-template" id="menu-categories-template">
        <ul>
            <li v-for="category in categories">
                <a @click="setCategory(category)" style="color: #000000; font-weight: bold; background-color: #FFFFFF;" v-if="select_category == category">@{{ categoryList(category) + category.name }}</a>
                <a @click="setCategory(category)" style="color: #FFFFFF;" v-if="select_category != category">@{{ categoryList(category) + category.name }}</a>
            </li>
        </ul>
        </script>
    @endsection

    <script type="text/x-template" id="menu-template">

        <div>
            Категория - @{{ category ? category.name : '' }}
                <table v-if="true" class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="photo"></th>
                        <th class="name">Название</th>
                        <th class="amount">Количество порций</th>
                        <th class="weight">Выход, гр. за порцию</th>
                        <th class="weight_person">Выход, гр. за персону</th>
                        <th class="price">Цена за порцию RUB</th>
                        <th class="total">Общая стоимость</th>
                        <th class="show_photo">Вывести фото</th>
                        <th class="action"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(product, index) in filteredData(category)">
                        <td style="text-align: center;">
                            <a v-if="product.photo_url&&product.photo_url!=null" @click="openPhoto(product.photo_url)" href="javascript:void(0);"><img v-bind:src="product.photo_url" style="width: 100px;" /></a>
                        </td>
                        <td class="product">@{{ product.name }}</td>
                        <td class="amount">
                            <input type="number" v-model.number="product.id" class="form-control">
                        </td>
                        <td>@{{ product != "" ? product.weight : '' | weight }}</td>
                        <td>@{{ product != "" ? weightPerson(product.weight, 1) : '' | weight }}</td>
                        <td>@{{ product != "" ? product.price : '' | price}}</td>
                        <td>@{{ product != "" ? product.price*1 : '' | total | price}}</td>
                        <td><input type="checkbox" /></td>
                        <td><a href="javascript:void(0);" @click="deleteRow(section, index)" class="btn btn-danger">Удалить</a></td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2">Всего</td>
                        <td class="amount">@{{totalAmount(section) | total | amount}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>@{{totalPrice(section) | total | price}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>

                <a @click="addRow(section)" class="btn btn-sm btn-success">Добавить поле</a>
            <br />
            <a @click="addSection()" class="btn btn-sm btn-success">Добавить подраздел</a>
            <input type="hidden" name="sections" :value="sectionsJSON">

            <br /><br />
            <div class="form-group">
                <input type="hidden" name="weight_person" value="0">
                <label>
                    {{ Form::checkbox('weight_person', 1, $event->weight_person) }}
                    Указывать выход на персону
                </label>
            </div>
            <div class="form-group">
                {!! Form::label('tax_id', 'Цена') !!}
                {!! Form::select('tax_id', $taxes, $event->tax_id, ['class' => 'form-control', 'id' => 'tax_id']) !!}
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        {!! Form::label('service_absolution', 'Сервис (сумма)') !!}
                        {!! Form::hidden('service', $event->service, ['id' => 'service']) !!}
                        {!! Form::text('service_absolution', $event->getAbsolution('service'), ['class' => 'form-control', 'id' => 'service_absolution', 'placeholder' => 'Сервис (сумма)']) !!}
                    </div>
                    <div class="col-md-6 col-sm-6">
                        {!! Form::label('service_absolution', 'Сервис (проценты)') !!}
                        {!! Form::text('service_percents', $event->getPercents('service'), ['class' => 'form-control', 'id' => 'service_percents', 'placeholder' => 'Сервис (проценты)']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                {!! Form::label('administration_absolution', 'Администрирование (сумма)') !!}
                {!! Form::hidden('administration', $event->administration, ['id' => 'administration']) !!}
                {!! Form::text('administration_absolution', $event->getAbsolution('administration'), ['class' => 'form-control', 'id' => 'administration_absolution', 'placeholder' => 'Администрирование (сумма)']) !!}
                    </div>
                    <div class="col-md-6 col-sm-6">
                {!! Form::label('administration_absolution', 'Администрирование (проценты)') !!}
                {!! Form::text('administration_percents', $event->getPercents('administration'), ['class' => 'form-control', 'id' => 'administration_percents', 'placeholder' => 'Администрирование (проценты)']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        {!! Form::label('fare_absolution', 'Транспортные расходы (сумма)') !!}
                        {!! Form::hidden('fare', $event->fare, ['id' => 'fare']) !!}
                        {!! Form::text('fare_absolution', $event->getAbsolution('fare'), ['class' => 'form-control', 'id' => 'fare_absolution', 'placeholder' => 'Транспортные расходы (сумма)']) !!}
                    </div>
                    <div class="col-md-6 col-sm-6">
                        {!! Form::label('fare_absolution', 'Транспортные расходы (проценты)') !!}
                        {!! Form::text('fare_percents', $event->getPercents('fare'), ['class' => 'form-control', 'id' => 'fare_percents', 'placeholder' => 'Транспортные расходы (проценты)']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        {!! Form::label('equipment_absolution', 'Оборудование (сумма)') !!}
                        {!! Form::hidden('equipment', $event->equipment, ['id' => 'equipment']) !!}
                        {!! Form::text('equipment_absolution', $event->getAbsolution('equipment'), ['class' => 'form-control', 'id' => 'equipment_absolution', 'placeholder' => 'Оборудование (сумма)']) !!}
                    </div>
                    <div class="col-md-6 col-sm-6">
                        {!! Form::label('equipment_absolution', 'Оборудование (проценты)') !!}
                        {!! Form::text('equipment_percents', $event->getPercents('equipment'), ['class' => 'form-control', 'id' => 'equipment_percents', 'placeholder' => 'Оборудование (проценты)']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        {!! Form::label('mirror_collection_absolution', 'Пробочный сбор (сумма)') !!}
                        {!! Form::hidden('mirror_collection', $event->mirror_collection, ['id' => 'mirror_collection']) !!}
                        {!! Form::text('mirror_collection_absolution', $event->getAbsolution('mirror_collection'), ['class' => 'form-control', 'id' => 'mirror_collection_absolution', 'placeholder' => 'Пробочный сбор (сумма)']) !!}
                    </div>
                    <div class="col-md-6 col-sm-6">
                        {!! Form::label('mirror_collection_absolution', 'Пробочный сбор (проценты)') !!}
                        {!! Form::text('mirror_collection_percents', $event->getPercents('mirror_collection'), ['class' => 'form-control', 'id' => 'mirror_collection_percents', 'placeholder' => 'Пробочный сбор (проценты)']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        {!! Form::label('extras_absolution', 'Доп. наценка (сумма)') !!}
                        {!! Form::hidden('extras', $event->extras, ['id' => 'extras']) !!}
                        {!! Form::text('extras_absolution', $event->getAbsolution('extras'), ['class' => 'form-control', 'id' => 'extras_absolution', 'placeholder' => 'Доп. наценка (сумма)']) !!}
                    </div>
                    <div class="col-md-6 col-sm-6">
                        {!! Form::label('extras_absolution', 'Доп. наценка (проценты)') !!}
                        {!! Form::text('extras_percents', $event->getPercents('extras'), ['class' => 'form-control', 'id' => 'extras_percents', 'placeholder' => 'Доп. наценка (проценты)']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('discount', 'Скидка') !!}
                {!! Form::number('discount', $event->discount, ['class' => 'form-control', 'id' => 'discount', 'data-max' => $max_discount]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('product_view', 'Формат отображения блюд') !!}
                {!! Form::select('product_view', $product_views, $event->product_view, ['class' => 'form-control', 'id' => 'product_view', 'placeholder' => 'Выберите формат отображения блюд']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('language', 'Язык') !!}
                {!! Form::select('language', [
                    'ru' => 'Русский',
                    'en' => 'Английский'
                ], $event->language, ['class' => 'form-control', 'id' => 'language']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('template', 'Шаблон') !!}
                {!! Form::select('template', $templates, $event->template, ['class' => 'form-control', 'id' => 'template']) !!}
            </div>
        </div>
    </script>

    <div id="menu">
        <menu-grid
                :products='{{ $products->toJson() }}'
                :categories='{{ $categories->toJson() }}'
                :sections="sections"
                :init="{{ $event->sections }}"
                :persons="{{ $event->persons }}"
                :weight_person="{{ (int)$event->weight_person ? 'true' : 'false' }}"
                :tax="{{ (int)$event->tax_id }}"
                :template="'{{ (string)$event->template }}'"
        >
        </menu-grid>
    </div>
</div>

<div class="box-footer">
    {!! Form::submit('Сохранить', ['class' => 'btn btn-primary']) !!}
    @if($event->id > 0)
    <button class="btn btn-primary" name="word" type="submit"><i class="fa fa-file-word-o"> Word</i></button>
    <button class="btn btn-success" name="xls" type="submit"><i class="fa fa-file-excel-o"> XLS</i></button>
    <button class="btn btn-danger" name="pdf" type="submit"><i class="fa fa-file-pdf-o"> PDF</i></button>
    @else
        Возможность скачать КП станет доступной после сохранения мероприятия
    @endif
</div>
{!! Html::script('js/vue.min.js') !!}
{!! Html::script('js/menu.js') !!}