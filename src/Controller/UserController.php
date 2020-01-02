<?php

namespace Kanozo\Controller;

use Kanozo\App\DB;
use Kanozo\App\Library;

class UserController extends MasterController
{
    public function register()
    {
        //회원 가입 페이지 보여주기
        $this->render("user/register");
    }

    public function registerProcess()
    {
        //실제 회원가입 처리
        $userId = $_POST['userId'];
        $pass = $_POST['password'];
        $passc = $_POST['passwordc'];
        $username = $_POST['username'];

        if ($userId == "" || $pass == "" || $username == "") {
            Library::msgAndGo("필수값은 공백이 될 수 없습니다.", "/user/register");
            return;
        }

        if ($pass != $passc) {
            Library::msgAndGo("비밀번호와 비밀번호 확인이 다릅니다.", "/user/register");
            return;
        }

        $sql = "INSERT INTO users(`id`, `name`, `password`, `level`) VALUES (?, ?, PASSWORD(?), ?)";
        $result = DB::execute($sql, [$userId, $username, $pass, 1]);

        if ($result != 1) {
            Library::msgAndGo("DB에 값이 올바르게 들어가지 않았습니다.", "/user/register");
            return;
        }

        Library::msgAndGo("회원가입 완료. 로그인 해주세요", "/user/login", "success");
    }

    public function login()
    {
        $this->render("user/login");
    }

    public function loginProcess()
    {
        $userId = $_POST['userId'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE id = ? AND password = PASSWORD(?)";
        $user = DB::fetch($sql, [$userId, $password]);

        if ($user == null) {
            Library::msgAndGo("일치하는 회원이 없습니다", "/user/login");
            return;
        }

        $_SESSION['user'] = $user;
        Library::msgAndGo("로그인 완료", "/", "success"); 
    }

    public function logout()
    {
        unset($_SESSION['user']);
        Library::msgAndGo("로그아웃 완료", "/", "success");
    }
}
