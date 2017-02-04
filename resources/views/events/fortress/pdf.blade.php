<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
h1 {
	padding-top: 30px;
	font-weight: normal;
    color: navy;
    padding-bottom: -80px;
}
h4 {
	padding-top: 30px;
    color: navy;
}
.tax {
	padding-top: 30px;
}
.product {
}
.product p {
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

<img src="@image_base64(fortress_first.jpg)" style="width: 100%; margin: -120px 0 -120px 0;" />

<div style="width: 100%; padding-left: 50px; padding-right: 50px;">
<h1 align="center">{{ trans('menu.menu') }}</h1>

@foreach($sections as $section)
<h4 align="center">{{ $section->category->name }}</h4>

    @foreach($section->rows as $row)
        @if(!empty($row->product))
<div class="product">
    <p align="center" style="padding-bottom: 0; margin-bottom: 0;">{{ $event->language == 'en' ? $row->product->name_en : $row->product->name }}
        @if($event->product_view == 'price')
        {{ $row->amount }} / {{ $row->total_weight }} {{ trans('menu.gr') }} / {{ $row->total }} ₱
        @elseif($event->product_view == 'delete_price_and_weight')

        @else
        {{ $row->amount }} / {{ $row->total_weight }} {{ trans('menu.gr') }}
        @endif
    </p>
</div>
        @endif
    @endforeach

@endforeach

<p align="center" class="total">{{ trans('menu.total') }}</p>
<p align="center">
    {{ trans('menu.total_price') }} – {{ $event->getTotal() }} ₱
    @if($event->discount > 0)
        <br />{{ trans('menu.discount') }} - {{ $event->discount }}%
        <br />{{ trans('menu.price_by_person') }} - @discount($event->getTotal(), $event->discount) ₱
    @endif

    @if($event->weight_person)
        <br />{{ trans('menu.price_by_person') }} – {{ $event->getTotal(true) }} ₱
        @if($event->discount > 0)
            <br />{{ trans('menu.price_discount') }} - @discount($event->getTotal(true), $event->discount) ₱
        @endif
    @endif
</p>

<p align="center" class="tax">{{ $event->tax }}</p>

@if($event->is_service)
    <p align="center" class="service">{{ trans('menu.service') }}</p>
@endif

@if($event->is_administration)
    <p align="center" class="administration">{{ trans('menu.administration') }}</p>
@endif

@if($event->is_fare)
    <p align="center" class="fare">{{ trans('menu.fare') }}</p>
@endif

@if($event->is_equipment)
    <p align="center" class="equipment">{{ trans('menu.equipment') }}</p>
@endif

@if($event->is_mirror_collection)
    <p align="center" class="mirror_collection">{{ trans('menu.mirror_collection') }}</p>
@endif
<pagebreak>
<div class="images">
    @foreach($images as $image)
        @image($image->id)
    @endforeach
</div>

<p align="center" class="copyright">{!! $copyright !!}</p>
</div>
</body>
</html>