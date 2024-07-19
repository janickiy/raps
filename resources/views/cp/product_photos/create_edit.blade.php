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

                        {!! Form::open(['url' => route('cp.product_photos.update'), 'method' => 'put', 'files' => true, 'class' => "smart-form"]) !!}

                        {!! Form::hidden('id', $row->id) !!}

                        <fieldset>

                            <section>

                                {!! Form::label('title', 'Title', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('title', old('title', $row->title ?? ''), ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                                </label>

                                @if ($errors->has('title'))
                                    <p class="text-danger">{{ $errors->first('title') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('alt', 'Alt', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('alt', old('alt', $row->alt ?? ''), ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                                </label>

                                @if ($errors->has('alt'))
                                    <p class="text-danger">{{ $errors->first('alt') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('image', 'Фото (jpg,gif,png)', ['class' => 'label']) !!}

                                <div class="input input-file">
                                        <span class="button">

                                        {!! Form::file('image',  ['id' => 'image', 'onchange' => "this.parentNode.nextSibling.value = this.value"]) !!} Обзор...

                                        </span><input type="text" placeholder="выберите файл" readonly="">

                                    <br>
                                    @if (isset($row) && !empty($row->thumbnail))
                                        <img src='{{ url($row->getThumbnailUrl()) }}' width="150"
                                        >
                                    @endif

                                </div>

                                @if ($errors->has('image'))
                                    <span class="text-danger">{{ $errors->first('image') }}</span>
                                @endif

                                <div class="note">
                                    Максимальный размер: <strong>{{ $maxUploadFileSize }}</strong>
                                </div>

                            </section>

                        </fieldset>

                        <footer>
                            <button type="submit" class="btn btn-primary button-apply">
                                {{ isset($row) ? 'Изменить' : 'Добавить' }}
                            </button>
                            <a class="btn btn-default" href="{{ route('cp.product_photos.index', ['product_id' => $row->product_id]) }}">
                                Назад
                            </a>
                        </footer>

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
