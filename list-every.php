<?php

    include_once './classes/Curl.php';
    include_once './classes/simple_html_dom.php';

    set_time_limit(0);

    $c = Curl::app('https://en.wikipedia.org')
        ->config_load('wiki.cfg');

    $countries = json_decode(file_get_contents('res/list.txt'));
    $done = 0;

    foreach ($countries as $href => $name) {
        $data = $c->request($href);
        file_put_contents('res/countries/' . $name . '.html', $data['html']);
        $done++;

        sleep(mt_rand(0, 2));
    }

    echo "<br>Done: $done<br>";
