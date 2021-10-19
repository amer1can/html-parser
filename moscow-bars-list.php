<?php

    include_once './classes/Curl.php';
    include_once './classes/simple_html_dom.php';

    $c = Curl::app('https://www.gdebar.ru')
        ->headers(0)
        ->ssl(0) // не проверять ssl сертификаты при https подключении
        ->referer('google.com')
        ->user_agent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36');

    $c->config_save('gdebar.cfg');

    $data = $c->request('/seti');
    $dom = str_get_html($data['html']);

    $divs = $dom->find('main');
    $links = $divs[0]->find('a');

    $done = 0;
    $bars = array();

   foreach ($links as $link) {
//        echo "$link->href<br>";
//        echo "$link->plaintext<br>";
//        $alts = $link->first_child();
//        echo "$alts->alt<br>";
//        $a = $b->find('a', 0);
        $bars[$link->href] = $link->plaintext;
        $done++;
    }

    echo "<pre>";
    print_r($bars);
    echo "</pre>";

    file_put_contents('res/moscow-bars-list.txt', json_encode($bars));

    echo "<br>Done: $done<br>";

