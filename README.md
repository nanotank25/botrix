# BotRix
Всем известно, что [**«1С-Битрикс»**](https://www.1c-bitrix.ru) это компания которая занимает лидирующие позиции 
на российском рынке в области разработки систем управления веб-проектами и 
корпоративными порталами. В современном мире существует огромное количество 
организаций, которые занимаются разработкой для данного продукта. 
Такой разработкой занимается и компетентный веб-интегратор [**ИНТЕРВОЛГА**](https://www.intervolga.ru). 
Ранее был уже разработан бот для Битрикс систем и называется он Агент 700. 
Для его работы нужно использовать мессенджеры. Для работы напрямую с сайта был разработан еще один бот. 
Поприветствуйте Бутрикса, бот который изменит ваш взгляд на системы Битрикс.
***
Бутрикс очень удобен и функционален. Общайтесь с ним на родном и понятном для 
Вас языке. Вы можете сказать ему "Покажи, пожалуйста инфоблок №5". 
Сложно? Тогда "Инфоблок 5" или еще проще "ИБ 5". Бутрикс поймет Вас в любой ситуации. 
Полный список функционала читайте в [WIKI](https://github.com/nanotank25/botrix/wiki).
Гибкие настройки и высокий уровень безопасности. 
Настройте бота так как Вам угодно. Ждем Вас на [WIKI](https://github.com/nanotank25/botrix/wiki/%D0%9D%D0%B0%D1%81%D1%82%D1%80%D0%BE%D0%B9%D0%BA%D0%B0)! 
***
Мы заботимся о наших пользователях и поэтому 
мы предлагаем удобные виды установки Бутрикса.
* Через Git: `git clone https://github.com/nanotank25/botrix.git`
* Скачать архив: `https://github.com/nanotank25/botrix/archive/master.zip`
* Для быстрой установки на сервере скопируйте код ниже:

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
    unlink('README.md');
}
echo "Спасибо за установку!<br/>";
```
Данный код создаст папку Botrix в директории где запустили этот код.

Bot version: 1.1.[1533303759](#version)
