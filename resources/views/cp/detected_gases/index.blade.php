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

                    <a href="{{ route('cp.products.index') }}">
                        назад
                    </a><br><br>

                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-12">

                                <a href="{{ route('cp.detected_gases.create', ['product_id' => $product_id]) }}"
                                   class="btn btn-info btn-sm pull-left">
                                    <span class="fa fa-plus"> &nbsp;</span> Добавить
                                </a>
                            </div>
                        </div>
                    </div>

                    <form class="smart-form">

                        {!! Form::hidden('product_id', $product_id) !!}

                        <fieldset>

                            <section>
                                <label class="label">Выберети продукцию</label>
                                <label class="input">
                                    <input type="text" list="list">
                                    <datalist id="list">

                                        @foreach($rows as $row)
                                            <option data-id="{ $row->id }}" value="{{ $row->title }}">{{ $row->title }}</option>
                                        @endforeach

                                    </datalist>


                                </label>

                            </section>

                        </fieldset>

                        <footer>
                            <button type="submit" class="btn btn-primary">
                                Перенести характеристики
                            </button>
                        </footer>

                    </form>
                    <br>

                    <div class="table-responsive">
                        <table id="itemList" class="table table-striped table-bordered table-hover" width="100%">
                            <thead>
                            <tr>
                                <th>Наименование вещества</th>
                                <th>Химическая формула</th>
                                <th>Диапазон измерения</th>
                                <th width="20px">Действия</th>
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
        $(function () {
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
                    url: '{{ route('cp.datatable.detected_gases', ['product_id' => $product_id]) }}'
                },
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'formula', name: 'formula'},
                    {data: 'volume_fraction', name: 'volume_fraction'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},
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
                            url: '{{ URL::route('cp.detected_gases.destroy') }}',
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
