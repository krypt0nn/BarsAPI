<?php

/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * @package     BarsAPI
 * @copyright   2020 Podvirnyy Nikita (Observer KRypt0n_)
 * @license     GNU GPLv3 <https://www.gnu.org/licenses/gpl-3.0.html>
 * @author      Podvirnyy Nikita (Observer KRypt0n_)
 * 
 * Contacts:
 *
 * Email: <suimin.tu.mu.ga.mi@gmail.com>
 * VK:    <https://vk.com/technomindlp>
 *        <https://vk.com/hphp_convertation>
 * 
 * ----------
 * 
 * Special thanks to https://github.com/crinny/bars
 * 
 */

namespace BarsAPI;

# Проверяем подключен ли CURL
if (!extension_loaded ('curl'))
    throw new \Exception ('You must have php curl extension to use BarsAPI');

# Удаляем временную папку
if (is_dir ('tmp'))
{
    array_map ('unlink', glob ('tmp/*'));

    rmdir ('tmp');
}

# Создаём временную папку для хранения сессий
mkdir ('tmp');

# Подключаем файлы библиотеки
require 'php/User.php';
require 'php/Bars.php';

require 'php/Diary/Mark.php';
require 'php/Diary/Lesson.php';
require 'php/Diary/Day.php';
require 'php/Diary/Diary.php';
