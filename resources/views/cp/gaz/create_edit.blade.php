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

                        {!! Form::open(['url' => isset($row) ? route('cp.gaz.update') : route('cp.gaz.store'), 'method' => isset($row) ? 'put' : 'post', 'id' => 'smart-form']) !!}

                        {!! isset($row) ? Form::hidden('id', $row->id) : '' !!}

                        <div class="smart-form">
                            <header>
                                *-Обязательные поля
                            </header>

                            <fieldset>

                                <section>

                                    {!! Form::label('title', 'Название*', ['class' => 'label']) !!}

                                    <label class="input">

                                        {!! Form::text('title', old('title', $row->title ?? null), ['class' => 'form-control', 'id' => 'title']) !!}

                                    </label>

                                    @if ($errors->has('title'))
                                        <p class="text-danger">{{ $errors->first('title') }}</p>
                                    @endif

                                </section>

                                <section>

                                    {!! Form::label('range', 'Диапазон измерений', ['class' => 'label']) !!}

                                    <label class="input">

                                        {!! Form::text('range', old('range',$row->range ?? null), ['class' => 'form-control', 'id' => 'weight']) !!}

                                    </label>

                                    @if ($errors->has('weight'))
                                        <p class="text-danger">{{ $errors->first('range') }}</p>
                                    @endif

                                </section>

                                <section>

                                    {!! Form::label('chemical_formula', 'Химичекая формула*', ['class' => 'label']) !!}

                                    <label class="input">

                                        {!! Form::text('chemical_formula', old('chemical_formula', $row->chemical_formula ?? null), ['class' => 'form-control', 'id' => 'chemical_formula']) !!}

                                    </label>

                                    @if ($errors->has('chemical_formula'))
                                        <p class="text-danger">{{ $errors->first('chemical_formula') }}</p>
                                    @endif

                                </section>

                                <section>

                                    {!! Form::label('chemical_formula_html', 'Химичекая формула html*', ['class' => 'label']) !!}

                                    <label class="input">

                                        {!! Form::text('chemical_formula_html', old('chemical_formula_html', $row->chemical_formula_html ?? null), ['class' => 'form-control', 'id' => 'chemical_formula_html']) !!}

                                    </label>

                                    @if ($errors->has('chemical_formula_html'))
                                        <p class="text-danger">{{ $errors->first('chemical_formula_html') }}</p>
                                    @endif

                                </section>

                            </fieldset>

                            <footer>
                                <button type="submit" class="btn btn-primary button-apply">
                                    {{ isset($row) ? 'Изменить' : 'Добавить' }}
                                </button>
                                <a class="btn btn-default" href="{{ route('cp.gaz.index') }}">
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
