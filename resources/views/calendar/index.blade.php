@extends('layouts.app')

@section('contentheader_title', 'Календарь проектов')

@section('htmlheader_title')
    Календарь проектов
@endsection

@section('js')
    <link href="{{ asset('/css/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('/js/fullcalendar.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            navLinks: true, // can click day/week names to navigate views
            editable: false,
            eventLimit: false, // allow "more" link when too many events
            locale: 'ru',
            events: '/api/v1/calendar/events'
        });
    </script>
@endsection

@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="input-box">
                        <a href="{{ route('events.create') }}" class="btn btn-success">Добавить мероприятие</a>
                    </div>
                </div>
                <div class="box-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
@endsection