@extends('cp.app')

@section('title', $title)

@section('css')


@endsection

@section('content')

    <div class="row-fluid">

        <div class="col">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="false">

                <!-- widget div-->
                <div>

                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ URL::route('cp.services_catalog.create') }}"
                                   class="btn btn-info btn-sm pull-left">
                                    <span class="fa fa-plus"> &nbsp;</span> Добавить
                                </a>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="table-responsive">
                        <table id="itemList" class="table table-striped table-bordered table-hover" width="100%">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th>ЧПУ</th>
                                <th>Фото</th>
                                <th>Создан</th>
                                <th>Изменен</th>
                                <th data-hide="phone,tablet">Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

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
        $(document).ready(function () {
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
                    url: '{{ URL::route('cp.datatable.services_catalog') }}'
                },
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'slug', name: 'slug'},
                    {data: 'image', name: 'image', searchable: false},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_at', name: 'updated_at'},
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
                            url: '{{ URL::route('cp.services_catalog.destroy') }}',
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
