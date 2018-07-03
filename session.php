<?php session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
if ($_SESSION['bot_bitrix']) { ?>
    <i class="fa fa-check-circle" title="Пароль Done!" style="color:green; font-size: 20px;"></i>
<? } else { ?>
    <i class="fa fa-times-circle" title="Пароль не введен" style="color:red; font-size: 20px;"></i>
<? }

if (isset($_SESSION['SESS_AUTH']['AUTHORIZED'])) { ?>
    <i class="fa fa-check-circle" title="Вы авторизованы" style="color:green; font-size: 20px;"></i>
<? } else { ?>
    <i class="fa fa-times-circle" title="Вы не вошли" style="color:red; font-size: 20px;"></i>
<? }

global $USER;
if ($USER->IsAdmin()) { ?>
    <i class="fa fa-check-circle" title="Вы администратор" style="color:green; font-size: 20px;"></i>
<? } else { ?>
    <i class="fa fa-times-circle" title="Вы не администратор" style="color:red; font-size: 20px;"></i>
<? } ?>