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

    public function mod()
    {
        if (!isset($_GET['id']) || !\is_numeric($_GET['id'])) {
            Library::msgAndGo("잘못된 요청입니다.", "/");
            return;
        }

        $id = $_GET['id'];
        $sql = "SELECT * FROM todos WHERE id = ? AND `owner` = ?";
        $data = DB::fetch($sql, [$id, $_SESSION['user']->id]);
        if ($data == null) {
            Library::msgAndGo("존재하지 않는 글입니다.", "/");
            return;
        }

        $date = $data->date;
        $time = strtotime($date);
        $data->date = date('Y-m-d', $time);
        $data->date = date('h:i:s', $time);
        $this->render("todo/write", ['todo' => $data]);
    }

    public function modProcess()
    {
        $title = $_POST['title'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $content = $_POST['content'];
        $id = $_POST['id'];

        if($title == "" || $date == "" || $content == "") {
            Library::msgAndGo("필수값이 비어있습니다.", "/todo/mod?id=" . $id);
            return;
        }

        $user = $_SESSION['user'];
        $sql = "SELECT * FROM todos `owner` = ? AND `id` = ?";
        $data = DB::fetch($sql, [$user->id, $id]);

        if($data == null) {
            Library::msgAndGo("권한이 없습니다.", "/");
            return;
        }

        $datetime = $date . " " . ($time == "" ? "00:00:00" : $time . ":00");
        $sql = "UPDATE todos SET `title` = ?, `content` = ?, `date` = ?, WHERE `id` = ?";
        $result = DB::execute($sql, [$title, $content, $datetime, $id]);

        if($result != 1) {
            Library::msgAndGo("데이터베이스 수정중 오류 발생", "/todo/mod?=" . $id);
            return;
        }

        Library::msgAndGo("성공적으로 수정되었습니다.", "/". "success");
        return;
    }
    
    public function del() 
    {
        if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            Library::msgAndGo("삭제 대상 값이 올바르지 않습니다.", "/");
            return;
        }
        
        $id = $_GET['id'];
        $user = $_SESSION['user'];
        $sql = "SELECT * FROM todos WHERE `owner` = ? AND `id` = ?";
        $data = DB::fetch($sql, [$user->id, $id]);

        if($data == null) {
            Library::msgAndGo("권한이 없습니다.", "/");
            return;
        }

        $sql = "DELETE FROM todos WHERE id = ?";
        $result = DB::execute($sql, [$id]);
        if($result != 1) {
            Library::msgAndGo("데이터베이스 삭제중 오류 발생.", "/");
            return;
        }

        Library::msgAndGo("성공적으로 삭제되었습니다.", "/", "success");
        return;
    }
}
