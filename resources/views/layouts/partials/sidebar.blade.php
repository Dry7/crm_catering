<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{asset('/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->username }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <ul class="sidebar-menu">
            <li class="header">Меню</li>
            @if(is_object(Auth::user()) and Auth::user()->isAdmin())
            <li{!! (is_object(\Request::route()) and (\Request::route()->getName() == 'staff.index')) ? ' class="active"' : '' !!}><a href="{{ route('staff.index') }}"><i class='fa fa-user'></i> <span>Сотрудники</span></a></li>
            <li{!! (is_object(\Request::route()) and (\Request::route()->getName() == 'products.index')) ? ' class="active"' : '' !!}><a href="{{ route('products.index') }}"><i class='fa fa-user'></i> <span>Меню</span></a></li>
            <li{!! (is_object(\Request::route()) and (\Request::route()->getName() == 'products.import')) ? ' class="active"' : '' !!}><a href="{{ route('products.import') }}"><i class='fa fa-user'></i> <span>Импорт</span></a></li>
            <li{!! (is_object(\Request::route()) and (\Request::route()->getName() == 'places.index')) ? ' class="active"' : '' !!}><a href="{{ route('places.index') }}"><i class='fa fa-user'></i> <span>Места</span></a></li>
            <li{!! (is_object(\Request::route()) and (\Request::route()->getName() == 'services.index')) ? ' class="active"' : '' !!}><a href="{{ route('services.index') }}"><i class='fa fa-user'></i> <span>Услуги</span></a></li>
            @endif
            <li{!! (is_object(\Request::route()) and (\Request::route()->getName() == 'clients.index')) ? ' class="active"' : '' !!}><a href="{{ route('clients.index') }}"><i class='fa fa-user'></i> <span>Клиенты</span></a></li>
            <li{!! (is_object(\Request::route()) and (\Request::route()->getName() == 'events.index')) ? ' class="active"' : '' !!}><a href="{{ route('events.index') }}"><i class='fa fa-user'></i> <span>Мероприятия</span></a></li>
        </ul>
    </section>
</aside>
