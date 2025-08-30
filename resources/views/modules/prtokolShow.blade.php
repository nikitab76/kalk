@extends('index.sidebar')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h1 class="m-0">{{\App\Models\ProtokolName::query()->where('name_id', $protocol_id)->value('name')}}</h1>
                {{--<button class="btn btn-primary" data-toggle="modal"
                        data-target="#createModal">Создать протокол
                </button>--}}
            </div>
        </div>
    </div>

    <section class="content">
        <!-- Modal -->
        <div class="profile-content margin-top-50" id="coach_trenings_table_div">
            <div class="portlet light portlet-fit portlet-datatable bordered">
                <div class="portlet-body" id="tableDiv">
                    <div class="table-container">
                        <meta name="csrf-token" content="{{ csrf_token()}}">
                        <table width="100%" id="user_table"
                               class="table table-striped table-bordered table-hover dataTable dtr-inline word-break"></table>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                let table = false;

                function tableRender(data) {
                    if (table) {
                        table.destroy();
                        $('#user_table').empty(); // очищаем контейнер таблицы
                    }

                    let columns = [];

                    // первая колонка "Участник"
                    columns.push({
                        title: 'Участник',
                        data: 'user',
                        className: "cursor penalty column-100 text-align-center vertical-align-middle",
                    });

                    // формируем список уникальных ключей (кроме user)
                    let keys = new Set();
                    data.forEach(row => {
                        Object.keys(row).forEach(key => {
                            if (key !== 'user') {
                                keys.add(key);
                            }
                        });
                    });

                    keys.forEach(key => {
                        columns.push({
                            title: key,
                            data: key,
                            className: "cursor column-100 text-align-center vertical-align-middle",
                            width: '100',
                            render: function (val) {
                                return val ? val : '-';
                            }
                        });
                    });

                    table = $('#user_table').DataTable({
                        deferRender: true,
                        //iDisplayLength: 25,
                        paging: false,
                        order: [[0, "asc"]],
                        language: {
                            url: "{{ asset('assets/profile/plugins/datatables/ru.json') }}",
                        },
                        data: data,
                        dom: "<'row padding-top-5 mt-1 padding-left-15 padding-right-15' <'col-md-12'B>>" +
                            "<'row padding-left-15 padding-right-15'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>" +
                            "<'table-scrollable't>" +
                            "<'row padding-left-15 padding-right-15'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                        buttons: [
                            {
                                extend: 'collection',
                                text: ' Сохранить',
                                className: 'btn red btn-outline fa fa-download',
                                buttons: [
                                    { extend: 'excelHtml5', className: 'btn', text: 'EXCEL' },
                                    { extend: 'csvHtml5', className: 'btn', text: 'CSV' },
                                ]
                            },
                            {
                                extend: 'copy',
                                className: 'btn purple btn-outline fa fa-copy',
                                text: ' Копировать',
                            },
                            {
                                extend: 'print',
                                className: 'btn blue btn-outline fa fa-print',
                                text: ' Печать',
                                exportOptions: { stripHtml: false }
                            },
                            {
                                extend: 'colvis',
                                className: 'btn dark btn-outline fa fa-angle-down',
                                text: ' Выбрать колонки',
                            },
                        ],
                        columns: columns
                    });
                }

                // Вызов
                tableRender(@json($data ?? [], JSON_UNESCAPED_UNICODE));
            });
        </script>
    </section>
@endsection
