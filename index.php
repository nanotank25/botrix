<!doctype html>
<? session_start(); ?>
<? require_once('update.php');?>
<html lang="en">
<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/loading-bar.css"/>
    <script type="text/javascript" src="js/loading-bar.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <? if (isset($_SESSION['width'])) { ?>
        <style>.container {
                max-width: <?=$_SESSION['width']?>px;
            }</style>
    <? } ?>
    <title>BotRix</title>
</head>
<body>
<main role="main" class="container">
    <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded box-shadow">
        <img class="mr-3" src="logo.png" alt="Bitrix Version" width="150">
        <h1 class="title" style="color:#6c757d;">Бутрикс(Тест обновления)</h1>
    </div>
    <div class="chat my-3 p-3 bg-white rounded box-shadow">
        <h6 class="border-bottom border-gray pb-2 mb-0">Чат
            <div id='session' class="right">
                <i class="fa fa-times-circle" title="Tooltip on top" style="color:red; font-size: 20px;"></i>
                <i class="fa fa-times-circle" title="Tooltip on top" style="color:red; font-size: 20px;"></i>
                <i class="fa fa-times-circle" title="Tooltip on top" style="color:red; font-size: 20px;"></i>
            </div>
        </h6>
        <div class="media text-muted pt-3">
            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <strong class="d-block text-gray-dark">Бутрикс</strong>
                Для начала работы напишите одну из
                <a href="#" data-toggle="modal" data-target="#exampleModal">команд</a>
            </p>
        </div>
        <div id="results"></div>
        <form method="POST" id="formx" action="javascript:void(null);" onsubmit="call()">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-primary" type="submit">Отправить</button>
                </div>
                <input type="text" autofocus id="textInput" class="form-control" maxlength="150" name="say" placeholder="Например: Инфоблок 5" aria-label="" required aria-describedby="basic-addon1" pla>
                <div class="input-group-append">
                    <button type="button" class="btn btn-outline-secondary" onclick="$('body,html').animate({scrollTop:0},800);">Наверх</button>
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Меню</span>
                    </button>
                    <div class="dropdown-menu">
                        <h6 class="dropdown-header">Возможности</h6>
                        <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal">Команды</a>
                        <a class="dropdown-item" onclick="document.getElementById('results').innerHTML = ''">Отчистка</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <p class="mt-5 mb-3 text-muted">Inter<span style="color:red;">Volga</span> 2018</p>

</main>
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Список функционала</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <div class="list-group" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action active" id="list-1-list" data-toggle="list" href="#list-1" role="tab" aria-controls="home">Основные</a>
                            <a class="list-group-item list-group-item-action" id="list-4-list" data-toggle="list" href="#list-4" role="tab" aria-controls="git">SSH
                                <span class="badge badge-success">NEW</span></a>
                            <a class="list-group-item list-group-item-action" id="list-2-list" data-toggle="list" href="#list-2" role="tab" aria-controls="info">Взаимодействие</a>
                            <a class="list-group-item list-group-item-action" id="list-99-list" data-toggle="list" href="#list-99" role="tab" aria-controls="doc">Документация</a>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="list-1" role="tabpanel" aria-labelledby="list-1-list">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><b>Ввод пароля</b> - Разблокирует бота</li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'Привет'; call();"><b>Привет</b></a> - Поздоровайся с ботом
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'Пока'; call();"><b>Пока</b></a> - Попрощатся с ботом. Бот автоматически после этой команды блокируется паролем.
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'Ширина 1200'"><b>Ширина (Количество px)</b></a> - Изменить размер окна.
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = '-'; call();"><b>-</b></a> - В срочном порядке заблокировать бота.
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'Отчистка'; call();"><b>Отчистка или cls</b></a> - Отчистит чат
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-pane fade show" id="list-4" role="tabpanel" aria-labelledby="list-4-list">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'git status'; call();"><b>git status</b></a> - Проверка состояния
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'cd'; call();"><b>cd или Память</b></a> - Показать инф. о использовании дисков
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'cpu'; call();"><b>cpu или цпу</b></a> - Отображает 25 самых загруженных по цпу процессов
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'mcp'; call();"><b>mcp или мцп</b></a> - Краткий отчет загруженных по цпу процессов
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'full'; call();"><b>full или фул</b></a> - Полный отчет загруженных по цпу процессов и информация о дисках
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="list-2" role="tabpanel" aria-labelledby="list-2-list">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'Инфоблоки'; call();"><b>Инфоблоки</b></a> - Выводит список инфоблоков. Внимание очень ресурсоемкая команда!
                                                                                                                                                                 После отправки перерыв между сообщениями 10 секунд.
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'ИБ '"><b>ИБ или Инфоблок (Номер инфоблока)</b></a> - Открывает инфоблок по указанному id
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'Инфоблок изменить '"><b>Инфоблок изменить (Номер инфоблока)</b></a> - Открывает страницу редактирования инфоблока
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'Юзеры'; call();"><b>Юзеры или Пользователи</b></a> - Показывает список пользователей
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'Вход '"><b>Вход (Номер пользователя)</b></a> - Авторизуется за определенного пользователя.
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'Юзер '"><b>Юзер или Пользователь (Номер пользователя)</b></a> - Показывает определенные данные пользователя
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'Формы'; call();"><b>Формы</b></a> - Открывает список Веб-Форм
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'Результаты '"><b>Результаты (Номер формы)</b></a> - Открывает краткий список ответов
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'Агенты'; call();"><b>Агенты</b></a> - Открывает список агентов
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'Таблицы'; call();"><b>Таблицы</b></a> - Открывает таблицы
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'event'; call();"><b>event или ивент</b></a> - Открывает таблицу b_event
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'Админ'; call();"><b>Админ</b></a> - Отрывает административную панель
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'Консоль'; call();"><b>Консоль</b></a> - Отрывает командную PHP-строку
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'Почта'; call();"><b>Почта</b></a> - Показывает полный список почтовых шаблонов
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'Почтовый шаблон '"><b>Почтовый шаблон (Номер шаблона)</b></a> - Открывает редактирование почтового шаблона
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'Копии'; call();"><b>Копии</b></a> - Отрывает резервные копии
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'Выход'; call();"><b>Выход</b></a> - Завершает текущую сессию, выходит из системы Bitrix
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'Часть кеша'; call();"><b>Часть кеша</b></a> - Удаляет устаревший кеш
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" data-dismiss="modal" onclick="document.getElementById('textInput').value = 'Весь кеш'; call();"><b>Весь кеш</b></a> - Удаляет весь кеш сайта.
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="list-99" role="tabpanel" aria-labelledby="list-99-list">
                                <div class="container">
                                    <div class="row">
                                        <p>Данный бот был написан специально для intervolga.</p>
                                        <p>Он позволяет управлять быстро и мощно системой Bitrix.
                                           Полный список команд можно прочитать в других разделах.</p>
                                        <p>Для правильной работы бота нужно его настроить.
                                           Разместите папку с ботом в директорию своего сайта.
                                           После этого зайдите в файл const.php и настройте имя пользователя и пароль к боту.
                                           Теперь вы можете смело открывать бота в браузере.</p>
                                        <p>Бот понимает только фразы которые есть в других разделах, если же он не знает что ответить,
                                           то он отвечает фразами из файла error.txt.</p>
                                        <p>Все действия которые с ним совершали записываются в файл log.txt.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Спасибо</button>
            </div>
        </div>
    </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" language="javascript">
    function call() {
        var msg = $('#formx').serialize();
        $.ajax({
            type: 'POST',
            url: 'res.php',
            data: msg,
            success: function (data) {
                $('#results').append(data);
                document.getElementById("textInput").value = "";
                $('body').scrollTop = 999999;
            },
            error: function (xhr, str) {
                <? $filename = 'res.php';
                if (file_exists($filename)) {
                    echo "alert('Возникла ошибка при отправке.');";
                } else {
                    echo "alert('Отсутствует файл res.php на сервере.');";
                }
                ?>
            }
        });
    }

        function show() {
            $.ajax({
                url: "session.php",
                cache: false,
                success: function (html) {
                    $("#session").html(html);
                }
            });
        }

    $(document).ready(function () {
        show();
        setInterval('show()', 5000);
    });

</script>
</body>
</html>