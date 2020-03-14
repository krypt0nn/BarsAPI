<?php

namespace BarsAPI;

/**
 * Объект реализации работы с API
 */
class Bars
{
    protected string $url; // URL сервера запросов к API
    protected string $cookie_tmp; // Временный файл хранения cookie

    public User $user; // Объект представления информации о пользователе

    /**
     * Конструктор объекта запросов к API
     * 
     * @param string $login       - логин пользователя
     * @param string $password    - пароль пользователя
     * [@param string $diary_url] - ссылка на сервер для запросов
     * 
     * @throws \Exception - выбрасывает исключение при ошибке авторизации
     * 
     * @example
     * 
     * use BarsAPI\Bars;
     * 
     * $api = new Bars ('логин', 'пароль');
     */
    public function __construct (string $login, string $password, string $diary_url = 'https://xn--80atdl2c.xn--33-6kcadhwnl3cfdx.xn--p1ai')
    {
        $this->url = $diary_url;
        $this->cookie_tmp = dirname (__DIR__) .'/tmp/cookie-'. rand (100000, 999999) .'.tmp';

        $auth = $this->request ('login', [
            'login'    => $login,
            'password' => $password
        ]);

        if ($auth === null || !@$auth['success'])
            throw new \Exception ('Authentification error');

        $this->user = new User ($this, $auth);
    }

    /**
     * Выйти из аккаунта
     */
    public function logout (): void
    {
        $this->request ('logout');
    }

    /**
     * Метод реализации запросов к REST API
     * Работает с CURL если это возможно. Если CURL не подключен - использует встроенный file_get_contents
     * 
     * @param string $method       - метод запроса
     * [@param array $params = []] - массив параметров запроса
     * 
     * @return array|null - возвращает массив с результатом запроса в случае успеха или null в случае неудачи
     * 
     * @throws \Exception - выбрасывает исключение при ошибке создания CURL
     */
    public function request (string $method, array $params = []): ?array
    {
        if ($curl = curl_init ($this->url .'/rest/'. $method))
        {
            curl_setopt_array ($curl, [
                CURLOPT_HEADER         => false,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => http_build_query ($params),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_FOLLOWLOCATION => true,

                CURLOPT_COOKIEJAR  => $this->cookie_tmp,
                CURLOPT_COOKIEFILE => $this->cookie_tmp
            ]);

            $response = curl_exec ($curl);
            curl_close ($curl);

            return @json_decode ($response, true) ?: null;
        }

        throw new \Exception ('Curl initialization error');
    }
}
