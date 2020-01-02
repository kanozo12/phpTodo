<?php

namespace Kanozo\App;

class DB
{
    private static $db = null;

    public static function getDB()
    {
        if (is_null(self::$db)) {
            $options = [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION];
            self::$db = new \PDO("mysql:host=localhost; dbname=todo; charset=utf8mb4", "root", "", $options);
        }

        return self::$db;
    }

    //insert delete update
    public static function execute($sql, $data = [])
    {
        $q = self::getDB()->prepare($sql);
        return $q->execute($data);
    }

    //조회
    public static function fetch($sql, $data=[], $mode = \PDO::FETCH_OBJ)
    {
        $q = self::getDB()->prepare($sql);
        $q->execute($data);
        return $q->fetch($mode);
    }

    //여러개 조회
    public static function fetchAll($sql, $data=[], $mode = \PDO::FETCH_OBJ)
    {
        $q = self::getDB()->prepare($sql);
        $q->execute($data);
        return $q->fetchAll($mode);
    }
    
    //마지막 삽입된 오토인크리먼트 값 조회
    public static function lastId()
    {
        return self::getDB()->lastInsertId();
    }


}
