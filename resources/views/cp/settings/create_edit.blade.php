@extends('cp.app')

@section('title', $title)

@section('css')


@endsection

@section('content')

    <!-- row -->
    <div class="row">

        <!-- NEW WIDGET START -->
        <article class="col-sm-12 col-md-12 col-lg-12">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false">
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
                    <div class="widget-body">

                        {!! Form::open(['url' => isset($row) ? route('cp.settings.update') : route('cp.settings.store'), 'files' => true, 'method' => isset($row) ? 'put' : 'post', 'class' => "smart-form"]) !!}

                        {!! isset($row) ? Form::hidden('id', $row->id) : '' !!}

                        <header>
                            *-обязательные поля
                        </header>

                        <fieldset>

                            <section>

                                {!! Form::label('key_cd', 'Ключ*', ['class' => 'label']) !!}

                                <label class="input">
                                    @if(isset($row))

                                        {!! Form::text('key_cd', old('key_cd', $row->key_cd ?? null), ['class' => 'form-control', 'readonly']) !!}

                                    @else

                                        {!! Form::text('key_cd', old('key_cd', $row->key_cd ?? null), ['class' => 'form-control']) !!}

                                    @endif

                                </label>

                                @if ($errors->has('key_cd'))
                                    <p class="text-danger">{{ $errors->first('key_cd') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('type', 'Тип*', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('type', old('type', isset($row) ? $row->type : $type), ['class' => 'form-control', 'readonly']) !!}

                                </label>

                                @if ($errors->has('type'))
                                    <p class="text-danger">{{ $errors->first('type') }}</p>
                                @endif

                            </section>

                            <section>

                                @if(isset($row) && $row->type == 'FILE' || $type == 'FILE')

                                    {!! Form::label('value', 'Файл* (jpg,png,txt,doc,docx,pdf,xls,xlsx,odt,ods,pdf)', ['class' => 'label']) !!}

                                    <div class="input input-file">
                                        <span class="button">

                                        {!! Form::file('value',  ['id' => 'file', 'onchange' => "this.parentNode.nextSibling.value = this.value"]) !!} Обзор...

                                        </span><input type="text" placeholder="выберите файл" readonly="">

                                    </div>

                                @elseif (isset($row) && $row->type == 'HTML' || $type == 'HTML')
                                    {!! Form::label('value', 'Значение*', ['class' => 'label']) !!}

                                    <label class="textarea textarea-resizable">

                                        {!! Form::textarea('value', old('value', $row->value ?? null), ['rows' => "5", 'class' => 'custom-scroll']) !!}

                                    </label>
                                @else

                                    {!! Form::label('value', 'Значение*', ['class' => 'label']) !!}

                                    <label class="input">

                                        {!! Form::text('value', old('value', $row->value ?? null), ['class' => 'form-control']) !!}

                                    </label>

                                @endif

                                @if ($errors->has('value'))
                                    <p class="text-danger">{{ $errors->first('value') }}</p>
                                @endif

                            </section>
                            <section>

                                {!! Form::label('name', 'Название', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('name', old('value', $row->name ?? null), ['class' => 'form-control']) !!}

                                </label>

                                @if ($errors->has('name'))
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('display_value', 'Описание', ['class' => 'label']) !!}

                                <label class="textarea textarea-resizable">

                                    {!! Form::textarea('display_value', old('display_value', $row->display_value ?? null), ['rows' => "3", 'class' => 'custom-scroll']) !!}

                                </label>

                                @if ($errors->has('display_value'))
                                    <p class="text-danger">{{ $errors->first('display_value') }}</p>
                                @endif

                            </section>

                            <section>

                                <label class="checkbox">

                                    {!! Form::checkbox('published', 1, isset($row) ? ($row->published == true ? 1 : 0): 1) !!}

                                    <i></i>Публиковать</label>

                                @if ($errors->has('published'))
                                    <span class="text-danger">{{ $errors->first('published') }}</span>
                                @endif

                            </section>

                        </fieldset>

                        <footer>
                            <button type="submit" class="btn btn-primary button-apply">
                                {{ isset($row) ? 'Изменить' : 'Добавить' }}
                            </button>
                            <a class="btn btn-default" href="{{ route('cp.settings.index') }}">
                                Назад
                            </a>
                        </footer>

                        {!! Form::close() !!}

                    </div>

                    <!-- end widget div -->
                </div>
                <!-- end widget -->
            </div>
        </article>
    </div>

@endsection

@section('js')

    {!! Html::script('/admin/js/plugin/ckeditor/ckeditor.js') !!}

    <script>
        $(function () {
            @if(isset($row) && $row->type == 'HTML' || $type == 'HTML' )
            CKEDITOR.replace('value', {
                extraAllowedContent: 'img[title]',
                height: 380,
                startupFocus: true,
                filebrowserUploadUrl: '{{ url('/upload.php') }}',
                on: {
                    instanceReady: function () {
                        this.dataProcessor.htmlFilter.addRules({
                            elements: {
                                img: function (el) {
                                    el.attributes.title = el.attributes.alt;
                                }
                            }
                        });
                    }
                }
            });

            CKEDITOR.config.allowedContent = true;
            CKEDITOR.config.removePlugins = 'spellchecker, about, save, newpage, print, templates, scayt, flash, pagebreak, smiley,preview,find';
            CKEDITOR.config.extraAllowedContent = 'img[title]';
            @endif

            if ($("#options-select").length > 0) {
                let options = [];
                $("#options-select").tagit({
                    tags: options,
                    field: "value[]"
                });
                let values = $("#options-select").data("values");
                if (values.length > 0) {
                    $.each(values, function (i, e) {
                        $("#options-select").tagit("addTag", e);
                    });
                }
            }
        });
    </script>

@endsection
