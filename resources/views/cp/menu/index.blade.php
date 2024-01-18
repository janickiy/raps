@extends('cp.app')

@section('title', $title)

@section('css')


@endsection

@section('content')

    @include('layouts.notifications')

    <div class="row-fluid">

        <div class="col">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="false">

                <!-- widget div-->
                <div>

                    {!! Menu::render() !!}

                </div>
                <!-- end widget content -->

            </div>
            <!-- end widget div -->

        </div>
        <!-- end widget -->

    </div>


@endsection

@section('js')

    {!! Menu::scripts() !!}

@endsection
