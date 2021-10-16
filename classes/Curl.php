<?php

class Curl {
    private $ch; //экземпляр курла
    private $host; //базовая часть урла без слэша на конце

    public static function app($host) {
        return new self($host);
    }

    private function __construct($host) {
        $this->ch = curl_init();
        $this->host = $host;
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true); // возвращать данные без вывода на экран
    }

    public function __destruct() {
        curl_close($this->ch);
    }

    public function set($name, $value) {
        curl_setopt($this->ch, $name, $value);
        return $this;
    }

    public function request($url) {
        curl_setopt($this->ch, CURLOPT_URL, $this->make_url($url));
        $data = curl_exec($this->ch);
        return $this->process_result($data);
    }

    public function make_url($url) {
        if ($url[0] != '/')
            $url = '/' . $url;
        return $this->host . $url;
    }

    private function process_result($data) {
        // ищем \n или \r\n, т.е. пустую строку, разделяющую заголовок ответа от тела
        $p_n = "\n";
        $p_rn = "\r\n";

        $h_end_n = strpos($data, $p_n . $p_n); //проверка если есть сивол переноса строки, то данные с заголовком
        $h_end_rn = strpos($data, $p_rn . $p_rn); // тоже самое

        $start = $h_end_n; // место переноса \n
        $p = $p_n; // запоминаем в р

        // если \n не найден и \r\n встретится раньше \n значит вот он разделитель заголовка
        if ($h_end_n == false || $h_end_rn < $h_end_n) {
            $start = $h_end_rn; // запоминаем его начало
            $p = $p_rn; // запоминаем его знак
        }

        $header_part = substr($data, 0, $start); // запоминаем заголовок
        $body_part = substr($data, $start + strlen($p) * 2); // запоминаем тело от start + 2ой пернос строки(т.е пустая строка)]]\\

        $lines = explode($p, $header_part); //разбиваем заголовок по $p(\n || \r\n)
        $headers = array();

        $headers['start'] = $lines[0]; //первая строка с кодом ответа сервера

        for($i = 1; $i < count($lines); $i++) {
            $del_pos = strpos($lines[$i], ':'); // находим первый :
            $name = substr($lines[$i], 0, $del_pos); // сохр имя до :
            $value = substr($lines[$i], $del_pos + 2); // сохр значение после ': ' поэтому +2
            $headers[$name] = $value;
        }

        return array(
            'headers' => $headers,
            'html' => $body_part
        );
    }
}

