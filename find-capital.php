<?php

    include_once './classes/Parser.php';
    include_once './classes/simple_html_dom.php';

    set_time_limit(0);
    $countries = json_decode(file_get_contents('res/list.txt'));
    $done = 0;

    foreach($countries as $href => $name) {
        $country = file_get_contents('res/countries/' . $name . '.html');
        $p = Parser::app($country);

        $p->moveTo('<table class="infobox ib-country vcard');
        $p->moveTo('<td class="infobox-data">');
        $p->moveTo('<a');
        $p->moveAfter('>');
        $str = $p->readTo('<');
        echo $str . '<br>';

        $done++;
    }

    echo "Done: $done<br>";