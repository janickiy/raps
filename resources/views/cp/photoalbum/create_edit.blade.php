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

                        {!! Form::open(['url' => isset($row) ? route('cp.photoalbum.update') : route('cp.photoalbum.store'), 'method' => isset($row) ? 'put' : 'post', 'class' => "smart-form"]) !!}

                        {!! isset($row) ? Form::hidden('id', $row->id) : '' !!}

                        <header>
                            *-обязательные поля
                        </header>

                        <fieldset>

                            <section>

                                {!! Form::label('name', 'Название*', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('name', old('name', $row->name ?? ''), ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'name']) !!}

                                </label>

                                @if ($errors->has('name'))
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('description', 'Описание', ['class' => 'label']) !!}

                                <label class="textarea textarea-resizable">

                                    {!! Form::textarea('description', old('description', $row->description ?? null), ['rows' => "5", 'class' => 'custom-scroll']) !!}

                                </label>

                                @if ($errors->has('description'))
                                    <p class="text-danger">{{ $errors->first('description') }}</p>
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

                        </fieldset>

                        <footer>
                            <button type="submit" class="btn btn-primary button-apply">
                                {{ isset($row) ? 'Изменить' : 'Добавить' }}
                            </button>
                            <a class="btn btn-default" href="{{ route('cp.photoalbum.index') }}">
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

    <script>
        $(function() {
            $("#name").on("change keyup input click", function () {
                if (this.value.length >= 2) {
                    let name = this.value

                    let request = $.ajax({
                        url: '{!! route('cp.ajax.action') !!}',
                        method: "POST",
                        data: {
                            action: "get_catalog_slug",
                            name: name
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
