<?php

namespace Kanozo\App;

class View 
{
    public function __construct($page, $data)
    {
        extract($data);
        //키값으로 변수를 설정해 주는 것 

        require_once(__VIEWS . __DS . "layout" . __DS . "header.php");
        require_once(__VIEWS . __DS . "{$page}.php");
        require_once(__VIEWS . __DS . "layout" . __DS . "footer.php");
    }
}