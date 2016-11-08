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
                {!! Form::label('client_id', 'Компания *') !!}
                {!! Form::select('client_id', $clients, $event->client_id, ['class' => 'form-control select2', 'id' => 'client_id', 'placeholder' => 'Выберите компанию']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('date', 'Дата *') !!}
                {!! Form::text('date', $event->date !== null ? $event->date->format('d.m.Y') : '', ['class' => 'form-control datepicker', 'id' => 'date', 'placeholder' => 'Введите дату']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('format_id', 'Формат *') !!}
                {!! Form::select('format_id', $formats, $event->format_id, ['class' => 'form-control', 'id' => 'format_id', 'placeholder' => 'Выберите формат']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('persons', 'Количество персон') !!}
                {!! Form::number('persons', $event->persons, ['class' => 'form-control', 'id' => 'persons', 'placeholder' => 'Введите количество персон', 'onChange' => 'demo.persons = Number(this.value)']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('tables', 'Количество столов') !!}
                {!! Form::number('tables', $event->tables, ['class' => 'form-control', 'id' => 'tables', 'placeholder' => 'Введите количество столов']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('staff', 'Количество STAFF питания') !!}
                {!! Form::number('staff', $event->staff, ['class' => 'form-control', 'id' => 'staff', 'placeholder' => 'Введите количество STAFF питания']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('place_id', 'Место проведение') !!}
                {!! Form::select('place_id', $places, $event->place_id, ['class' => 'form-control', 'id' => 'place_id', 'placeholder' => 'Выберите место проведение']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('meeting', 'Время встречи гостей') !!}
                {!! Form::text('meeting', $event->meeting, ['class' => 'form-control time', 'id' => 'meeting']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('main', 'Время основного проекта') !!}
                {!! Form::text('main', $event->main, ['class' => 'form-control time', 'id' => 'main']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('hot_snacks', 'Время горячей закуски') !!}
                {!! Form::text('hot_snacks', $event->hot_snacks, ['class' => 'form-control time', 'id' => 'hot_snacks']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('sorbet', 'Время сорбет') !!}
                {!! Form::text('sorbet', $event->sorbet, ['class' => 'form-control time', 'id' => 'sorbet']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('hot', 'Время горячего') !!}
                {!! Form::text('hot', $event->hot, ['class' => 'form-control time', 'id' => 'hot']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('dessert', 'Время десерта') !!}
                {!! Form::text('dessert', $event->dessert, ['class' => 'form-control time', 'id' => 'dessert']) !!}
            </div>
        </div>
    </div>
    {!! Form::submit('СохранитьUnit', ['style' => 'display: none;']) !!}

    <script type="text/x-template" id="menu-template">

        <div>
            <div v-for="section in sections" class="section">
                <select v-model="section.category" class="form-control">
                    <option value="">Выберите категорию</option>
                    <option v-for="category in categories" v-bind:value="category">@{{ category.name }}</option>
                </select>
                <table v-if="true" class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="name">Название</th>
                        <th class="amount">Количество порций</th>
                        <th class="weight">Выход, гр. за порцию</th>
                        <th class="weight_person">Выход, гр. за персону</th>
                        <th class="price">Цена за порцию RUB</th>
                        <th class="total">Общая стоимость</th>
                        <th class="action"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(row, index) in section.rows">
                        <td class="product">
                            <select class="form-control" @change="changeProduct(row, $event)">
                                <option value="">Выберите блюдо</option>
                                <option v-for="product in filteredData(section.category)" v-bind:value="product" :key="product.id" :selected="row.product.id == product.id">@{{ product.name }}</option>
                            </select>
                        </td>
                        <td class="amount">
                            <input type="number" v-model.number="row.amount" class="form-control">
                        </td>
                        <td>@{{ row.product != "" ? row.product.weight : '' | weight }}</td>
                        <td>@{{ row.product != "" ? weightPerson(row.product.weight, row.amount) : '' | weight }}</td>
                        <td>@{{ row.product != "" ? row.product.price : '' | price}}</td>
                        <td>@{{ row.product != "" ? row.product.price*row.amount : '' | total | price}}</td>
                        <td><a href="javascript:void(0);" @click="deleteRow(section, index)" class="btn btn-danger">Удалить</a></td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td>Всего</td>
                        <td class="amount">@{{totalAmount(section) | total | amount}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>@{{totalPrice(section) | total | price}}</td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>

                <a @click="addRow(section)" class="btn btn-sm btn-success">Добавить поле</a>
            </div>
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
                {!! Form::label('discount', 'Скидка') !!}
                {!! Form::number('discount', $event->discount, ['class' => 'form-control', 'id' => 'discount', 'data-max' => $max_discount]) !!}
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
    <button class="btn btn-primary" name="word" type="submit"><i class="fa fa-file-word-o"> Word</i></button>
    <button class="btn btn-success" name="xls" type="submit"><i class="fa fa-file-excel-o"> XLS</i></button>
    <button class="btn btn-danger" name="pdf" type="submit"><i class="fa fa-file-pdf-o"> PDF</i></button>
</div>
{!! Html::script('https://vuejs.org/js/vue.js') !!}
{!! Html::script('js/menu.js') !!}