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

                        {!! Form::open(['url' => isset($row) ? URL::route('cp.catalog.update') : URL::route('cp.catalog.store'), 'files' => true, 'method' => isset($row) ? 'put' : 'post', 'class' => "smart-form"]) !!}

                        {!! isset($row) ? Form::hidden('id', $row->id) : '' !!}

                        {!! isset($parent_id) ? Form::hidden('parent_id', $parent_id) : '' !!}

                        {!! Form::hidden('pic', isset($row) && $row->image ? $row->image : NULL) !!}

                        <header>
                            *-обязательные поля
                        </header>

                        <fieldset>

                            <section>

                                {!! Form::label('name', 'Название*', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('name', old('name', isset($row) ? $row->name : ''), ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'name']) !!}

                                </label>

                                @if ($errors->has('name'))
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                @endif

                            </section>

                            @if (($parent_id == 0 && !isset($row)) || isset($row))

                                <section>

                                    {!! Form::label('parent_id',  "Раздел", ['class' => 'label']) !!}

                                    <label class="select">

                                        {!! Form::select('parent_id', $options, old('parent_id', isset($row) ? $row->parent_id : 0), ['class' => 'input-sm']) !!}
                                        <i></i>

                                    </label>

                                    @if ($errors->has('parent_id'))
                                        <p class="text-danger">{{ $errors->first('parent_id') }}</p>
                                    @endif

                                </section>

                            @endif

                            <section>

                                {!! Form::label('description', 'Описание', ['class' => 'label']) !!}

                                <label class="textarea textarea-resizable">

                                    {!! Form::textarea('description', old('description', isset($row) ? $row->description : null), ['rows' => "5", 'class' => 'custom-scroll']) !!}

                                </label>

                                @if ($errors->has('description'))
                                    <p class="text-danger">{{ $errors->first('description') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('slug', 'ЧПУ*', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('slug', old('slug', isset($row) ? $row->slug : null), ['class' => 'form-control', 'id' => 'slug']) !!}

                                </label>

                                @if ($errors->has('slug'))
                                    <p class="text-danger">{{ $errors->first('slug') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('image', 'Фото (jpg,gif,png)', ['class' => 'label']) !!}

                                <div class="input input-file">
                                    <span class="button">

                                        {!! Form::file('image',  ['id' => 'image', 'onchange' => "this.parentNode.nextSibling.value = this.value"]) !!} Обзор...

                                    </span><input type="text" placeholder="выберите файл" readonly="">

                                    <br>
                                    @if (isset($row) && !empty($row->image))
                                        <img src='{{ url($row->getImage()) }}' width="150">
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

                                    {!! Form::text('image_title', old('image_title', isset($row) ? $row->image_title : null), ['class' => 'form-control']) !!}

                                </label>

                                @if ($errors->has('image_title'))
                                    <p class="text-danger">{{ $errors->first('image_title') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('image_alt', 'Image Alt', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('image_alt', old('image_alt', isset($row) ? $row->image_alt : null), ['class' => 'form-control']) !!}

                                </label>

                                @if ($errors->has('image_alt'))
                                    <p class="text-danger">{{ $errors->first('image_alt') }}</p>
                                @endif

                            </section>

                            <h3>SEO</h3>

                            <section>

                                {!! Form::label('meta_title', 'Seo title', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('meta_title', old('meta_title', isset($row) ? $row->meta_title : null), ['class' => 'form-control']) !!}

                                </label>

                                @if ($errors->has('meta_title'))
                                    <p class="text-danger">{{ $errors->first('meta_title') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('meta_title', 'Meta description', ['class' => 'label']) !!}

                                <label class="textarea textarea-resizable">

                                    {!! Form::textarea('meta_description', old('meta_description', isset($row) ? $row->meta_description : null), ['rows' => "3", 'class' => 'custom-scroll']) !!}

                                </label>

                                @if ($errors->has('meta_description'))
                                    <p class="text-danger">{{ $errors->first('meta_description') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('meta_keywords', 'Meta keywords', ['class' => 'label']) !!}

                                <label class="textarea textarea-resizable">

                                    {!! Form::textarea('meta_keywords', old('meta_keywords', isset($row) ? $row->meta_keywords : null), ['rows' => "3", 'class' => 'custom-scroll']) !!}

                                </label>

                                @if ($errors->has('meta_keywords'))
                                    <p class="text-danger">{{ $errors->first('meta_keywords') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('seo_h1', 'Seo h1', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('seo_h1', old('seo_h1', isset($row) ? $row->seo_h1 : null), ['class' => 'form-control']) !!}

                                </label>

                                @if ($errors->has('seo_h1'))
                                    <p class="text-danger">{{ $errors->first('seo_h1') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('seo_url_canonical', 'Seo url canonical', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('seo_url_canonical', old('seo_url_canonical', isset($row) ? $row->seo_url_canonical : null), ['class' => 'form-control']) !!}

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
                            <a class="btn btn-default" href="{{ URL::route('cp.catalog.index') }}">
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
        $(document).ready(function () {
            $("#name").on("change keyup input click", function () {
                if (this.value.length >= 2) {
                    let name = this.value;
                    let request = $.ajax({
                        url: '{!! URL::route('cp.ajax.action') !!}',
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
