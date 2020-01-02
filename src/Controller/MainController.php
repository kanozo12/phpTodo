<?php

namespace Kanozo\Controller;

use Kanozo\App\View;
use Kanozo\App\DB;

class MainController extends MasterController
{
    public function index()
    {
        $list = [];

        if (isset($_SESSION['user'])) {
            $sql = "SELECT * FROM todos WHERE owner = ? AND date >= NOW() ORDER BY date LIMIT 0, 5";
            $userId = $_SESSION['user']->id;
            $list = DB::fetchAll($sql, [$userId]);
        }

        $this->render("main", ['list' => $list]);
    }
}
