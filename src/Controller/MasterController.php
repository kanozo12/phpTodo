<?php

namespace Kanozo\Controller;

use Kanozo\App\View;

class MasterController 
{
    public function render($page, $datas = [])
    {
        $view = new View($page, $datas);
    }
}