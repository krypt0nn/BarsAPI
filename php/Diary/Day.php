<?php

namespace BarsAPI;

/**
 * Объект представления дня недели
 */
class Day
{
    public ?string $date  = null; // Дата
    public array $lessons = [];   // Список уроков

    /**
     * Конструктор объекта
     * 
     * @param array $info - массив информации о дне недели
     */
    public function __construct (array $info)
    {
        $this->date = $info[0] ?? null;
        
        $this->lessons = array_map (fn ($lesson) => new Lesson ($lesson), $info[1]['lessons'] ?? []);
    }

    /**
     * Проход по урокам
     * 
     * @param callable $callable - коллбэк для вызова
     * 
     * @return Day
     */
    public function foreach (callable $callable): Day
    {
        foreach ($this->lessons as $lesson)
            $callable ($lesson);

        return $this;
    }
}
