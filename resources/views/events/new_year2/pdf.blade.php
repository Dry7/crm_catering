<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
.event {
	width: 100%;
}
.event td {
	padding-left: 10px;
}
.event td.name {
	background: #243D66;
	color: #FFFFFF;
	text-align: left;
	width: 250px;
}
.event td.value {
	text-align: left;
}
h1 {
	padding-top: 30px;
	font-weight: normal;
}
h4 {
	color: #2e74b5;
	padding-top: 30px;
}
.tax {
	padding-top: 30px;
}
.product {
	padding-bottom: 20px;
}
.total {
	padding-bottom: 30px;
}
.header {
	padding-top: 20px;
	width: 100%;
}
.header .logo {
	width: 100px;
}
.catering {
	text-align: center;
	font-size: 30.0pt;
	font-family: "Arial",sans-serif;
	font-weight: normal;
    color: #243D66;
}
@page {
    header: page-header;
	margin-top: 120px;
    background: url('data:image/jpeg;base64,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') no-repeat;
}
</style>
</head>
<body>
<htmlpageheader name="page-header">
</htmlpageheader>
<table border="1" cellspacing="0" cellpadding="0" class="event">
    <tbody>
        <tr>
            <td class="name"><p>Тип мероприятия</p></td>
            <td class="value"><p>{{ $event->format }}</p></td>
        </tr>
        <tr>
            <td class="name"><p>Количество персон</p></td>
            <td class="value"><p>{{ $event->persons }}</p></td>
        </tr>
        <tr>
            <td class="name"><p>Количество столов</p></td>
            <td class="value"><p>{{ $event->tables }}</p></td>
        </tr>
        <tr>
            <td class="name"><p>Место проведения</p></td>
            <td class="value"><p>{{ $event->place->name }}</p></td>
        </tr>
        <tr>
            <td class="name"><p>Количество STAF питания</p></td>
            <td class="value"><p>{{ $event->staff }}</p></td>
        </tr>
@if($event->meeting)
        <tr>
            <td class="name"><p>Время встречи гостей</p></td>
            <td class="value"><p>{{ $event->meeting }}</p></td>
        </tr>
@endif
@if($event->main)
        <tr>
            <td class="name"><p>Время основного проекта</p></td>
            <td class="value"><p>{{ $event->main }}</p></td>
        </tr>
@endif
@if($event->hot_snacks)
        <tr>
            <td class="name"><p>Время горячей закуски</p></td>
            <td class="value"><p>{{ $event->hot_snacks }}</p></td>
        </tr>
@endif
@if($event->sorbet)
        <tr>
            <td class="name"><p>Время сорбет</p></td>
            <td class="value"><p>{{ $event->sorbet }}</p></td>
        </tr>
@endif
@if($event->hot)
        <tr>
            <td class="name"><p>Время горячего</p></td>
            <td class="value"><p>{{ $event->hot }}</p></td>
        </tr>
@endif
@if($event->dessert)
        <tr>
            <td class="name"><p>Время десерта</p></td>
            <td class="value"><p>{{ $event->dessert }}</p></td>
        </tr>
@endif
    </tbody>
</table>
<h1 align="center">Меню</h1>

@foreach($sections as $section)
<h4 align="center">{{ $section->category->name }}</h4>

    @foreach($section->rows as $row)
<div class="product">
    <p align="center">
        {{ $row->product->name }}
        @image($row->product->id)
    </p>
    <p align="center">
@if($event->weight_person)
        Стоимость с персоны – @price_person($row, $event->persons) рублей @weight_person($row, $event->persons) гр
@else
        Стоимость – {{ $row->total }} рублей {{ $row->total_weight }} гр
@endif
    </p>
</div>
    @endforeach

@endforeach

<p align="center" class="total">Итого:</p>
<p align="center">
  @if($event->weight_person)
  Стоимость с персоны – {{ $total }} руб
      @if($event->discount > 0)
          <br />Скидка - {{ $event->discount }}%
          <br />Стоимость со скидкой - @discount($total, $event->discount) руб
      @endif
  @else
  Стоимость – {{ $total }} руб
        @if($event->discount > 0)
            <br />Скидка - {{ $event->discount }}%
            <br />Стоимость со скидкой - @discount($total, $event->discount) руб
        @endif
  @endif
</p>

<p align="center" class="tax">{{ $event->tax }}</p>

@if($event->is_administration)
    <p align="center" class="administration">Административные расходы включены в стоимость</p>
@endif

@if($event->is_fare)
    <p align="center" class="fare">Транспортные расходы включены в стоимость</p>
@endif

<p align="center" class="copyright">{!! $copyright !!}</p>

</body>
</html>