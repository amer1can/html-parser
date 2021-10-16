<?php

    include_once './classes/Curl.php';

    $c = Curl::app('http://ntschool.ru')
            ->set(CURLOPT_HEADER, 1);

    $data = $c->request('/kursyi');


    echo "<pre>";
    print_r($data);
    echo "</pre>";
