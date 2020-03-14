<?php

namespace BarsAPI;

/**
 * Объект представления журнала
 */
class Diary
{
    public array $days = []; // Список дней

    /**
     * Конструктор объекта
     * В качестве параметра нужно передавать информацию, получаемую от метода REST API "rest/diary"
     * 
     * @param array $info - массив информации о журнале
     */
    public function __construct (array $info)
    {
        $this->days = array_map (fn ($day) => new Day ($day), $info['days'] ?? []);
    }

    /**
     * Проход по дням недели
     * 
     * @param callable $callable - коллбэк для вызова
     * 
     * @return Diary
     */
    public function foreach (callable $callable): Diary
    {
        foreach ($this->days as $day)
            $callable ($day);

        return $this;
    }
}
