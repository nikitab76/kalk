@extends('index.sidebar')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Расчет очков</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <label for="date_start" class="form-label">
                        <h3 class="card-title mb-3">Дата проведения соревнований</h3>
                    </label>
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <input type="date" name="date_start" id="date_start" class="form-control"
                                   placeholder="Дата начала">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4">
                            <label for="user" class="form-label">ФИО</label>
                            <input type="text" name="user" id="user" class="form-control" placeholder="Иванов Иван">
                        </div>
                        <div class="col-12 col-md-6 col-lg-2">
                            <label for="birthday" class="form-label">Дата Рождения</label>
                            <input type="date" name="birthday" id="birthday" class="form-control">
                        </div>
                        <div class="col-12 col-md-6 col-lg-1">
                            <label for="birthday" class="form-label">Пол</label>
                            <div class="col-12 col-md-6 col-lg-1">
                                <!-- radio -->
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radio1">
                                        <label class="form-check-label">М</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radio1" checked="">
                                        <label class="form-check-label">Ж</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2">
                            <label for="sport_view" class="form-label">Вид</label>
                            <select name="sport_view" id="sport_view" class="form-control">
                                <option value="1">Подтягивание</option>
                                <option value="2">Сгибание/разгибание туловища</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 mb-3">
                            <label for="user_result" class="form-label">Результат</label>
                            <div class="input-group">
                                <input type="text" name="user_result" id="user_result" class="form-control" placeholder="результат">
                                <span class="input-group-text">=&gt;</span>
                                <input type="text" class="form-control bg-light text-muted" value="45" readonly>
                            </div>
                        </div>
                        {{--<div class="col-12 col-md-6 col-lg-2">
                            <label for="user_points" class="form-label">Очки</label>
                            <input type="text" name="user_points" id="user_points" class="form-control">
                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
