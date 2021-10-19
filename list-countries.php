<?php

    include_once './classes/Curl.php';
    include_once './classes/simple_html_dom.php';

    $c = Curl::app('https://en.wikipedia.org')
        ->config_load('wiki.cfg');

    $data = $c->request('wiki/List_of_sovereign_states');

    $dom = str_get_html($data['html']);

    $flags = $dom->find('.flagicon');
    $done = 0;
    $countries = array();

    foreach ($flags as $span) {
        $b = $span->parent();

        if ($b->tag != 'b') {
            continue;
        }

        $a = $b->find('a', 0);
        $countries[$a->href] = $a->plaintext;
        $done++;
    }

    echo "<pre>";
    print_r($countries);
    echo "</pre>";

    file_put_contents('res/list.txt', json_encode($countries));

    echo "<br>Done: $done<br>";

