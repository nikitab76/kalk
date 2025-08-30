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
        {{--<table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Пользователь</th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $id => $user)
                <tr>
                    <th scope="row">#</th>
                    <td><a href="{{route('user.individual.list', ['user_id' => $id, 'protocol_id' => $protocol_id])}}">{{$user}}</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>--}}
        <table width="100%" id="user_table"
               class="table table-striped table-bordered table-hover dataTable dtr-inline word-break"></table>
    </section>
    <script>
        $(document).ready(function () {
            let table = false;
            let protocol_id = @json($protocol_id)

            function tableRender(data) {
                console.log(data)
                if (table) {
                    table.destroy();
                    $('#user_table').empty(); // очищаем контейнер таблицы
                }

                let columns = [];


                /*columns.push({
                    title: 'Участник',
                    data: 'user',
                    className: "cursor penalty column-100 text-align-center vertical-align-middle",
                    render: function (data, type, row) {
                        return `<a href="/result/user_${row.id}/${protocol_id}" class="user-link">${data}</a>`;
                    }
                });*/

                columns.push({
                    title: 'Участник',
                    data: 'user',
                    className: "cursor penalty column-100 text-align-center vertical-align-middle",
                    createdCell: function (td, cellData, rowData) {
                        // Добавляем обработчик клика на всю ячейку
                        $(td).css('cursor', 'pointer'); // меняем курсор
                        $(td).on('click', function() {
                            window.location.href = `/result/user_${rowData.id}/${protocol_id}`; // переход в профиль
                        });
                    }
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
                    dom: "<'row padding-left-15 padding-right-15'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>" +
                        "<'table-scrollable't>" +
                        "<'row padding-left-15 padding-right-15'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

                    columns: columns
                });
            }

            // Вызов
            let data = @json($list ?? [], JSON_UNESCAPED_UNICODE);
            let dataArray = Object.keys(data).map(id => ({
                id: id,
                user: data[id]
            }));

            tableRender(dataArray);

        });
    </script>
@endsection
