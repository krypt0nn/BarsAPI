<?php

namespace BarsAPI;

/**
 * Объект представления урока
 */
class Lesson
{
    public ?string $date       = null; // Дата проведения урока
    public ?string $discipline = null; // Предмет
    public ?string $teacher    = null; // Учитель
    public ?string $subject    = null; // Тема
    public ?string $room       = null; // Кабинет
    public ?string $homework   = null; // Домашняя работа
    public array $marks        = [];   // Оценки

    public ?int $lesson_id      = null; // ID урока
    public ?string $lesson_name = null; // Имя урока (1-й урок, 2-й урок и т.п.)
    public ?string $begin_time  = null; // Время начала (8:15 и т.п.)
    public ?string $end_time    = null; // Время конца (8:55 и т.п.)

    /**
     * Конструктор объекта
     * 
     * @param array $info - массив информации о уроке
     */
    public function __construct (array $info)
    {
        foreach (get_object_vars ($this) as $name => $value)
            if (isset ($info[$name]))
                $this->$name = $info[$name];

        $this->lesson_id   = $info['lesson'][0] ?? null;
        $this->lesson_name = $info['lesson'][1] ?? null;
        $this->begin_time  = $info['lesson'][2] ?? null;
        $this->end_time    = $info['lesson'][3] ?? null;

        foreach ($this->marks as $id => $mark)
            $this->marks[$id] = new Mark (current ($mark[2]), $mark[0]);
    }

    /**
     * Проход по оценкам
     * 
     * @param callable $callable - коллбэк для вызова
     * 
     * @return Lesson
     */
    public function foreach (callable $callable): Lesson
    {
        foreach ($this->marks as $mark)
            $callable ($mark);

        return $this;
    }
}
