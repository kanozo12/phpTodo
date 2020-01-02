<?php

namespace Kanozo\Controller;

use Kanozo\App\DB;
use Kanozo\App\Library;

class TodoController extends MasterController
{
    public function write()
    {   
        $this->render("todo/write");
    }

    public function writeProcess() 
    {
        //실제 글이 쓰여지는 부분
        $title = $_POST['title'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $content = $_POST['content'];

        if($title == "" || $date  == "" || $content == "") {
            Library::msgAndGo("필수 값이 비어있습니다.", "/todo/write");
            return;
        }

        $datetime = $date . " " . ($time == "" ? "00:00:00" : $time . ":00");
        $user = $_SESSION['user'];

        $sql = "INSERT INTO todos (`title`, `content`, `owner`, `date`) VALUES (?, ?, ?, ?)";
        $result = DB::execute($sql, [$title, $content, $user->id, $datetime]);

        if($result != 1) {
            Library::msgAndGo("데이터베이스 입력 중 오류 발생", "/todo/write");
            return;
        }

        Library::msgAndGo("성공적으로 입력되었습니다.", "/", "success");
    }
}