<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
h1 {
	padding-top: 30px;
	font-weight: normal;
    color: navy;
}
h4 {
	padding-top: 30px;
    color: navy;
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
}
p {
    color: navy;
}
@page {
    header: page-header;
	margin: 120px 0 120px 0;
    background-image: url('@image_base64(fortress_background.jpg)');
}
</style>
</head>
<body>
<htmlpageheader name="page-header">
</htmlpageheader>

<img src="@image_base64(fortress_first.jpg)" style="width: 100%; margin-top: -120px; margin-bottom: -120px;" />

<h1 align="center">Меню</h1>

@foreach($sections as $section)
<h4 align="center">{{ $section->category->name }}</h4>

    @foreach($section->rows as $row)
<div class="product">
    <p align="center">
        {{ $row->product->name }} {{ $row->product->name_en ? ' / ' . $row->product->name_en : '' }}
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