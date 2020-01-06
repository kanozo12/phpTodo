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

        if ($title == "" || $date == "" || $content == "") {
            Library::msgAndGo("필수 값이 비어있습니다.", "/todo/write");
            return;
        }

        $datetime = $date . " " . ($time == "" ? "00:00:00" : $time . ":00");
        $user = $_SESSION['user'];

        $sql = "INSERT INTO todos (`title`, `content`, `owner`, `date`) VALUES (?, ?, ?, ?)";
        $result = DB::execute($sql, [$title, $content, $user->id, $datetime]);

        if ($result != 1) {
            Library::msgAndGo("데이터베이스 입력 중 오류 발생", "/todo/write");
            return;
        }

        Library::msgAndGo("성공적으로 입력되었습니다.", "/", "success");
    }

    public function mode()
    {
        if (!isset($_GET['id']) || !\is_numeric($_GET['id'])) {
            Library::msgAndGo("잘못된 요청입니다.", "/");
            return;
        }

        $id = $_GET['id'];
        $sql = "SELECT * FROM todos WHERE id = ? AND owner = ?";
        $data = DB::fetch($sql, [$id, $_SESSION['user']->id]);
        if ($data == null) {
            Library::msgAndGo("존재하지 않는 글입니다.", "/");
            return;
        }

        $date = $date->date;
        $time = strtotime($date);
        $data->date = date('Y-m-d', $time);
        $data->date = date('h:i:s', $time);
        $this->render("todo/write", ['todo' => $data]);
    }

    public function modProcess()
    {

    }

    public function del() 
    {
        
    }
}
