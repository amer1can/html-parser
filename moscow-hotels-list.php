<?php

    include_once './classes/Curl.php';
    include_once './classes/simple_html_dom.php';

    $c = Curl::app('https://www.tripadvisor.ru')
        ->headers(1)
        ->ssl(0) // не проверять ssl сертификаты при https подключении
        ->referer('google.com')
        ->user_agent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36');

    $c->config_save('tripadvisor.cfg');

    $data = $c->request('/Hotels-g298484-Moscow_Central_Russia-Hotels.html');
    $dom = str_get_html($data['html']);

    print_r($dom);
    exit;

    $divs = $dom->find('a');
    $done = 0;
    $countries = array();



    foreach ($divs as $link) {
        $b = $link->first_child();
        break;

        if ($b->tag != 'a') {
            continue;
        }

//        $a = $b->find('a', 0);
        $countries[$b->href] = $b->plaintext;
        $done++;
    }

    echo "<pre>";
    print_r($countries);
    echo "</pre>";

    file_put_contents('res/moscow-hotels-list.txt', json_encode($countries));

    echo "<br>Done: $done<br>";

