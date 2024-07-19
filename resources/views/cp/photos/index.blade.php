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

                        {!! Form::open(['url' => route('cp.photos.upload'), 'files' => true, 'method' => 'post', 'id' => 'smart-form']) !!}

                        {!! Form::hidden('photoalbum_id', $row->id) !!}

                        <div class="smart-form">

                            <header>
                                <a href="{{ route('cp.photoalbum.index') }}">
                                    назад
                                </a><br><br>
                                *-Обязательные поля
                            </header>

                            <fieldset>

                                <section>

                                    {!! Form::label('title', 'Title', ['class' => 'label']) !!}

                                    <label class="input">

                                        {!! Form::text('title', old('title'), ['class' => 'form-control']) !!}

                                    </label>

                                    @if ($errors->has('title'))
                                        <p class="text-danger">{{ $errors->first('title') }}</p>
                                    @endif

                                </section>

                                <section>

                                    {!! Form::label('description', 'Описание', ['class' => 'label']) !!}

                                    <label class="textarea textarea-resizable">

                                        {!! Form::textarea('description', old('description'), ['rows' => "5", 'class' => 'custom-scroll']) !!}

                                    </label>

                                    @if ($errors->has('description'))
                                        <p class="text-danger">{{ $errors->first('description') }}</p>
                                    @endif

                                </section>

                                <section>

                                    {!! Form::label('alt', 'Alt', ['class' => 'label']) !!}

                                    <label class="input">

                                        {!! Form::text('alt', old('alt'), ['class' => 'form-control']) !!}

                                    </label>

                                    @if ($errors->has('alt'))
                                        <p class="text-danger">{{ $errors->first('alt') }}</p>
                                    @endif

                                </section>

                                <section>

                                    {!! Form::label('image', 'Фото (jpg,gif,png)*', ['class' => 'label']) !!}

                                    <div class="input input-file">
                                        <span class="button">

                                        {!! Form::file('image',  ['id' => 'image', 'onchange' => "this.parentNode.nextSibling.value = this.value"]) !!} Обзор...

                                        </span><input type="text" placeholder="выберите файл" readonly="">

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
                                    Добавить
                                </button>
                                <a class="btn btn-default" href="{{ route('cp.photoalbum.index') }}">
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

    <div class="row-fluid">

        <div class="col">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="false">

                <!-- widget div-->
                <div>
                    <h2>Фото</h2>

                    <table id="itemList" class="table table-striped table-bordered table-hover" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Фото</th>
                            <th>Title</th>
                            <th>Alt</th>
                            <th>Создан</th>
                            <th data-hide="phone,tablet">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
                <!-- end widget content -->

            </div>
            <!-- end widget div -->

        </div>
        <!-- end widget -->

    </div>

@endsection

@section('js')

    <script>
        $(function() {
            pageSetUp();
            /* // DOM Position key index //
            l - Length changing (dropdown)
            f - Filtering input (search)
            t - The Table! (datatable)
            i - Information (records)
            p - Pagination (paging)
            r - pRocessing
            < and > - div elements
            <"#id" and > - div with an id
            <"class" and > - div with a class
            <"#id.class" and > - div with an id and class
            Also see: http://legacy.datatables.net/usage/features
            */
            /* BASIC ;*/
            let responsiveHelper_dt_basic = undefined;

            let breakpointDefinition = {
                tablet: 1024,
            };

            $('#itemList').dataTable({
                "sDom": "flrtip",
                "autoWidth": true,
                "oLanguage": {
                    "sLengthMenu": "Отображено _MENU_ записей на страницу",
                    "sZeroRecords": "Ничего не найдено - извините",
                    "sInfo": "Показано с _START_ по _END_ из _TOTAL_ записей",
                    "sInfoEmpty": "Показано с 0 по 0 из 0 записей",
                    "sInfoFiltered": "(отфильтровано  _MAX_ всего записей)",
                    "oPaginate": {
                        "sFirst": "Первая",
                        "sLast": "Посл.",
                        "sNext": "След.",
                        "sPrevious": "Пред.",
                    },
                    "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
                },
                "preDrawCallback": function () {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#itemList'), breakpointDefinition);
                    }
                },
                "rowCallback": function (nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback": function (oSettings) {
                    responsiveHelper_dt_basic.respond();
                },
                'createdRow': function (row, data, dataIndex) {
                    $(row).attr('id', 'rowid_' + data['id']);
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('cp.datatable.photos',['photoalbum_id' => $row->id]) }}'
                },
                columns: [
                    {data: 'id', name: 'id', searchable: false},
                    {data: 'thumbnail', name: 'thumbnail', orderable: false, searchable: false},
                    {data: 'title', name: 'title'},
                    {data: 'alt', name: 'alt'},
                    {data: 'created_at', name: 'created_at'},
                    {data: "actions", name: 'actions', orderable: false, searchable: false}
                ],
            });

            $('#itemList').on('click', 'a.deleteRow', function () {
                let rowid = $(this).attr('id');

                swal({
                        title: "Вы уверены?",
                        text: "Вы не сможете восстановить эту информацию!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Да",
                        cancelButtonText: "Отмена",
                        closeOnConfirm: false
                    },
                    function (isConfirm) {
                        if (!isConfirm) return;

                        $.ajax({
                            url: '{{ route('cp.photos.destroy') }}',
                            type: "POST",
                            dataType: "html",
                            data: {id: rowid},
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success: function () {
                                $("#rowid_" + rowid).remove();
                                swal("Сделано!", "Данные успешно удалены!", "success");
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                swal("Ошибка при удалении!", "Попробуйте еще раз", "error");
                            }
                        });
                    });
            });
        })
    </script>

@endsection

