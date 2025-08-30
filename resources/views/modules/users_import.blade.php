@extends('index.sidebar')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Массовый подсчет</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="container my-4">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <h3>Таблица соревнований</h3>
                    <div class="d-flex flex-wrap">
                        <select id="normativeSelect" class="form-select me-2 mb-2">
                            <option value="" disabled selected>Выбрать норматив</option>
                            <option value="Подтягивание">Подтягивание</option>
                            <option value="Сгибание/разгибание туловища">Сгибание/разгибание туловища</option>
                            <option value="Бег 100 м">Бег 100 м</option>
                            <option value="Прыжки в длину">Прыжки в длину</option>
                        </select>
                        <button id="addNormative" class="btn btn-primary mb-2">Добавить норматив</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="competitionTable">
                        <thead class="table-light">
                        <tr id="tableHeader">
                            <th class="fixed-column">ФИО</th>
                            <th>Дата рождения</th>
                            <th>Пол</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Строки будут добавляться динамически -->
                        </tbody>
                    </table>
                </div>

                <button id="addRow" class="btn btn-success mt-3">Добавить участника</button>
            </div>

            <script>
                $(document).ready(function() {
                    const $table = $('#competitionTable');
                    const $tableHeader = $('#tableHeader');
                    const $tbody = $table.find('tbody');
                    const $addNormativeBtn = $('#addNormative');
                    const $normativeSelect = $('#normativeSelect');
                    const $addRowBtn = $('#addRow');

                    let rowCount = 0;

                    function addRow() {
                        const newRow = $('<tr>');

                        newRow.html(`
                <td class="fixed-column"><input type="text" class="form-control" name="user[]"></td>
                <td><input type="date" class="form-control" name="birthday[]"></td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="form-check me-2">
                            <input class="form-check-input" type="radio" name="gender_${rowCount}" value="М">
                            <label class="form-check-label">М</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender_${rowCount}" value="Ж">
                            <label class="form-check-label">Ж</label>
                        </div>
                    </div>
                </td>
            `);

                        const extraColumns = $tableHeader.find('th.extra-normative').length;
                        for (let i = 0; i < extraColumns; i++) {
                            newRow.append('<td><div class="input-group">' +
                                '<input type="text" name="" id="" class="form-control" placeholder="результат">' +
                                '<span class="input-group-text">=&gt;</span>' +
                            '<input type="text" class="form-control bg-light text-muted" readonly>' +
                            '</div></td>');
                        }

                        $tbody.append(newRow);
                        rowCount++;

                        // Добавляем обработчик для отслеживания изменений инпутов
                        newRow.find('input').on('change', function() {
                            console.log('Изменения в инпуте:',  $(this).val());
                        });
                    }

                    function addNormative() {
                        const selectedOption = $normativeSelect.val();
                        if (!selectedOption) {
                            alert('Выберите норматив!');
                            return;
                        }

                        const newTh = $('<th class="extra-normative">').html(`
                ${selectedOption}
                <button class="remove-btn" onclick="removeNormative(this)">❌</button>
            `);
                        $tableHeader.append(newTh);

                        $tbody.find('tr').each(function() {
                            $(this).append('<td><div class="input-group">' +
                                '<input type="text" name="" id="" class="form-control" placeholder="результат">' +
                                '<span class="input-group-text">=&gt;</span>' +
                            '<input type="text" class="form-control bg-light text-muted" readonly>' +
                            '</div></td>');
                        });

                        $normativeSelect.prop('selectedIndex', 0);
                    }

                    function removeNormative(button) {
                        const $th = $(button).closest('th');
                        const index = $tableHeader.children().index($th);

                        $th.remove();

                        $tbody.find('tr').each(function() {
                            $(this).children().eq(index).remove();
                        });
                    }

                    // Слушаем клики по кнопкам
                    $addRowBtn.on('click', addRow);
                    $addNormativeBtn.on('click', addNormative);
                });

                $('#competitionTable tbody').on('change', 'input[name="normative[]"]', function() {
                    console.log('Пользователь закончил ввод норматива:', $(this).val());

                });

                $('#competitionTable tbody').on('change', 'input', function() {
                    const $row = $(this).closest('tr'); // нашли строку
                    const rowData = {};

                    // Перебираем все input внутри этой строки
                    $row.find('input').each(function() {
                        const name = $(this).attr('name');
                        const value = $(this).val();
                        rowData[name] = value;
                    });

                    console.log(rowData); // объект со всеми данными строки
                });
            </script>
        </div>
    </section>
@endsection
