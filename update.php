<?php

require_once('version.php');

function Parse($p1, $p2, $p3)
{
    $num1 = strpos($p1, $p2);
    if ($num1 === false) {
        return 0;
    }
    $num2 = substr($p1, $num1);
    return strip_tags(substr($num2, 0, strpos($num2, $p3)));
}

$String = file_get_contents('https://github.com/nanotank25/botrix');
$update = Parse($String, '<a href="#version">', '</a>');

if ($update > $current) {
    echo "<h2>Внимание! Бот обновляется. Убедительно просим Вас не обновлять страницу в течении 20 секунд.</h2>";
    echo "Установка!<br/>";

    $newfile = 'install.zip';
    if (!copy($file_git, $newfile)) {
        $msg .= "Не удалось скачать файлы с Git. Обратитесь в Поддержку.<br/>";
    } else {
        $zip = new ZipArchive();
        if ($zip->open("install.zip") === true) {
            $zip->extractTo("install/");
            $zip->close();
            unlink('install.zip');
        } else {
            echo "Ошибка изменения, архива не существует. Обратитесь в Поддержку.<br/>";
        }
        $srcDir = dirname(__FILE__).'/install/botrix-master';
        $destDir = dirname(__FILE__);
        if (file_exists($destDir)) {
            if (is_dir($destDir)) {
                if (is_writable($destDir)) {
                    if ($handle = opendir($srcDir)) {
                        while (false !== ($file = readdir($handle))) {
                            rename($srcDir . '/' . $file, $destDir . '/' . $file);
                        }
                        closedir($handle);
                    }
                }
            }
        }
        rmdir('install/botrix-master');
        rmdir('install');
        unlink('README.md');
    }
    echo "Бот обновлен. Спасибо за то, что ипользуете службу обновления.<br/>";
}
?>