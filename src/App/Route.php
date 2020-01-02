<?php

namespace Kanozo\App;

class Route 
{
    public static $actions = [];

    public static function __callStatic($method, $args)
    {
        $req = strtolower($_SERVER['REQUEST_METHOD']);

        if($req == $method) {
            self::$actions[] = $args;
        }
    }

    public static function init()
    {
        //echo $_SERVER['REQUEST_URI'] . "<br>";
        $path = explode("?", $_SERVER['REQUEST_URI']);
        $path = $path[0];
        //echo $path;

        foreach(self::$actions as $req){
            //['/', 'MainController@index']
            if($req[0] === $path){
                $action = explode("@", $req[1]);  
                // $action[0] => MainController
                // $action[1] => index
                $controller = 'Kanozo\\Controller\\' . $action[0];
                //Gondr\Controller\MainController
                $controllerInstance = new $controller();
                //1급시민 객체의 차이
                $controllerInstance->{$action[1]}();
                return;
            }
        }
        
        echo "잘못된 접근입니다.";
    }
}