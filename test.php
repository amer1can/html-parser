<?php

    include_once './classes/Curl.php';
    include_once './classes/Parser.php';

        $data = file_get_contents('test.html');
        $target = Parser::app($data);

        $str = $target->subtag('<table class="tbl', '<table', '</table>');

        echo "$str<br><br>";

//    echo "<br>Done: $done<br>";
