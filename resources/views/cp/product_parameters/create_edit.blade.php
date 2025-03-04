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

                        {!! Form::open(['url' => isset($row) ? route('cp.product_parameters.update') : route('cp.product_parameters.store'), 'method' => isset($row) ? 'put' : 'post', 'class' => 'smart-form']) !!}

                        {!! isset($row) ? Form::hidden('id', $row->id) : '' !!}

                        {!! Form::hidden('product_id', $product_id) !!}

                        <header>
                            *-Обязательные поля
                        </header>

                        <fieldset>

                            <section>

                                {!! Form::label('category_id',  "Категория", ['class' => 'label']) !!}

                                <label class="select">

                                    {!! Form::select('category_id', $options, old('category_id', $row->category_id ?? 0), ['placeholder' => 'Основные', 'class' => 'input-sm']) !!}
                                    <i></i>

                                </label>

                                @if ($errors->has('category_id'))
                                    <p class="text-danger">{{ $errors->first('category_id') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('name', 'Параметр*', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('name', old('name', $row->name ?? null), ['class' => 'form-control']) !!}

                                </label>

                                @if ($errors->has('name'))
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('value', 'Значение*', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('value', old('value', $row->value ?? null), ['class' => 'form-control']) !!}

                                </label>

                                @if ($errors->has('value'))
                                    <p class="text-danger">{{ $errors->first('value') }}</p>
                                @endif

                            </section>

                        </fieldset>

                        <footer>
                            <button type="submit" class="btn btn-primary button-apply">
                                {{ isset($row) ? 'Изменить' : 'Добавить' }}
                            </button>
                            <a class="btn btn-default"
                               href="{{ URL::route('cp.product_parameters.index', ['product_id' => $product_id]) }}">
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
