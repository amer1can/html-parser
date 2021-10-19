<?php

    include_once './classes/Curl.php';

    $c = Curl::app('https://en.wikipedia.org')
            ->headers(0)
            ->ssl(0) // не проверять ssl сертификаты при https подключении
            ->referer('google.com')
            ->user_agent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36')
            ->cookie();

    $data = $c->request('wiki/Red-billed_gull');

    $c->config_save('wiki.cfg');

    echo "<pre>";
    print_r($data);
    echo "</pre>";


