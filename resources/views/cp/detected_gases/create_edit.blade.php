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

                        {!! Form::open(['url' => isset($row) ? route('cp.detected_gases.update') : route('cp.detected_gases.store'), 'method' => isset($row) ? 'put' : 'post', 'class' => 'smart-form']) !!}

                        {!! isset($row) ? Form::hidden('id', $row->id) : '' !!}

                        {!! Form::hidden('product_id', $product_id) !!}

                        <header>
                            *-Обязательные поля
                        </header>

                        <fieldset>

                            <section>

                                {!! Form::label('name', 'Наименование вещества*', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('name', old('name', $row->name ?? null), ['class' => 'form-control']) !!}

                                </label>

                                @if ($errors->has('name'))
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('formula', 'Химическая формула*', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('formula', old('formula', $row->formula ?? null), ['class' => 'form-control']) !!}

                                </label>

                                @if ($errors->has('formula'))
                                    <p class="text-danger">{{ $errors->first('formula') }}</p>
                                @endif

                            </section>

                            <div class="row">

                                <section class="col col-6">

                                    {!! Form::label('range', 'массовая концентрация, мг/м3', ['class' => 'label']) !!}

                                    <label class="input">

                                        {!! Form::text('range', old('range', $row->range ?? null), ['class' => 'form-control']) !!}

                                    </label>

                                    @if ($errors->has('range'))
                                        <p class="text-danger">{{ $errors->first('range') }}</p>
                                    @endif

                                </section>


                                <section class="col col-6">

                                    {!! Form::label('volume_fraction', 'объемная доля,%', ['class' => 'label']) !!}

                                    <label class="input">

                                        {!! Form::text('volume_fraction', old('volume_fraction', $row->volume_fraction ?? null), ['class' => 'form-control']) !!}

                                    </label>

                                    @if ($errors->has('volume_fraction'))
                                        <p class="text-danger">{{ $errors->first('volume_fraction') }}</p>
                                    @endif

                                </section>

                            </div>

                        </fieldset>

                        <footer>
                            <button type="submit" class="btn btn-primary button-apply">
                                {{ isset($row) ? 'Изменить' : 'Добавить' }}
                            </button>
                            <a class="btn btn-default"
                               href="{{ URL::route('cp.detected_gases.index', ['product_id' => $product_id]) }}">
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
