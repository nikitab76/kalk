@extends('index.sidebar')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h1 class="m-0">Список протоколов</h1>
                <button class="btn btn-primary" data-toggle="modal"
                        data-target="#createModal">Создать протокол
                </button>
            </div>
        </div>
    </div>

    <section class="content">
        <!-- Modal -->
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form role="form" method="post" action="{{route('createProtocol')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Создать протокол</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="protocol_name">Название протокола</label>
                                        <input type="text" class="form-control" id="protocol_name" name="protocol_name"
                                           placeholder="Нормативы ГТО" value="{{old('protocol_name')}}"
                                           autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="date">Дата проведения</label>
                                    <input type="date" class="form-control" id="date" name="date"
                                           placeholder="" value="{{old('date')}}"
                                           autocomplete="off">
                                </div>
                                <label for="users_group">Импорт пользователей</label>
                                <input type="file" class="form-control" id="users_group" name="users_group"
                                       value="{{old('users_group')}}" autocomplete="off">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="content">
            @if(\App\Models\ProtokolName::query()->count() == 0)
                <div class="text-center" id="noProtokol">
                    <h1>Протоколов еще нет</h1>
                </div>
            @endif
            <div class="content" id="table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название</th>
                        <th scope="col">Протокол</th>
                        <th scope="col">Дата</th>
                        <th scope="col">Дата создания</th>
                        <th scope="col">Ссылка</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(\App\Models\ProtokolName::all() as $protokol)
                        <tr>
                            <th scope="row">1</th>
                            <td><a href="{{route('protokol.list', ['protocol_id' => $protokol['name_id']])}}">{{$protokol['name']}}</a></td>
                            <td><a href="{{route('show.protocol', ['protocol_id' => $protokol['name_id']])}}"><i class="fa fa-list"></i></a></td>
                            <td>{{isset($protokol['date']) ? date('d-m-Y', strtotime($protokol['date'])) : ''}}</td>
                            <td>{{date('d-m-Y', strtotime($protokol['created_at']))}}</td>
                            <td>
                                <!-- иконка для копирования -->
                                <i class="fa fa-link copy-btn"
                                   data-link="{{ route('protokol.list', ['protocol_id' => $protokol['name_id']]) }}"
                                   style="cursor: pointer;"></i>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            $(function () {
                $(".copy-btn").on("click", function () {
                    let link = $(this).data("link");

                    if (navigator.clipboard && window.isSecureContext) {
                        // Современный способ (https или localhost)
                        navigator.clipboard.writeText(link).then(() => {
                            alert("Ссылка скопирована: " + link);
                        }).catch(err => {
                            console.error("Ошибка копирования:", err);
                        });
                    } else {
                        // Fallback для http
                        let textarea = document.createElement("textarea");
                        textarea.value = link;
                        textarea.style.position = "fixed";  // чтобы не скакала страница
                        textarea.style.opacity = 0;         // невидимая
                        document.body.appendChild(textarea);
                        textarea.focus();
                        textarea.select();

                        try {
                            document.execCommand("copy");
                            alert("Ссылка скопирована (fallback): " + link);
                        } catch (err) {
                            console.error("Ошибка копирования (fallback):", err);
                        }

                        document.body.removeChild(textarea);
                    }
                });
            });

        </script>
    </section>
@endsection
