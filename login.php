<? require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

 $APPLICATION->IncludeComponent(
    "bitrix:system.auth.form",
    "loginBot",
    Array(
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "FORGOT_PASSWORD_URL" => "",
        "PROFILE_URL" => "",
        "REGISTER_URL" => "",
        "SHOW_ERRORS" => "N"
    )
);

if (isset($_SESSION['SESS_AUTH']['AUTHORIZED']) && $USER->IsAdmin()) {?>
    <script>window.close();</script>
<? } ?>

