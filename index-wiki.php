<?php

    include_once './classes/Curl.php';

    $c = Curl::app('https://ru.wikipedia.org/')
        ->config_load('wiki.cfg');

    $data = $c->request('/wiki/Айвз,_Клэй');


    echo "<pre>";
    print_r($data);
    echo "</pre>";

