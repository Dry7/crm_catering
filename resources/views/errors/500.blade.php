@extends('layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.servererror') }}
@endsection

@section('contentheader_title')
    {{ trans('adminlte_lang::message.500error') }}
@endsection

@section('$contentheader_description')
@endsection

@section('main-content')
    @unless(empty($sentryID))
        <!-- Sentry JS SDK 2.1.+ required -->
        <script src="https://cdn.ravenjs.com/3.3.0/raven.min.js"></script>

        <script>
            Raven.showReportDialog({
                eventId: '{{ $sentryID }}',

                // use the public DSN (dont include your secret!)
                dsn: 'https://2b57059cb73f46af8268f515a0f761a5@sentry.io/111449'
            });
        </script>
    @endunless
    <div class="error-page">
        <h2 class="headline text-red">500</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> Oops! {{ trans('adminlte_lang::message.somethingwrong') }}</h3>
            <p>
                {{ trans('adminlte_lang::message.wewillwork') }}
                {{ trans('adminlte_lang::message.mainwhile') }} <a href='{{ url('/home') }}'>{{ trans('adminlte_lang::message.returndashboard') }}</a> {{ trans('adminlte_lang::message.usingsearch') }}
            </p>
            <form class='search-form'>
                <div class='input-group'>
                    <input type="text" name="search" class='form-control' placeholder="{{ trans('adminlte_lang::message.search') }}"/>
                    <div class="input-group-btn">
                        <button type="submit" name="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                    </div>
                </div><!-- /.input-group -->
            </form>
        </div>
    </div><!-- /.error-page -->
@endsection