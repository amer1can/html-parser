<?php


class Parser {
    private static $instance;
    private $cur = 0;
    private $str = '';

    public static function app($str) {
        return new self($str);
    }

    private function __construct($str) {
        $this->str = $str;
        $this->cur = 0;
    }

    public function moveTo($pattern) {
        $res = strpos($this->str, $pattern, $this->cur);

        if($res === false)
            return -1;

        $this->cur = $res;
        return true;
    }

    public function moveAfter($pattern) {
        $res = strpos($this->str, $pattern, $this->cur);

        if($res === false)
            return -1;

        $this->cur = $res + strlen($pattern);
        return true;
    }

    public function readTo($pattern) {
        $res = strpos($this->str, $pattern, $this->cur);

        if($res === false)
            return -1;

        $out = substr($this->str, $this->cur, $res - $this->cur);

        $this->cur = $res;
        return $out;
    }


}