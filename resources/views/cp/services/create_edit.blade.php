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

                        {!! Form::open(['url' => isset($row) ? URL::route('cp.services.update') : URL::route('cp.services.store'), 'method' => isset($row) ? 'put' : 'post', 'files' => true,'class' => "smart-form"]) !!}

                        {!! isset($row) ? Form::hidden('id', $row->id) : '' !!}

                        <header>
                            *-обязательные поля
                        </header>

                        <fieldset>

                            <section>

                                {!! Form::label('title', 'Название*', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('title', old('title', $row->title ?? ''), ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                                </label>

                                @if ($errors->has('title'))
                                    <p class="text-danger">{{ $errors->first('title') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('description', 'Описание*', ['class' => 'label']) !!}

                                <label class="textarea textarea-resizable">

                                    {!! Form::textarea('description', old('description', $row->description ?? null), ['placeholder' =>'Описание','class' => 'form-control', 'rows' => 3]) !!}

                                </label>

                                @if ($errors->has('description'))
                                    <p class="text-danger">{{ $errors->first('description') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('full_description', 'Полное описание*', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::textarea('full_description', old('full_description', $row->full_description ?? null), ['placeholder' =>'Описание','class' => 'form-control', 'rows' => 5]) !!}

                                </label>

                                @if ($errors->has('full_description'))
                                    <p class="text-danger">{{ $errors->first('full_description') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('slug', 'ЧПУ*', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('slug', old('slug', $row->slug ?? null), ['class' => 'form-control', 'id' => 'slug']) !!}

                                </label>

                                @if ($errors->has('slug'))
                                    <p class="text-danger">{{ $errors->first('slug') }}</p>
                                @endif

                            </section>

                            <h3>SEO</h3>

                            <section>

                                {!! Form::label('meta_title', 'Seo title', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('meta_title', old('meta_title', $row->meta_title ?? null), ['class' => 'form-control']) !!}

                                </label>

                                @if ($errors->has('meta_title'))
                                    <p class="text-danger">{{ $errors->first('meta_title') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('meta_title', 'Meta description', ['class' => 'label']) !!}

                                <label class="textarea textarea-resizable">

                                    {!! Form::textarea('meta_description', old('meta_description', $row->meta_description ?? null), ['rows' => "3", 'class' => 'custom-scroll']) !!}

                                </label>

                                @if ($errors->has('meta_description'))
                                    <p class="text-danger">{{ $errors->first('meta_description') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('meta_keywords', 'Meta keywords', ['class' => 'label']) !!}

                                <label class="textarea textarea-resizable">

                                    {!! Form::textarea('meta_keywords', old('meta_keywords', $row->meta_keywords ?? null), ['rows' => "3", 'class' => 'custom-scroll']) !!}

                                </label>

                                @if ($errors->has('meta_keywords'))
                                    <p class="text-danger">{{ $errors->first('meta_keywords') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('seo_h1', 'Seo h1', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('seo_h1', old('seo_h1', $row->seo_h1 ?? null), ['class' => 'form-control']) !!}

                                </label>

                                @if ($errors->has('seo_h1'))
                                    <p class="text-danger">{{ $errors->first('seo_h1') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('seo_url_canonical', 'Seo url canonical', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('seo_url_canonical', old('seo_url_canonical', $row->seo_url_canonical ?? null), ['class' => 'form-control']) !!}

                                </label>

                                @if ($errors->has('seo_url_canonical'))
                                    <p class="text-danger">{{ $errors->first('seo_url_canonical') }}</p>
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
                                        <img src='{{ url($row->getThumbnailUrl()) }}' width="150">
                                    @endif

                                </div>

                                @if ($errors->has('image'))
                                    <span class="text-danger">{{ $errors->first('image') }}</span>
                                @endif

                                <div class="note">
                                    Максимальный размер: <strong>{{ $maxUploadFileSize }}</strong>
                                </div>

                            </section>

                            <section>

                                {!! Form::label('image_title', 'Image Title', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('image_title', old('image_title', $row->image_title ?? null), ['class' => 'form-control']) !!}

                                </label>

                                @if ($errors->has('image_title'))
                                    <p class="text-danger">{{ $errors->first('image_title') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('image_alt', 'Image Alt', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('image_alt', old('image_alt', $row->image_alt ?? null), ['class' => 'form-control']) !!}

                                </label>

                                @if ($errors->has('image_alt'))
                                    <p class="text-danger">{{ $errors->first('image_alt') }}</p>
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
                            <a class="btn btn-default" href="{{ URL::route('cp.services.index') }}">
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
        $(document).ready(function () {

            CKEDITOR.replace( 'full_description', {
                extraAllowedContent: 'img[title]',
                height: 380,
                startupFocus: true,
                filebrowserUploadUrl: '/upload.php',
                on: {
                    instanceReady: function() {
                        this.dataProcessor.htmlFilter.addRules( {
                            elements: {
                                img: function( el ) {
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

            $("#title").on("change keyup input click", function () {
                if (this.value.length >= 2) {
                    let title = this.value;
                    let request = $.ajax({
                        url: '{!! URL::route('cp.ajax.action') !!}',
                        method: "POST",
                        data: {
                            action: "get_services_slug",
                            title: title
                        },
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        dataType: "json"
                    });
                    request.done(function (data) {
                        if (data.slug != null && data.slug != '') {
                            $("#slug").val(data.slug);
                        }
                    });
                }
                console.log(html);
            });

        });
    </script>


@endsection
