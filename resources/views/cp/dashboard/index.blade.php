@extends('cp.app')

@section('title', $title)

@section('css')

@endsection

@section('content')

    <div class="row-fluid">

        <div class="col">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="false">

                <!-- widget div-->
                <div>
                    <div class="row">
                        <div class="text">
                            <div class="col-sm-12 col-md-6 col-lg-3">
                                <div class="well text-center connect">
                                    <i class="fa fa-folder-o fa-3x"></i>
                                    <h5><small>{{ $pages }}</small></h5>
                                    <span class="font-md"><b><a href="{{URL::route('cp.pages.index')}}">Страницы и разделы</a></b></span>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-3">
                                <div class="well text-center connect">
                                    <i class="fa fa-folder-o fa-3x"></i>
                                    <h5><small>{{ $services }}</small></h5>
                                    <span class="font-md"><b><a href="{{URL::route('cp.services.index')}}">Услуги</a></b></span>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-3">
                                <div class="well text-center connect">
                                    <i class="fa fa-folder-o fa-3x"></i>
                                    <h5><small>{{ $products }}</small></h5>
                                    <span class="font-md"><b><a href="{{URL::route('cp.products.index')}}">Продукция</a></b></span>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-3">
                                <div class="well text-center connect">
                                    <i class="fa fa-users fa-3x"></i>
                                    <h5><small>{{ $users }}</small></h5>
                                    <span class="font-md"><b><a href="{{URL::route('cp.users.index')}}">Пользователи</a></b></span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- end widget content -->

            </div>
            <!-- end widget div -->

        </div>
        <!-- end widget -->

    </div>

@endsection

@section('js')


@endsection

