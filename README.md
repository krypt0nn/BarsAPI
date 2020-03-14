# BarsAPI

**BarsAPI** - библиотека для работы с API электронного журнала "Барс.Web-Образование"

### Установка

```
php qero.phar i KRypt0nn/BarsAPI
```

```php
<?php

use BarsAPI\Bars;

require 'qero-packages/autoload.php';

// ...
```

> Qero можно посмотреть [здесь](https://github.com/KRypt0nn/Qero)

Для ручной установки необходимо распаковать библиотеку в удобное для Вас место и подключить файл ``BarsAPI.php``

### Авторизация

```php
<?php

use BarsAPI\Bars;

# Авторизация в журнале. Указать свой логин и пароль для входа
$api = new Bars ('логин', 'пароль');
```

### Информация об учащемся

```php
<?php

echo 'Ученик: '. $api->user->public_name . PHP_EOL;
echo 'Полное имя: '. $api->user->name . PHP_EOL;
echo 'Учебное заведение: '. $api->user->school . PHP_EOL;
echo 'ID ученика: '. $api->user->pupil_id;
```

### Получение расписания

```php
<?php

# Получить расписание за текущий день
$diary = $api->user->getDiary ();

# Расписание за вчерашний день
$diary = $api->user->getDiary (time () - 24 * 60 * 60);

# Расписание за текущую неделю
$diary = $api->user->getDiary (strtotime ('sunday this week'), strtotime ('monday this week'));
```

### Вывод расписания

```php
<?php

$diary->foreach (function ($day)
{
    echo 'Дата: '. $day->date . PHP_EOL;
    echo 'Уроки:'. PHP_EOL . PHP_EOL;

    $i = 0;

    $day->foreach (function ($lesson) use (&$i)
    {
        echo ++$i .') '. $lesson->discipline . PHP_EOL;

        $space = str_repeat (' ', strlen ($i) + 2);

        echo $space .'Время: '. $lesson->begin_time .' - '. $lesson->end_time . PHP_EOL;
        echo $space .'Кабинет: '. $lesson->room . PHP_EOL;
        echo $space .'Учитель: '. $lesson->teacher . PHP_EOL;
        echo $space .'Тема: '. $lesson->subject . PHP_EOL;
        echo $space .'Оценки: '. implode (', ', array_map (fn ($mark) => $mark->mark, $lesson->marks)) . PHP_EOL;

        /*
        
            Вместо implode и array_map при выводе оценок доступен так же вариант
            с foreach от урока:

            $lesson->foreach (function ($mark)
            {
                echo $mark->mark .' ';
            });

            Однако в примере выше я всё же решил использовать
            более короткий код

        */

        echo PHP_EOL;
    });

    echo PHP_EOL;
});
```

Полную документацию по объектам проекта можно посмотреть в комментариях к коду

Автор: [Подвирный Никита](https://vk.com/technomindlp). Специально для [Enfesto Studio Group](https://vk.com/hphp_convertation)

Отдельная благодарность автору [данного репозитория](https://github.com/crinny/bars) за неоценимую помощь в создании этой библиотеки