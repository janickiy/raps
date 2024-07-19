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

                        {!! Form::open(['url' => route('cp.seo.update'), 'method' => 'put', 'id' => 'smart-form']) !!}

                        {!! isset($row) ? Form::hidden('id', $row->id) : '' !!}

                        <div class="smart-form">

                            <fieldset>

                                <section>

                                    {!! Form::label('type', 'Страница', ['class' => 'label']) !!}

                                    <label class="input">

                                        {!! Form::text('type', old('type', isset($row) ? $row->type : null), ['class' => 'form-control', 'readonly']) !!}

                                    </label>

                                    @if ($errors->has('type'))
                                        <p class="text-danger">{{ $errors->first('type') }}</p>
                                    @endif

                                </section>

                                <section>

                                    {!! Form::label('h1', 'h1', ['class' => 'label']) !!}

                                    <label class="input">

                                        {!! Form::text('h1', old('h1', isset($row) ? $row->h1 : null), ['class' => 'form-control']) !!}

                                    </label>

                                    @if ($errors->has('h1'))
                                        <p class="text-danger">{{ $errors->first('h1') }}</p>
                                    @endif

                                </section>

                                <section>

                                    {!! Form::label('title', 'title', ['class' => 'label']) !!}

                                    <label class="input">

                                        {!! Form::text('title', old('title', isset($row) ? $row->title : null), ['class' => 'form-control']) !!}

                                    </label>

                                    @if ($errors->has('title'))
                                        <p class="text-danger">{{ $errors->first('title') }}</p>
                                    @endif

                                </section>

                                <section>

                                    {!! Form::label('keyword', 'Keyword', ['class' => 'label']) !!}

                                    <label class="textarea textarea-resizable">

                                        {!! Form::textarea('keyword', old('keyword', isset($row) ? $row->keyword : null), ['rows' => "3", 'class' => 'custom-scroll']) !!}

                                    </label>

                                    @if ($errors->has('keyword'))
                                        <p class="text-danger">{{ $errors->first('keyword') }}</p>
                                    @endif

                                </section>

                                <section>

                                    {!! Form::label('description', 'Description', ['class' => 'label']) !!}

                                    <label class="textarea textarea-resizable">

                                        {!! Form::textarea('description', old('description', isset($row) ? $row->description : null), ['rows' => "3", 'class' => 'custom-scroll']) !!}

                                    </label>

                                    @if ($errors->has('description'))
                                        <p class="text-danger">{{ $errors->first('description') }}</p>
                                    @endif

                                </section>

                                <section>

                                    {!! Form::label('url_canonical', 'Url canonical ', ['class' => 'label']) !!}

                                    <label class="input">

                                        {!! Form::text('url_canonical', old('url_canonical', isset($row) ? $row->url_canonical : null), ['class' => 'form-control']) !!}

                                    </label>

                                    @if ($errors->has('url_canonical'))
                                        <p class="text-danger">{{ $errors->first('url_canonical') }}</p>
                                    @endif

                                </section>


                            </fieldset>

                            <footer>
                                <button type="submit" class="btn btn-primary button-apply">
                                    {{ isset($row) ? 'Изменить' : 'Добавить' }}
                                </button>
                                <a class="btn btn-default" href="{{ route('cp.seo.index') }}">
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
