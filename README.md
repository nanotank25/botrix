# BotRix
Новая ступень в разработке Битрикс

Легкая установка!
Скопируйте код указанный ниже, и запустите его на сервере.
```php
echo "Установка!<br/>";
$file_git = 'https://github.com/nanotank25/botrix/archive/master.zip';
$newfile = 'install.zip';
if (!copy($file_git, $newfile)) {
    $msg .= "Не удалось скачать файлы с Git<br/>";
} else {
    $zip = new ZipArchive();
    if ($zip->open("install.zip") === true) {
        $zip->extractTo("install/");
        $zip->close();
        unlink('install.zip');
    } else {
        echo "Ошибка изменения, архива не существует.<br/>";
    }
    rename("install/botrix-master/", "botrix");
    rmdir('install');
}
echo "Спасибо за установку!<br/>";
```

Bot version: 1.1.[1530902190](#version)