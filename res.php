<?php session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
require_once('const.php');
if ($_POST["say"] == "-") { //Зарпетить общение
    unset($_SESSION['bot_bitrix']);
    $msg .= "<script type='text/javascript'> document.getElementById('results').innerHTML = '';</script>";
}
if ((time() - $_SESSION['timeBot']) < $timeMsg) { //Зарпетить быструю отправку ?>
    <div class="media text-muted pt-3">
        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
            <strong class="d-block text-gray-dark">Бутрикс</strong>
            Не так быстро. Прошло только <?=abs(time() - $_SESSION['timeBot']);?>s. из <?=$timeMsg?>s.
        </p>
    </div>
    <?
    exit;
}
$_SESSION['timeBot'] = time(); //Время отправки
?>

    <div class="media text-muted pt-3">
        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
            <strong class="d-block text-gray-dark"><? if ($_SESSION['bot_bitrix'] != 1) {
                    echo "Отправитель";
                }else {
                    echo $user;
                } ?></strong>
            <? if ($_SESSION['bot_bitrix'] != 1) {
                echo "Скрыто";
            }else {
                echo $_POST["say"];
            } ?>
        </p>
    </div>
<?php
if ($_SESSION['bot_bitrix'] == 1) { //Проверка доступа к боту
    global $USER;
    if (isset($_SESSION['SESS_AUTH']['AUTHORIZED'])) {
        if ($USER->IsAdmin()) {
            $match = [
                "infoblocks_all" => ["/Инфоблоки/iu"],
                "infoblock" => ["/Инфоблок[ #№]*([0-9]+)/iu", "/ИБ[ #№]*([0-9]+)/iu"],
                "update_infoblock" => ["/Инфоблок Изменить[ #№]*([0-9]+)/iu"],
                "users" => ["/Пользователи/iu", "/Юзеры/iu"],
                "user_one" => ["/Пользователь[ #№]*([0-9]+)/iu", "/Юзер[ #№]*([0-9]+)/iu"],
                "forms" => ["/Формы/iu"],
                "forms_result" => ["/Результаты[ #№]*([0-9]+)/iu"],
                "admin" => ["/Админ/iu"],
                "login_id" => ["/Вход[ #№]*([0-9]+)/iu"],
                "exit" => ["/Выход/iu"],
                "hello" => ["/Привет/iu"],
                "bye" => ["/Пока/iu"],
                "clear" => ["/Отчистка/iu", "/cls/iu"],
                "php" => ["/Консоль/iu"],
                "mail" => ["/Почта/iu"],
                "table" => ["/Таблицы/iu"],
                "dump" => ["/Копии/iu"],
                "event" => ["/event/iu", "/Ивент/iu"],
                "update_mail" => ["/Почтовый шаблон[ #№]*([0-9]+)/iu"],
                "migrato" => ["/Migrato/iu"],
                "width" => ["/Ширина[ #№]*([0-9]+)/iu"],
                "git_status" => ["/git status/iu"],
                "cd" => ["/cd/iu", "/Память/iu", "/full/iu", "/фул/iu"],
                "cpu_min" => ["/mcp/iu", "/мцп/iu", "/full/iu", "/фул/iu"],
                "cpu" => ["/cpu/iu", "/цпу/iu"],
                "agent" => ["/Агент/iu"],
                "cache" => ["/Часть Кеша/iu"],
                "cache_all" => ["/Весь кеш/iu", "/cache all/iu"],
                "test" => ["/test/iu", "/тест/iu"],
                "fix" => ["/fix/iu", "/исправить/iu"],
            ];
            $matches = array();
            $list = array();
            foreach ($match as $key => $mask) {
                foreach ($mask as $list_mask) {
                    if (preg_match($list_mask, $_POST['say'], $matches) === 1) {
                        $list[$key] = $matches[1];
                    }
                }
            }
            if (!CModule::IncludeModule("iblock")) {
                return;
            }
            foreach ($list as $key => $item) {
                switch ($key) {
                    case "infoblocks_all":
                        $_SESSION['timeBot'] = time() + 7;
                        $res = CIBlock::GetList(Array());
                        $msg .= " Все, готово. ";
                        ?>
                        <div class="media text-muted pt-3">
                            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                <strong class="d-block text-gray-dark">Бутрикс</strong>
                                Список инфоблоков
                            </p>
                        </div>
                        <? $id = rand(); ?>
                        <div id="<?=$id?>">
                            <div class="btn-group  close_frame" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary" onclick="document.getElementById('<?=$id?>').innerHTML = ''">
                                    <i class="fa fa-times" aria-hidden="true"></i></button>
                                <? $id = rand(); ?>
                                <button type="button" class="btn btn-primary" title="Список инфоблоков" onclick="document.getElementById('<?=$id?>').style.display = (document.getElementById('<?=$id?>').style.display == 'none')? 'block': 'none'">
                                    <i class="fa fa-window-maximize" aria-hidden="true"></i></button>
                            </div>
                            <div id="<?=$id?>">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Название</th>
                                        <th scope="col">Код</th>
                                        <th scope="col">Активность</th>
                                        <th scope="col">Сортировка</th>
                                        <th scope="col">Название раздела</th>
                                        <th scope="col">Раздел</th>
                                        <th scope="col">LID</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? while ($ar_res = $res->Fetch()) { ?>
                                        <tr>
                                            <th scope="row"><?=$ar_res['ID'];?></th>
                                            <td><?=$ar_res['NAME'];?></td>
                                            <td><?=$ar_res['CODE'];?></td>
                                            <td><?=$ar_res['ACTIVE'];?></td>
                                            <td><?=$ar_res['SORT'];?></td>
                                            <td><?=$ar_res['SECTIONS_NAME'];?></td>
                                            <td><?=$ar_res['IBLOCK_TYPE_ID'];?></td>
                                            <td><?=$ar_res['LID'];?></td>
                                        </tr>
                                    <? } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?
                        break;
                    case "infoblock":
                        $cursor = CIBlock::GetByID($item);
                        $arSelect = $cursor->Fetch();
                        if ($arSelect) {
                            $id = rand(); ?>
                            <div id="<?=$id?>">
                                <div class="btn-group  close_frame" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-primary" onclick="document.getElementById('<?=$id?>').innerHTML = ''">
                                        <i class="fa fa-times" aria-hidden="true"></i></button>
                                    <? $id = rand(); ?>
                                    <button type="button" class="btn btn-primary" title="Инфоблок №<?=$item?>" onclick="document.getElementById('<?=$id?>').style.display = (document.getElementById('<?=$id?>').style.display == 'none')? 'block': 'none'">
                                        <i class="fa fa-window-maximize" aria-hidden="true"></i></button>
                                </div>
                                <div id="<?=$id?>">
                                    <iframe class="table table-hover update_ibl" frameborder="0" src="<?="/bitrix/admin/iblock_element_admin.php?IBLOCK_ID=" . $item . "&type=Content" . "&type=" . $arSelect["IBLOCK_TYPE_ID"]?>">
                                        Ваш браузер не поддерживает данную функцию.
                                        <a href="<?="/bitrix/admin/iblock_element_admin.php?IBLOCK_ID=" . $item . "&type=Content" . "&type=" . $arSelect["IBLOCK_TYPE_ID"]?>" target="_blank">Открыть в отдельном окне?</a>
                                    </iframe>
                                </div>
                            </div>
                            <?
                            $msg .= " Открываю инфоблок №" . $item;
                        }else {
                            $msg .= " Инфоблока с таким id не существует.";
                        }
                        break;
                    case "update_infoblock":
                        $cursor = CIBlock::GetByID($item);
                        $arSelect = $cursor->Fetch();
                        if ($arSelect) {
                            $id = rand(); ?>
                            <div id="<?=$id?>">
                                <div class="btn-group  close_frame" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-primary" onclick="document.getElementById('<?=$id?>').innerHTML = ''">
                                        <i class="fa fa-times" aria-hidden="true"></i></button>
                                    <? $id = rand(); ?>
                                    <button type="button" class="btn btn-primary" title="Редактирование инфоблока №<?=$item?>" onclick="document.getElementById('<?=$id?>').style.display = (document.getElementById('<?=$id?>').style.display == 'none')? 'block': 'none'">
                                        <i class="fa fa-window-maximize" aria-hidden="true"></i></button>
                                </div>
                                <div id="<?=$id?>">
                                    <iframe class="table table-hover update_ibl" frameborder="0" src="/bitrix/admin/iblock_edit.php?type=<?=$arSelect["IBLOCK_TYPE_ID"]?>&ID=<?=$item?>">
                                        Ваш браузер не поддерживает данную функцию.
                                        <a href="/bitrix/admin/iblock_edit.php?type=<?=$arSelect["IBLOCK_TYPE_ID"]?>&ID=<?=$item?>" target="_blank">Открыть в отдельном окне?</a>
                                    </iframe>
                                </div>
                            </div>
                            <?
                            $msg .= " Открываю редактирование инфоблока №" . $item;
                        }else {
                            $msg .= " Инфоблока с таким id не существует.";
                        }
                        break;
                    case "users":
                        $order = array('sort' => 'asc');
                        $tmp = 'sort'; // параметр проигнорируется методом, но обязан быть
                        $cursor = CUser::GetList($order, $tmp);
                        $msg .= " Готово. ";
                        ?>
                        <div class="media text-muted pt-3">
                            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                <strong class="d-block text-gray-dark">Бутрикс</strong>
                                Список пользователей
                            </p>
                        </div>
                        <? $id = rand(); ?>
                        <div id="<?=$id?>">
                            <div class="btn-group  close_frame" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary" onclick="document.getElementById('<?=$id?>').innerHTML = ''">
                                    <i class="fa fa-times" aria-hidden="true"></i></button>
                                <? $id = rand(); ?>
                                <button type="button" class="btn btn-primary" title="Пользователи" onclick="document.getElementById('<?=$id?>').style.display = (document.getElementById('<?=$id?>').style.display == 'none')? 'block': 'none'">
                                    <i class="fa fa-window-maximize" aria-hidden="true"></i></button>
                            </div>
                            <div id="<?=$id?>">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Имя Фамилия</th>
                                        <th scope="col">Email</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? while ($rsUsers = $cursor->Fetch()) { ?>
                                        <tr>
                                            <th scope="row"><?=$rsUsers['ID'];?></th>
                                            <td><?=$rsUsers['NAME'];?> <?=$rsUsers['LAST_NAME'];?></td>
                                            <td><?=$rsUsers['EMAIL'];?></td>
                                        </tr>
                                    <? } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?
                        break;
                    case "user_one":
                        $rsUser = CUser::GetByID($item);
                        $arUser = $rsUser->Fetch();
                        if ($arUser) { ?>
                            <div class="media text-muted pt-3">
                                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                    <strong class="d-block text-gray-dark">Бутрикс</strong>
                                    Отчет по пользователю с ID <?=$arUser['ID']?>
                                </p>
                            </div>
                            <? $id = rand(); ?>
                            <div id="<?=$id?>">
                                <div class="btn-group  close_frame" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-primary" onclick="document.getElementById('<?=$id?>').innerHTML = ''">
                                        <i class="fa fa-times" aria-hidden="true"></i></button>
                                    <? $id = rand(); ?>
                                    <button type="button" class="btn btn-primary" title="Пользователь №<?=$item?>" onclick="document.getElementById('<?=$id?>').style.display = (document.getElementById('<?=$id?>').style.display == 'none')? 'block': 'none'">
                                        <i class="fa fa-window-maximize" aria-hidden="true"></i></button>
                                </div>
                                <div id="<?=$id?>">
                                    <div class="card">
                                        <div class="card-body">
                                            <ul class="list-group list-group-flush">
                                                <? foreach ($arUser as $key => $item) { ?>
                                                    <? if ($key == "PASSWORD" || $key == "CHECKWORD") { ?>
                                                        <li class="list-group-item">Скрытый параметр</li>
                                                    <? }else { ?>
                                                        <li class="list-group-item"><?=$key?>: <?=$item?></li>
                                                    <? }
                                                } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?
                            $msg .= " Готово. ";
                        }else {
                            $msg .= " Пользователя с таким id не существует.";
                        }
                        break;
                    case "login_id":
                        $rsUser = CUser::GetByID($item);
                        $arUser = $rsUser->Fetch();
                        if ($arUser) {
                            $USER->Authorize($item);
                            $msg .= " Готово. Вы авторизовались под пользователем №$item ";
                        }else {
                            $msg .= " Пользователя с таким id не существует.";
                        }
                        break;
                    case "admin":
                        $id = rand(); ?>
                        <div id="<?=$id?>">
                            <div class="btn-group  close_frame" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary" onclick="document.getElementById('<?=$id?>').innerHTML = ''">
                                    <i class="fa fa-times" aria-hidden="true"></i></button>
                                <? $id = rand(); ?>
                                <button type="button" class="btn btn-primary" title="Административная панель" onclick="document.getElementById('<?=$id?>').style.display = (document.getElementById('<?=$id?>').style.display == 'none')? 'block': 'none'">
                                    <i class="fa fa-window-maximize" aria-hidden="true"></i></button>
                            </div>
                            <div id="<?=$id?>">
                                <iframe class="table table-hover update_ibl" frameborder="0" src="/bitrix/admin/">
                                    Ваш браузер не поддерживает данную функцию.
                                    <a href="/bitrix/admin/" target="_blank">Открыть в отдельном окне?</a>
                                </iframe>
                            </div>
                        </div>
                        <? $msg .= " Открыто. "; ?>
                        <? break;
                    case "php":
                        $id = rand(); ?>
                        <div id="<?=$id?>">
                            <div class="btn-group  close_frame" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary" onclick="document.getElementById('<?=$id?>').innerHTML = ''">
                                    <i class="fa fa-times" aria-hidden="true"></i></button>
                                <? $id = rand(); ?>
                                <button type="button" class="btn btn-primary" title="PHP Консоль" onclick="document.getElementById('<?=$id?>').style.display = (document.getElementById('<?=$id?>').style.display == 'none')? 'block': 'none'">
                                    <i class="fa fa-window-maximize" aria-hidden="true"></i></button>
                            </div>
                            <div id="<?=$id?>">
                                <iframe class="table table-hover update_ibl" frameborder="0" src="/bitrix/admin/php_command_line.php">
                                    Ваш браузер не поддерживает данную функцию.
                                    <a href=/bitrix/admin/php_command_line.php" target="_blank">Открыть в отдельном окне?</a>
                                </iframe>
                            </div>
                        </div>
                        <? $msg .= " Консоль готова. "; ?>
                        <? break;
                    case "table":
                        $id = rand(); ?>
                        <div id="<?=$id?>">
                            <div class="btn-group  close_frame" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary" onclick="document.getElementById('<?=$id?>').innerHTML = ''">
                                    <i class="fa fa-times" aria-hidden="true"></i></button>
                                <? $id = rand(); ?>
                                <button type="button" class="btn btn-primary" title="Таблицы" onclick="document.getElementById('<?=$id?>').style.display = (document.getElementById('<?=$id?>').style.display == 'none')? 'block': 'none'">
                                    <i class="fa fa-window-maximize" aria-hidden="true"></i></button>
                            </div>
                            <div id="<?=$id?>">
                                <iframe class="table table-hover update_ibl" frameborder="0" src="/bitrix/admin/perfmon_tables.php">
                                    Ваш браузер не поддерживает данную функцию.
                                    <a href=/bitrix/admin/perfmon_tables.php" target="_blank">Открыть в отдельном окне?</a>
                                </iframe>
                            </div>
                        </div>
                        <? $msg .= " Нашли таблицы, открываем. "; ?>
                        <? break;
                    case "event":
                        $id = rand(); ?>
                        <div id="<?=$id?>">
                            <div class="btn-group  close_frame" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary" onclick="document.getElementById('<?=$id?>').innerHTML = ''">
                                    <i class="fa fa-times" aria-hidden="true"></i></button>
                                <? $id = rand(); ?>
                                <button type="button" class="btn btn-primary" title="Таблица b_event" onclick="document.getElementById('<?=$id?>').style.display = (document.getElementById('<?=$id?>').style.display == 'none')? 'block': 'none'">
                                    <i class="fa fa-window-maximize" aria-hidden="true"></i></button>
                            </div>
                            <div id="<?=$id?>">
                                <iframe class="table table-hover update_ibl" frameborder="0" src="/bitrix/admin/perfmon_table.php?PAGEN_1=1&SIZEN_1=20&lang=ru&table_name=b_event&by=ID&order=desc">
                                    Ваш браузер не поддерживает данную функцию.
                                    <a href=/bitrix/admin/perfmon_table.php?PAGEN_1=1&SIZEN_1=20&lang=ru&table_name=b_event&by=ID&order=desc" target="_blank">Открыть в отдельном окне?</a>
                                </iframe>
                            </div>
                        </div>
                        <? $msg .= " Нашли таблицу, открываем. "; ?>
                        <? break;
                    case "forms":
                        CModule::IncludeModule('form');
                        $rsForms = CForm::GetList($by = "s_id", $order = "desc", false, $is_filtered);
                        $msg .= " Отлично, мы нашли формы. ";
                        ?>
                        <div class="media text-muted pt-3">
                            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                <strong class="d-block text-gray-dark">Бутрикс</strong>
                                Список Форм
                            </p>
                        </div>
                        <? $id = rand(); ?>
                        <div id="<?=$id?>">
                            <div class="btn-group  close_frame" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary" onclick="document.getElementById('<?=$id?>').innerHTML = ''">
                                    <i class="fa fa-times" aria-hidden="true"></i></button>
                                <? $id = rand(); ?>
                                <button type="button" class="btn btn-primary" title="Формы" onclick="document.getElementById('<?=$id?>').style.display = (document.getElementById('<?=$id?>').style.display == 'none')? 'block': 'none'">
                                    <i class="fa fa-window-maximize" aria-hidden="true"></i></button>
                            </div>
                            <div id="<?=$id?>">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Название</th>
                                        <th scope="col">Сортировка</th>
                                        <th scope="col">Капча</th>
                                        <th scope="col">Кнопка</th>
                                        <th scope="col">SID</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? while ($ar_res = $rsForms->Fetch()) { ?>
                                        <tr>
                                            <th scope="row"><?=$ar_res['ID'];?></th>
                                            <td><?=$ar_res['NAME'];?></td>
                                            <td><?=$ar_res['C_SORT'];?></td>
                                            <td><?=$ar_res['USE_CAPTCHA'];?></td>
                                            <td><?=$ar_res['BUTTON'];?></td>
                                            <td><?=$ar_res['SID'];?></td>
                                        </tr>
                                    <? } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?
                        break;
                    case "forms_result":
                        CModule::IncludeModule('form');
                        $rsForms = CFormResult::GetList($item);
                        $serchrsForm = CForm::GetByID($item);
                        $sercharForm = $serchrsForm->Fetch();
                        if ($sercharForm) {
                            $msg .= " Ответы на форму готовы. ";
                            ?>
                            <div class="media text-muted pt-3">
                                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                    <strong class="d-block text-gray-dark">Бутрикс</strong>
                                    Список ответов на форму №<?=$item?>
                                </p>
                            </div>
                            <? $id = rand(); ?>
                            <div id="<?=$id?>">
                                <div class="btn-group  close_frame" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-primary" onclick="document.getElementById('<?=$id?>').innerHTML = ''">
                                        <i class="fa fa-times" aria-hidden="true"></i></button>
                                    <? $id = rand(); ?>
                                    <button type="button" class="btn btn-primary" title="Результаты №<?=$item?>" onclick="document.getElementById('<?=$id?>').style.display = (document.getElementById('<?=$id?>').style.display == 'none')? 'block': 'none'">
                                        <i class="fa fa-window-maximize" aria-hidden="true"></i></button>
                                </div>
                                <div id="<?=$id?>">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Пользователь</th>
                                            <th scope="col">USER_AUTH</th>
                                            <th scope="col">Дата отправки</th>
                                            <th scope="col">Результат</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <? while ($ar_res = $rsForms->Fetch()) { ?>
                                            <tr>
                                                <th scope="row"><?=$ar_res['ID'];?></th>
                                                <td><?=$ar_res['USER_ID'];?></td>
                                                <td><?=$ar_res['USER_AUTH'];?></td>
                                                <td><?=$ar_res['DATE_CREATE'];?></td>
                                                <td>
                                                    <a href="/bitrix/admin/form_result_edit.php?WEB_FORM_ID=<?=$item?>&RESULT_ID=<?=$ar_res['ID'];?>" target="_blank">Подробнее</a>
                                                </td>
                                            </tr>
                                        <? } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        <? }else { ?>
                            <? $msg .= " Формы с таким ID не существует ";
                        }
                        break;
                    case "mail":
                        CModule::IncludeModule("EventMessage");
                        $rsForms = CEventMessage::GetList($order = "asc");
                        $msg .= " Отлично, мы нашли почтовые шаблоны. ";
                        ?>
                        <div class="media text-muted pt-3">
                            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                <strong class="d-block text-gray-dark">Бутрикс</strong>
                                Список почтовых шаблонов
                            </p>
                        </div>
                        <? $id = rand(); ?>
                        <div id="<?=$id?>">
                            <div class="btn-group  close_frame" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary" onclick="document.getElementById('<?=$id?>').innerHTML = ''">
                                    <i class="fa fa-times" aria-hidden="true"></i></button>
                                <? $id = rand(); ?>
                                <button type="button" class="btn btn-primary" title="Почтовые шаблоны" onclick="document.getElementById('<?=$id?>').style.display = (document.getElementById('<?=$id?>').style.display == 'none')? 'block': 'none'">
                                    <i class="fa fa-window-maximize" aria-hidden="true"></i></button>
                            </div>
                            <div id="<?=$id?>">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">EVENT_NAME</th>
                                        <th scope="col">Активность</th>
                                        <th scope="col">Сайт</th>
                                        <th scope="col">Тип почтового события</th>
                                        <th scope="col">От</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? while ($ar_res = $rsForms->Fetch()) { ?>
                                        <tr>
                                            <th scope="row"><?=$ar_res['ID'];?></th>
                                            <td><?=$ar_res['EVENT_NAME'];?></td>
                                            <td><?=$ar_res['ACTIVE'];?></td>
                                            <td><?=$ar_res['LID'];?></td>
                                            <td>[<?=$ar_res['EVENT_NAME'];?>] <?=$ar_res['SUBJECT'];?></td>
                                            <td><?=$ar_res['EMAIL_FROM'];?></td>
                                        </tr>
                                    <? } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?
                        break;
                    case "update_mail":
                        CModule::IncludeModule("EventMessage");
                        $cursor = CEventMessage::GetByID($item);
                        $arSelect = $cursor->Fetch();
                        if ($arSelect) {
                            $id = rand(); ?>
                            <div id="<?=$id?>">
                                <div class="btn-group  close_frame" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-primary" onclick="document.getElementById('<?=$id?>').innerHTML = ''">
                                        <i class="fa fa-times" aria-hidden="true"></i></button>
                                    <? $id = rand(); ?>
                                    <button type="button" class="btn btn-primary" title="Редактирование почтового шаблона №<?=$item?>" onclick="document.getElementById('<?=$id?>').style.display = (document.getElementById('<?=$id?>').style.display == 'none')? 'block': 'none'">
                                        <i class="fa fa-window-maximize" aria-hidden="true"></i></button>
                                </div>
                                <div id="<?=$id?>">
                                    <iframe class="table table-hover update_ibl" frameborder="0" src="/bitrix/admin/message_edit.php?&ID=<?=$item?>">
                                        Ваш браузер не поддерживает данную функцию.
                                        <a href="/bitrix/admin/message_edit.php?ID=<?=$item?>" target="_blank">Открыть в отдельном окне?</a>
                                    </iframe>
                                </div>
                            </div>
                            <?
                            $msg .= " Открываю редактирование почтового шаблона №" . $item;
                        }else {
                            $msg .= " Почтового шаблона с таким id не существует.";
                        }
                        break;
                    case "dump":
                        $id = rand(); ?>
                        <div id="<?=$id?>">
                            <div class="btn-group  close_frame" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary" onclick="document.getElementById('<?=$id?>').innerHTML = ''">
                                    <i class="fa fa-times" aria-hidden="true"></i></button>
                                <? $id = rand(); ?>
                                <button type="button" class="btn btn-primary" title="Резервные копии" onclick="document.getElementById('<?=$id?>').style.display = (document.getElementById('<?=$id?>').style.display == 'none')? 'block': 'none'">
                                    <i class="fa fa-window-maximize" aria-hidden="true"></i></button>
                            </div>
                            <div id="<?=$id?>">
                                <iframe class="table table-hover update_ibl" frameborder="0" src="/bitrix/admin/dump_list.php">
                                    Ваш браузер не поддерживает данную функцию.
                                    <a href="/bitrix/admin/dump_list.php" target="_blank">Открыть в отдельном окне?</a>
                                </iframe>
                            </div>
                        </div>
                        <? $msg .= " Показываю список резервных копий. "; ?>
                        <? break;
                    case "agent":
                        $id = rand(); ?>
                        <div id="<?=$id?>">
                            <div class="btn-group  close_frame" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary" onclick="document.getElementById('<?=$id?>').innerHTML = ''">
                                    <i class="fa fa-times" aria-hidden="true"></i></button>
                                <? $id = rand(); ?>
                                <button type="button" class="btn btn-primary" title="Агенты" onclick="document.getElementById('<?=$id?>').style.display = (document.getElementById('<?=$id?>').style.display == 'none')? 'block': 'none'">
                                    <i class="fa fa-window-maximize" aria-hidden="true"></i></button>
                            </div>
                            <div id="<?=$id?>">
                                <iframe class="table table-hover update_ibl" frameborder="0" src="/bitrix/admin/agent_list.php">
                                    Ваш браузер не поддерживает данную функцию.
                                    <a href="/bitrix/admin/agent_list.php" target="_blank">Открыть в отдельном окне?</a>
                                </iframe>
                            </div>
                        </div>
                        <? $msg .= "АААААААГенты!"; ?>
                        <? break;
                    case "exit":
                        $USER->Logout();
                        $msg .= " Вы вышли из системы. <a href=\"login.php\" target=\"_blank\">Случайно?</a>";
                        ?>
                        <? break;
                    case "cache":
                        if (BXClearCache(false)) {
                            $msg .= " Часть устаревшего кеша удалена.";
                        }else {
                            $msg .= " Проблемы с удалением кеша.";
                        }
                        break;
                    case "cache_all":
                        if (BXClearCache(true)) {
                            $msg .= " Весь кеш удален.";
                        }else {
                            $msg .= " Проблемы с удалением кеша.";
                        }
                        break;
                    case "hello":
                        $msg .= " Я рад Вас видеть $user.";
                        break;
                    case "bye":
                        $msg .= " До свидания $user. Я буду Вас ждать.";
                        $msg .= " <br>Доступ прекращен.";
                        unset($_SESSION['bot_bitrix']);
                        break;
                    case "clear":
                        $msg .= "<script type='text/javascript'> document.getElementById('results').innerHTML = '';</script>";
                        break;
                    case "test":
                        $error_sys = 0; //Ошибки
                        ?>
                        <div class="media text-muted pt-3">
                            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                <strong class="d-block text-gray-dark">Бутрикс</strong>
                                Начинаю тестирование системы. <br/><br/>
                                <?
                                foreach ($files as $file) {
                                    if (file_exists($file)) {
                                        echo "<span style='color:green;'>Done!</span> $file<br/>";
                                    }else {
                                        echo "<span style='color:red;'>Error!</span> $file<br/>";
                                        $error_sys++;
                                    }
                                }
                                ?>
                            </p>
                        </div>
                        <?
                        if ($error_sys > 0) {
                            $msg .= " Проверка завершена. Найдено $error_sys проблем, рекомендуем начать исправление. <br/> Для этого напишите fix или исправить.";
                        }else {
                            $msg .= " Проверка завершена.";
                        }
                        break;
                    case "fix": ?>
                        <div class="media text-muted pt-3">
                            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                <strong class="d-block text-gray-dark">Бутрикс</strong>
                                Начинаю исправлять ошибки. <br/><br/>
                                <?
                                $_SESSION['timeBot'] = time() + 10;
                                $newfile = 'load.zip';
                                if (!copy($file_git, $newfile)) {
                                    $msg .= "Не удалось скачать файлы с Git\n";
                                }else {
                                    $zip = new ZipArchive(); //Создаём объект для работы с ZIP-архивами
                                    //Открываем архив archive.zip и делаем проверку успешности открытия
                                    if ($zip->open("load.zip") === true) {
                                        $zip->extractTo("fix/"); //Извлекаем файлы в указанную директорию
                                        $zip->close(); //Завершаем работу с архивом
                                        unlink('load.zip');
                                    }else {
                                        $msg .= "Ошибка изменения, архива не существует."; //Выводим уведомление об ошибке
                                        break;
                                    }
                                    foreach ($files as $file) {
                                        if (!file_exists($file)) {
                                            $old_name = 'fix/botrix-master/' . $file;
                                            if (!is_dir('js')) {
                                                mkdir('js');
                                            }
                                            if (!is_dir('css')) {
                                                mkdir('css');
                                            }
                                            if (rename($old_name, $file)) {
                                                $msg .= "<span style='color:green;'>Done!</span> $file<br/>";
                                            }else {
                                                $msg .= "<span style='color:red;'>Error!</span> $file<br/>";
                                            }
                                        }
                                    }
                                    removeDirectory('fix');
                                }
                                ?>
                            </p>
                        </div>
                        <?
                            $msg .= " Проект восстановлен из GitHub. Перезагрузите страницу.";
                        break;
                    case "width":
                        if ($item < 600) {
                            $msg .= "<style>.container { max-width:600px }</style>";
                            $_SESSION['width'] = 600;
                            $msg .= "Ширина задана 600px";
                        }else {
                            $msg .= "<style>.container { max-width:" . $item . "px }</style>";
                            $_SESSION['width'] = $item;
                            $msg .= "Ширина задана";
                        }
                        break;
                    case "git_status":
                        ob_start();
                        system("git status");
                        $result = ob_get_contents();
                        ob_end_clean();
                        $id = rand(); ?>
                        <div id="<?=$id?>">
                            <div class="btn-group  close_frame" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary" onclick="document.getElementById('<?=$id?>').innerHTML = ''">
                                    <i class="fa fa-times" aria-hidden="true"></i></button>
                                <? $id = rand(); ?>
                                <button type="button" class="btn btn-primary" title="git status" onclick="document.getElementById('<?=$id?>').style.display = (document.getElementById('<?=$id?>').style.display == 'none')? 'block': 'none'">
                                    <i class="fa fa-window-maximize" aria-hidden="true"></i></button>
                            </div>
                            <div id="<?=$id?>">
                                <div class="card">
                                    <div class="card-body">
                                        <?
                                        echo '<pre>' . $result . '</pre>'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <? $msg .= "Выполнили команду git status";
                        break;
                    case "cd":
                        ob_start();
                        system("df -h");
                        $result = ob_get_contents();
                        ob_end_clean();
                        $arrayLine = array();
                        $arrayLine = explode(PHP_EOL, $result);
                        for ($i = 0; $i < count($arrayLine) - 1; $i++) {
                            $arrayLine[$i] = explode(' ', trim(preg_replace('/\s+/', ' ', $arrayLine[$i])));
                        }
                        $data = array();
                        for ($i = 1; $i < count($arrayLine) - 1; $i++) {
                            for ($j = 0; $j < count($arrayLine[$i]); $j++) {
                                $data[$i][$arrayLine[0][$j]] = $arrayLine[$i][$j];
                            }
                        } ?>
                        <? $id = rand(); ?>
                        <div id="<?=$id?>">
                            <br/>
                            <div class="row">
                                <div class="btn-group  close_frame" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-primary" onclick="document.getElementById('<?=$id?>').innerHTML = ''">
                                        <i class="fa fa-times" aria-hidden="true"></i></button>
                                    <? $id = rand(); ?>
                                </div>
                                <? foreach ($data as $rsResult) { ?>
                                    <? $id = generate(8);
                                    $rsResult['Use%'] = str_replace("%", "", $rsResult['Use%']);
                                    ?>
                                    <div class="col-sm">
                                        <div class="card" style="width: 18rem;">
                                            <div class="card-body">
                                                <div class="box">
                                                    <div class="col">
                                                        <div data-preset="circle" class="ldBar label-center" id="<?=$id?>" style="width: 100%;height: 160px;"></div>
                                                    </div>
                                                    <br/>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">Cистема
                                                            <span class="badge badge-primary"><?=$rsResult['Filesystem']?></span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">Размер
                                                            <span class="badge badge-primary"><?=$rsResult['Size']?></span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">Занято
                                                            <span class="badge badge-primary"><?=$rsResult['Used']?></span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">Свободно
                                                            <span class="badge badge-primary"><?=$rsResult['Avail']?></span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">Прикреплен
                                                            <span class="badge badge-primary"><?=$rsResult['Mounted']?></span>
                                                        </li>
                                                    </ul>
                                                    <script>
                                                        var bar1 = new ldBar("#<?=$id?>");
                                                        bar1.set(<?=$rsResult['Use%']?>);
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                        <?
                        $msg .= "Выполнили команду df -h";
                        break;
                    case "cpu":
                        $msg .= "Отчет готов";
                        ob_start();
                        system("ps -Ao pcpu,pmem,comm,pid,gid,lwp,rss,user,vsize,priority --sort=-pcpu | head -n 26");
                        $result = ob_get_contents();
                        ob_end_clean();
                        $arrayLine = array();
                        $arrayLine = explode(PHP_EOL, $result);
                        for ($i = 0; $i < count($arrayLine); $i++) {
                            $arrayLine[$i] = explode(' ', trim(preg_replace('/\s+/', ' ', $arrayLine[$i])));
                        }
                        $data = array();
                        for ($i = 1; $i < count($arrayLine); $i++) {
                            for ($j = 0; $j < count($arrayLine[$i]); $j++) {
                                $data[$i][$arrayLine[0][$j]] = $arrayLine[$i][$j];
                            }
                        } ?>
                        <? $id = rand(); ?>
                        <div id="<?=$id?>">
                            <div class="btn-group  close_frame" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary" onclick="document.getElementById('<?=$id?>').innerHTML = ''">
                                    <i class="fa fa-times" aria-hidden="true"></i></button>
                                <? $id = rand(); ?>
                                <button type="button" class="btn btn-primary" title="CPU" onclick="document.getElementById('<?=$id?>').style.display = (document.getElementById('<?=$id?>').style.display == 'none')? 'block': 'none'">
                                    <i class="fa fa-window-maximize" aria-hidden="true"></i></button>
                            </div>
                            <div id="<?=$id?>">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col">%CPU</th>
                                        <th scope="col">%MEM</th>
                                        <th scope="col">COMMAND</th>
                                        <th scope="col">PID</th>
                                        <th scope="col">GID</th>
                                        <th scope="col">LWP</th>
                                        <th scope="col">RSS</th>
                                        <th scope="col">USER</th>
                                        <th scope="col">VSZ</th>
                                        <th scope="col">PRI</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? $percent = 0; ?>
                                    <? foreach ($data as $rsResult) { ?>
                                        <? $percent += $rsResult['%CPU']; ?>
                                        <tr>
                                            <th scope="row"><?=$rsResult['%CPU'];?></th>
                                            <td><?=$rsResult['%MEM'];?></td>
                                            <td><?=$rsResult['COMMAND'];?></td>
                                            <td><?=$rsResult['PID'];?></td>
                                            <td><?=$rsResult['GID'];?></td>
                                            <td><?=$rsResult['LWP'];?></td>
                                            <td><?=$rsResult['RSS'];?></td>
                                            <td><?=$rsResult['USER'];?></td>
                                            <td><?=$rsResult['VSZ'];?></td>
                                            <td><?=$rsResult['PRI'];?></td>
                                        </tr>
                                    <? } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?
                        break;
                    case "cpu_min":
                        $msg .= "Отчет готов";
                        ob_start();
                        system("ps -Ao pcpu,pmem,comm --sort=-pcpu | head -n 26");
                        $result = ob_get_contents();
                        ob_end_clean();
                        $arrayLine = array();
                        $arrayLine = explode(PHP_EOL, $result);
                        for ($i = 0; $i < count($arrayLine); $i++) {
                            $arrayLine[$i] = explode(' ', trim(preg_replace('/\s+/', ' ', $arrayLine[$i])));
                        }
                        $data = array();
                        for ($i = 1; $i < count($arrayLine); $i++) {
                            for ($j = 0; $j < count($arrayLine[$i]); $j++) {
                                $data[$i][$arrayLine[0][$j]] = $arrayLine[$i][$j];
                            }
                        } ?>
                        <? $percent = 0; ?>
                        <? $percent_mem = 0; ?>
                        <? foreach ($data as $rsResult) { ?>
                        <? $percent += $rsResult['%CPU'];
                        $percent_mem += $rsResult['%MEM']; ?>
                        <? $id = rand(); ?>
                    <? } ?>
                        <div id="<?=$id?>">
                            <div class="btn-group  close_frame" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary" onclick="document.getElementById('<?=$id?>').innerHTML = ''">
                                    <i class="fa fa-times" aria-hidden="true"></i></button>
                                <? $id = rand(); ?>
                            </div>
                            <br/>
                            <h3>CPU</h3>
                            <? if ($percent > 50 && $percent <= 80) { ?>
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>Нагрузка <?=$percent?>%</strong> Посмотрите полный отчет! CPU или ЦПУ
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" aria-valuenow="<?=$percent;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$percent;?>%"><?=$percent;?></div>
                                </div>
                            <? }elseif ($percent > 80) { ?>
                                <div class="alert alert-danger alert-danger fade show" role="alert">
                                    <strong>Нагрузка <?=$percent?>%</strong> Сервер под серьезной нагрузкой. Посмотрите полный отчет! CPU или ЦПУ
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="<?=$percent;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$percent;?>%"><?=$percent;?></div>
                                </div>
                            <? }else { ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Нагрузка <?=$percent?>%</strong> Все хорошо!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="<?=$percent;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$percent;?>%"><?=$percent;?></div>
                                </div>
                            <? } ?>

                            <h3>MEMORY</h3>
                            <? if ($percent_mem > 50 && $percent <= 80) { ?>
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>Нагрузка <?=$percent_mem?>%</strong> Посмотрите полный отчет! CPU или ЦПУ
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" aria-valuenow="<?=$percent_mem;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$percent_mem;?>%"><?=$percent_mem;?></div>
                                </div>
                            <? }elseif ($percent_mem > 80) { ?>
                                <div class="alert alert-danger alert-danger fade show" role="alert">
                                    <strong>Нагрузка <?=$percent_mem?>%</strong> Сервер под серьезной нагрузкой. Посмотрите полный отчет! CPU или ЦПУ
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="<?=$percent_mem;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$percent_mem;?>%"><?=$percent_mem;?></div>
                                </div>
                            <? }else { ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Нагрузка <?=$percent_mem?>%</strong> Все хорошо!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="<?=$percent_mem;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$percent_mem;?>%"><?=$percent_mem;?></div>
                                </div>
                            <? } ?>
                        </div>
                        <?
                        break;
                }
            }
        }else {
            $msg .= " Для Вас закрыт доступ. <a href=\"login.php\" target=\"_blank\">Хотите авторизоваться за администратора?</a>";
        }
    }else {
        $msg .= " Вы не аторизированы <a href=\"login.php\" target=\"_blank\">Хотите авторизоваться?</a>";
    }
}else {
    if ($_POST["say"] == "root") {
        $_SESSION['bot_bitrix'] = 1;
        $msg = " Доступ открыт.<br>Добро пожаловать " . $user . ", я рад Вас видеть";
    }else {
        $msg .= " Доступ запрещен. Бот под паролем, введите пароль.";
        unset($_SESSION['bot_bitrix']);
    }
}
?>

    <div class="media text-muted pt-3">
        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
            <strong class="d-block text-gray-dark">Бутрикс</strong>
            <? if (isset($msg)) {
                if ($_POST['say'] == $pass) {
                    $_POST['say'] = "Скрыто";
                }
                echo $msg;
                $fp = fopen("log.txt", "a"); // Открываем файл в режиме записи
                $test = fwrite($fp,
                    "-YES Ответ получен " . $_SERVER['REMOTE_ADDR'] . " " . date("d.m.Y H:i:s") . " Ввели: " . $_POST['say'] . " Ответ: " . $msg . "\r\n"); // Запись в файл
                fclose($fp); //Закрытие файла
            }else {
                if ($_POST['say'] == $pass) {
                    $_POST['say'] = "Скрыто";
                }
                $f_contents = file("error.txt");
                $stroka = rand(0, count($f_contents) - 1);
                $line = $f_contents[$stroka];
                echo $line;
                $fp = fopen("log.txt", "a"); // Открываем файл в режиме записи
                $test = fwrite($fp,
                    "-NO Ответ не получен " . $_SERVER['REMOTE_ADDR'] . " " . date("d.m.Y H:i:s") . " Ввели: " . $_POST['say'] . " Ответ: " . $line . "\r\n"); // Запись в файл
                fclose($fp); //Закрытие файла
            } ?>
            <script>
                $(document).ready(function () {
                    $('html, body').animate({scrollTop: $(document).height()}, 'slow');
                    return false;
                });
            </script>
        </p>
    </div>

<? function generate($length = 8)
{

    $chars = 'abdefhiknrstyzABDEFGHKNQRSTY';
    $numChars = strlen($chars);
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= substr($chars, rand(1, $numChars) - 1, 1);
    }

    return $string;
}

function removeDirectory($dir) {
    if ($objs = glob($dir."/*")) {
        foreach($objs as $obj) {
            is_dir($obj) ? removeDirectory($obj) : unlink($obj);
        }
    }
    rmdir($dir);
}