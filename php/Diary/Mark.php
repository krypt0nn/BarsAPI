<?php

namespace BarsAPI;

/**
 * Объект представления оценки
 */
class Mark
{
    public string $mark; // Оценка
    public ?string $description = null; // Описание оценки

    /**
     * Конструктор объекта
     * 
     * @param string $mark - оценка
     * [@param string $description = null] - описание оценки
     */
    public function __construct (string $mark, string $description = null)
    {
        $this->mark = $mark;
        $this->description = $description;
    }
}
