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

                        {!! Form::open(['url' => isset($row) ? route('cp.users.update') : route('cp.users.store'), 'method' => isset($row) ? 'put' : 'post', 'class' => "smart-form"]) !!}

                        {!! isset($row) ? Form::hidden('id', $row->id) : '' !!}

                        <header>
                            *-обязательные поля
                        </header>

                        <fieldset>

                            <section>

                                {!! Form::label('name', 'Имя*', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('name', old('name', $row->name ?? ''), ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                                </label>

                                @if ($errors->has('name'))
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('login', 'Логин*', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::text('login', old('name', $row->login ?? ''), ['class' => 'form-control', 'autocomplete' => 'off']) !!}

                                </label>

                                @if ($errors->has('login'))
                                    <p class="text-danger">{{ $errors->first('login') }}</p>
                                @endif

                            </section>

                            @if ((isset($row->id) && $row->id != Auth::user()->id) || !isset($row->id))

                                <section>

                                    {!! Form::label('role', "Роль*", ['class' => 'label']) !!}

                                    <label class="select">

                                        {!! Form::select('role', $options, $row->role ?? 'admin', ['class' => 'input-sm', 'autocomplete' => 'off']) !!}
                                        <i></i>

                                    </label>

                                    @if ($errors->has('role'))
                                        <p class="text-danger">{{ $errors->first('role') }}</p>
                                    @endif

                                </section>

                            @endif

                            <section>

                                {!! Form::label('password',  isset($row) ? 'Пароль':'Пароль*', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::password('password', ['class' => 'form-control', 'id'=> "password"]) !!}

                                </label>

                                @if ($errors->has('password'))
                                    <p class="text-danger">{{ $errors->first('password') }}</p>
                                @endif

                            </section>

                            <section>

                                {!! Form::label('password_again', isset($row) ? 'Павтор пароля':'Павтор пароля*', ['class' => 'label']) !!}

                                <label class="input">

                                    {!! Form::password('password_again', ['class' => 'form-control', 'id'=> "password_again"]) !!}

                                </label>

                                @if ($errors->has('password_again'))
                                    <p class="text-danger">{{ $errors->first('password_again') }}</p>
                                @endif

                            </section>


                        </fieldset>

                        <footer>
                            <button type="submit" class="btn btn-primary button-apply">
                                {{ isset($row) ? 'Изменить' : 'Добавить' }}
                            </button>
                            <a class="btn btn-default" href="{{ route('cp.users.index') }}">
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


@endsection
