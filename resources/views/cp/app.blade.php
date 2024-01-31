<!DOCTYPE html>
<html lang="ru-ru">
<head>
    <meta charset="utf-8">
    <title>Панель управления | @yield('title')</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- #CSS Links -->
    <!-- Basic Styles -->

    {!! Html::style('/css/bootstrap.min.css') !!}

    {!! Html::style('/admin/css/font-awesome.min.css') !!}

    {!! Html::style('/admin/css/admin.css') !!}

    <!-- SmartAdmin Styles : Caution! DO NOT change the order -->

    {!! Html::style('/admin/css/smartadmin-production-plugins.min.css') !!}

    {!! Html::style('/admin/css/smartadmin-production.min.css') !!}

    {!! Html::style('/admin/css/smartadmin-skins.min.css') !!}

    <!-- SmartAdmin RTL Support -->

    {!! Html::style('/admin/css/smartadmin-rtl.min.css') !!}

    {!! Html::style('/admin/js/plugin/daterangepicker/daterangepicker.css') !!}

    <!-- We recommend you use "your_style.css" to override SmartAdmin
         specific styles this will also ensure you retrain your customization with each SmartAdmin update.
    <link rel="stylesheet" type="text/css" media="screen" href="css/your_style.css"> -->

    {!! Html::style('/admin/js/plugin/sweetalert/sweetalert.css') !!}

    {!! Html::style('/admin/js/plugin/jquery-treeview-master/jquery.treeview.css') !!}

    {!! Html::style('/admin/js/plugin/datetimepicker/jquery.datetimepicker.css') !!}

    {!! Html::style('/admin/js/plugin/jquery-treeview-master/jquery.treeview.css') !!}

    <!-- #GOOGLE FONT -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

    @yield('css')

    <script type="text/javascript">
        var SITE_URL = "{{ URL::to('/') }}";
    </script>

</head>

<!--
TABLE OF CONTENTS.
Use search to find needed section.
===================================================================
|  01. #CSS Links                |  all CSS links and file paths  |
|  02. #FAVICONS                 |  Favicon links and file paths  |
|  03. #GOOGLE FONT              |  Google font link              |
|  04. #APP SCREEN / ICONS       |  app icons, screen backdrops   |
|  05. #BODY                     |  body tag                      |
|  06. #HEADER                   |  header tag                    |
|  07. #PROJECTS                 |  project lists                 |
|  08. #TOGGLE LAYOUT BUTTONS    |  layout buttons and actions    |
|  09. #MOBILE                   |  mobile view dropdown          |
|  10. #SEARCH                   |  search field                  |
|  11. #NAVIGATION               |  left panel & navigation       |
|  12. #MAIN PANEL               |  main panel                    |
|  13. #MAIN CONTENT             |  content holder                |
|  14. #PAGE FOOTER              |  page footer                   |
|  15. #SHORTCUT AREA            |  dropdown shortcuts area       |
|  16. #PLUGINS                  |  all scripts and plugins       |
===================================================================
-->

<!-- #BODY -->
<!-- Possible Classes
    * 'smart-style-{SKIN#}'
    * 'smart-rtl'         - Switch theme mode to RTL
    * 'menu-on-top'       - Switch to top navigation (no DOM change required)
    * 'no-menu'			  - Hides the menu completely
    * 'hidden-menu'       - Hides the main menu but still accessable by hovering over left edge
    * 'fixed-header'      - Fixes the header
    * 'fixed-navigation'  - Fixes the main menu
    * 'fixed-ribbon'      - Fixes breadcrumb
    * 'fixed-page-footer' - Fixes footer
    * 'container'         - boxed layout mode (non-responsive: will not work with fixed-navigation & fixed-ribbon)
-->
<body class="smart-style-0 fixed-header">

<!-- #HEADER -->
<header id="header">
    <div id="logo-group">

        <!-- PLACE YOUR LOGO HERE -->
        <span id="logo"> <img src="" alt=""> </span>
        <!-- END LOGO PLACEHOLDER -->
    </div>

    <!-- #TOGGLE LAYOUT BUTTONS -->
    <!-- pulled right: nav area -->
    <div class="pull-right">

        <div id="fullscreen" class="btn-header transparent pull-right">
            <span> <a href="{{ URL::route('logout') }}" data-action="userLogout" title="Выйти"><i
                        class="fa fa-sign-out fa-lg"></i></a>
            </span>
        </div>
        <!-- end fullscreen button -->

        <!-- collapse menu button -->
        <div id="hide-menu" class="btn-header pull-right">
            <span> <a href="javascript:void(0);" data-action="toggleMenu" title="Свернуть меню"><i
                        class="fa fa-reorder"></i></a> </span>
        </div>
        <!-- end collapse menu -->

        <!-- fullscreen button -->
        <div id="fullscreen" class="btn-header transparent pull-right">
            <span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Развернуть на весь экран"><i
                        class="fa fa-arrows-alt"></i></a>
            </span>
        </div>
        <!-- end fullscreen button -->

    </div>
    <!-- end pulled right: nav area -->

</header>
<!-- END HEADER -->

<!-- #NAVIGATION -->
<!-- Left panel : Navigation area -->
<!-- Note: This width of the aside area can be adjusted through LESS/SASS variables -->
<aside id="left-panel">

    <!-- User info -->
    <div class="login-info">
        <span> <!-- User image size is adjusted inside CSS, it should stay as is -->

            <a id="show-shortcut" data-action="toggleShortcut">
                <span>

                </span>
            </a>
        </span>
    </div>
    <!-- end user info -->

    <!-- NAVIGATION : This navigation is also responsive
    To make this navigation dynamic please make sure to link the node
    (the reference to the nav > ul) after page load. Or the navigation
    will not initialize.
    -->
    <nav>
        <!--
        NOTE: Notice the gaps after each icon usage <i></i>..
        Please note that these links work a bit different than
        traditional href="" links. See documentation for details.
        -->

        <ul>
            @if(PermissionsHelper::has_permission(Auth::user()->role,'admin|moderator'))

                <li {!! Request::is('cp*') ? ' class="active"' : '' !!}>
                    <a href="{{ URL::route('cp.dashbaord.index') }}"><i class="fa fa-fw fa-home"></i> <span
                            class="menu-item-parent"> Главная</span></a>
                </li>

            @endif

            <li class="">
                <a href="#">
                    <i class="fa fa-fw fa-folder"></i> <span class="menu-item-parent">Управление контентом</span>
                </a>

                <ul class="treeview-menu">

                    <li {!! Request::is('cp/manage-menus*') ? ' class="active"' : '' !!}>
                        <a href="{{ URL::route('cp.menu.index') }}">
                            <i class="fa fa-fw fa-list"></i> <span class="menu-item-parent"> Меню</span>
                        </a>
                    </li>

                    <li {!! Request::is('cp/pages*') ? ' class="active"' : '' !!}><a
                            href="{{ URL::route('cp.pages.index') }}"><i class="fa fa-list"></i> Страницы и
                            разделы</a>
                    </li>

                </ul>
            </li>

            <li class="">
                <a href="#">
                    <i class="fa fa-fw fa-th-list"></i> <span class="menu-item-parent">Продукция</span>
                </a>

                <ul class="treeview-menu">

                    <li {!! Request::is('cp/catalog*') ? ' class="active"' : '' !!}>
                        <a href="{{ URL::route('cp.catalog.index') }}">
                            <i class="fa fa-fw fa-list"></i> <span class="menu-item-parent"> Каталог</span>
                        </a>
                    </li>

                    @if(PermissionsHelper::has_permission(Auth::user()->role,'admin|moderator'))
                        <li {!! Request::is('cp/product-parameters-category*') ? ' class="active"' : '' !!}>
                            <a href="{{ URL::route('cp.product_parameters_category.index') }}">
                                <i class="fa fa-fw fa-list"></i> <span
                                    class="menu-item-parent"> Категория характеристик</span>
                            </a>
                        </li>
                    @endif

                    <li {!! Request::is('cp/products*') ? ' class="active"' : '' !!}>
                        <a href="{{ URL::route('cp.products.index') }}">
                            <i class="fa fa-fw fa-list"></i> <span class="menu-item-parent"> Продукция</span>
                        </a>
                    </li>

                </ul>
            </li>

            <li class="">
                <a href="#">
                    <i class="fa fa-fw fa-th-list"></i> <span class="menu-item-parent">Услуги</span>
                </a>

                <ul class="treeview-menu">

                    <li {!! Request::is('cp/catalog-services*') ? ' class="active"' : '' !!}>
                        <a href="{{ URL::route('cp.services_catalog.index') }}">
                            <i class="fa fa-fw fa-list"></i> <span class="menu-item-parent"> Категории</span>
                        </a>
                    </li>

                    <li {!! Request::is('cp/services*') ? ' class="active"' : '' !!}>
                        <a href="{{ URL::route('cp.services.index') }}">
                            <i class="fa fa-fw fa-list"></i> <span class="menu-item-parent"> Услуги</span>
                        </a>
                    </li>

                </ul>
            </li>


            @if(PermissionsHelper::has_permission(Auth::user()->role,'admin|moderator'))
                <li class="">
                    <a href="#">
                        <i class="fa fa-fw fa-folder"></i> <span class="menu-item-parent">SEO</span>
                    </a>

                    <ul class="treeview-menu">

                        <li {!! Request::is('cp/robots/edit*') ? ' class="active"' : '' !!}>
                            <a href="{{ URL::route('cp.robots.edit') }}">
                                <i class="fa fa-fw fa-list"></i> <span class="menu-item-parent"> Robots.txt</span>
                            </a>
                        </li>

                        <li {!! Request::is('cp/sitemap*') ? ' class="active"' : '' !!}>
                            <a href="{{ URL::route('cp.sitemap.index') }}">
                                <i class="fa fa-fw fa-list"></i> <span class="menu-item-parent"> Sitemap.xml</span>
                            </a>
                        </li>

                        <li {!! Request::is('cp/seo*') ? ' class="active"' : '' !!}>
                            <a href="{{ URL::route('cp.seo.index') }}">
                                <i class="fa fa-fw fa-list"></i> <span class="menu-item-parent"> SEO</span>
                            </a>
                        </li>

                    </ul>
                </li>
            @endif

            @if(PermissionsHelper::has_permission(Auth::user()->role,'admin'))

                <li {!! Request::is('cp/users*') ? ' class="active"' : '' !!}>
                    <a href="{{URL::route('cp.users.index')}}"><i class="fa fa-fw fa-users"></i> <span
                            class="menu-item-parent"> Пользователи</span></a>
                </li>

            @endif

            <li {!! Request::is('cp/feedback*') ? ' class="active"' : '' !!}>
                <a href="{{URL::route('cp.feedback.index')}}"><i class="fa fa-fw fa-envelope"></i> <span
                        class="menu-item-parent"> Сообщения с сайта</span></a>
            </li>

            @if(PermissionsHelper::has_permission(Auth::user()->role,'admin'))

                <li {!! Request::is('cp/settings*') ? ' class="active"' : '' !!}>
                    <a href="{{URL::route('cp.settings.index')}}"><i class="fa fa-fw fa-cog txt-color-blue"></i> <span
                            class="menu-item-parent"> Настройки</span></a>
                </li>

            @endif

        </ul>

    </nav>

    <span class="minifyme" data-action="minifyMenu"> <i class="fa fa-arrow-circle-left hit"></i></span>

</aside>
<!-- END NAVIGATION -->

<!-- #MAIN PANEL -->
<div id="main" role="main">

    <!-- RIBBON -->
    <div id="ribbon">

        <!-- breadcrumb -->
        <ol class="breadcrumb">
            <li>Панель управления</li>
            <li>@yield('title')</li>
        </ol>
        <!-- end breadcrumb -->

        <!-- You can also add more buttons to the
        ribbon for further usability
        Example below:
        <span class="ribbon-button-alignment pull-right" style="margin-right:25px">
            <a href="#" id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa fa-grid"></i> Change Grid</a>
            <span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa fa-plus"></i> Add</span>
            <button id="search" class="btn btn-ribbon" data-title="search"><i class="fa fa-search"></i> <span class="hidden-mobile">Search</span></button>
        </span> -->

    </div>
    <!-- END RIBBON -->

    <!-- #MAIN CONTENT -->

    <div id="content">

        @if (isset($title))
            <h2>{!! $title !!}</h2>
        @endif

        @include('cp.notifications')

        <!-- col -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                @yield('content')
            </div>
        </div>
        <!-- end col -->

        <!-- end row -->
    </div>
    <!-- END #MAIN CONTENT -->

</div>
<!-- END #MAIN PANEL -->

<!-- #PAGE FOOTER -->
<div class="page-footer">
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <span class="txt-color-white"><span class="hidden-xs"></span> © {{ date('Y') }} RAPS</span>
        </div>
    </div>
    <!-- end row -->
</div>
<!-- END FOOTER -->

<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    if (!window.jQuery) {
        document.write('<script src="{{ url('/js/libs/jquery-3.2.1.min.js') }}"><\/script>');
    }
</script>

<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
    if (!window.jQuery.ui) {
        document.write('<script src="{{ url('/js/libs/jquery-ui.min.js') }}"><\/script>');
    }
</script>

<!-- IMPORTANT: APP CONFIG -->

{!! Html::script('/admin/js/app.config.js') !!}

<!-- BOOTSTRAP JS -->

{!! Html::script('/admin/js/bootstrap/bootstrap.min.js') !!}

<!--[if IE 8]>
<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
<![endif]-->

<!-- MAIN APP JS FILE -->

{!! Html::script('/admin/js/app.min.js') !!}

{!! Html::script('/admin/js/plugin/datatables/jquery.dataTables.min.js') !!}

{!! Html::script('/admin/js/plugin/datatables/dataTables.colVis.min.js') !!}

{!! Html::script('/admin/js/plugin/datatables/dataTables.tableTools.min.js') !!}

{!! Html::script('/admin/js/plugin/datatables/dataTables.bootstrap.min.js') !!}

{!! Html::script('/admin/js/plugin/datatable-responsive/datatables.responsive.min.js') !!}

{!! Html::script('/admin/js/plugin/sweetalert/sweetalert-dev.js') !!}

{!! Html::script('/admin/js/plugin/datetimepicker/jquery.datetimepicker.full.js') !!}

{!! Html::script('/admin/js/plugin/jquery-treeview-master/jquery.treeview.js') !!}

{!! Html::script('/admin/js/plugin/cookie/jquery.cookie.js') !!}

{!! Html::script('/admin/js/plugin/select2/select2.min.js') !!}


@yield('js')

</body>

</html>
