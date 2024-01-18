@extends('cp.app')

@section('title', $title)

@section('css')


@endsection

@section('content')

    <!-- START ROW -->
    <div class="row">

        <!-- NEW COL START -->
        <article class="col-sm-12 col-md-12 col-lg-12">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false"
                 data-widget-custombutton="false">
                <!-- widget options:
                usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
                data-widget-colorbutton="false"
                data-widget-editbutton="false"
                data-widget-togglebutton="false"
                data-widget-deletebutton="false"
                data-widget-fullscreenbutton="false"
                data-widget-custombutton="false"
                data-widget-collapsed="true"
                data-widget-sortable="false"
                -->

                <!-- widget div-->
                <div>

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->

                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body no-padding">

                        {!! Form::open(['url' => URL::route('cp.sitemap.import'), 'files' => true, 'method' => 'post', 'id' => 'smart-form']) !!}

                        <div class="smart-form">

                            <header>
                                *-Обязательные поля
                            </header>

                            <fieldset>

                                <section>
                                    <label class="label">Файл sitemap.xml*</label>
                                    <div class="input input-file">
                                        <span class="button"><input type="file" id="file" name="file" onchange="this.parentNode.nextSibling.value = this.value">Выбрать</span>
                                        <input type="text" placeholder="Include some files" readonly="">
                                    </div>

                                    @if ($errors->has('file'))
                                        <p class="text-danger">{{ $errors->first('file') }}</p>
                                    @endif
                                </section>

                            </fieldset>

                            <footer>
                                <button type="submit" class="btn btn-primary button-apply">
                                    Загрузить
                                </button>
                                <a class="btn btn-default" href="{{ URL::route('cp.sitemap.index') }}">
                                    Назад
                                </a>
                            </footer>

                        </div>

                        {!! Form::close() !!}

                    </div>
                    <!-- end widget content -->

                </div>
                <!-- end widget div -->

            </div>
            <!-- end widget -->

        </article>
        <!-- END COL -->

    </div>

    <!-- END ROW -->

@endsection

@section('js')

@endsection
