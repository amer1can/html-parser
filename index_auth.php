<?php
    include_once 'classes/Curl.php';

    // легальный парсинг сайта, нужно быть автоизованным на необходимом сайте и знать имя-пароль
    // ключи для авторизации смотрим инструментом разработчика на странице с формой авторизации (input name)(checkbox name)

    $post = array(
        'wpName' => 'Vovan4a86',
        'wpPassword' => '535250wik',
    );

    $c = curl::app('https://ru.wikipedia.org')
                ->set(CURLOPT_HEADER, 1)
                ->ssl(0) // не проверять ssl сертификаты при https подключении
                ->post($post)  // пост запрос на отправку данных пользователь-пароль
                ->cookie(); // сохр куки, для обращения к страницам после авторизации

    $data = $c->request('w/index.php?title=Служебная:Вход&returnto=Заглавная+страница'); // авторизация, если успешно в заголовке 302 ответ
//    $data = $c->request('/account/'); // переход в ЛК

    var_dump($data);