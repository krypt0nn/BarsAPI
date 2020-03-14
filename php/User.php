<?php

namespace BarsAPI;

/**
 * Объект предоставления информации о пользователе
 */
class User
{
    protected Bars $bars; // Владелец данного объекта

    public ?string $name        = null; // ФИО пользователя
    public ?string $public_name = null; // Публичное имя (Отчество Имя, класс)
    public ?string $school      = null; // Название учебного заведения
    public ?int $pupil_id       = null; // ID ученика
    public ?int $profile_id     = null; // ID профиля
    public ?int $id             = null; // Хрен знает какой ID, но не ID пользователя
    public ?array $childs       = null; // Хрен знает что это, но childs[0][0] - это сам пользователь, по всей видимости

    // Ей богу, я понятия не имею на кой хрен разработчикам этого электронного журнала сдалось аж ТРИ айдишника
    // Понятия не имею зачем, как они с ними работают, что вообще привело к такому решению и что это вообще такое
    // Если вы шарите - пишите мне в вк

    /**
     * Конструктор объекта
     * В качестве параметра нужно передавать информацию, получаемую от метода REST API "rest/login" (что и делает new Bars (...))
     * 
     * @param Bars $owner - владелец поля user
     * @param array $info - массив информации о пользователе
     */
    public function __construct (Bars $owner, array $info)
    {
        $this->bars = $owner;

        $this->name        = $info['fio']          ?? null;
        $this->public_name = $info['childs'][0][1] ?? null;
        $this->school      = $info['childs'][0][2] ?? null;
        $this->pupil_id    = $info['childs'][0][0] ?? null;
        $this->profile_id  = $info['profile_id']   ?? null;
        $this->id          = $info['id']           ?? null;
        $this->childs      = $info['childs']       ?? null;
    }

    /**
     * Получение записей дневника пользователя
     * 
     * [@param int $to_date = null]   - временной маркер timestamp [начальной] даты получения записей
     * [@param int $from_date = null] - временной маркер конечной даты
     * 
     * @return Diary - возвращает объект представления записей дневника
     * 
     * @throws \Exception - выбрасывает исключение при ошибке получения записей дневника
     * 
     * Параметры $to_date и $from_date не являются обязательными
     * Если не указать первый параметр - будет использована текущая дата. Если не указать второй параметр - аналогично
     * При указании $to_date - $from_date > 1 суток будет получена информация о днях с $from_date по $to_date
     * Хоть программно этого ограничения нет, однако вы должны понимать, что $to_date строго больше или равен $from_date, при этом второй явно больше нуля
     */
    public function getDiary (int $to_date = null, int $from_date = null): Diary
    {
        $to_date   ??= time ();
        $from_date ??= $to_date;

        $diary = $this->bars->request ('diary', [
            'pupil_id'  => $this->pupil_id,
            'from_date' => date ('d.m.Y', $from_date),
            'to_date'   => date ('d.m.Y', $to_date)
        ]);

        if ($diary === null || !@$diary['success'])
            throw new \Exception ('An exception catched when trying to get diary');

        return new Diary ($diary);
    }
}
