<?php

namespace Kanozo\Controller;

use Kanozo\App\View;
use Kanozo\App\DB;

class MainController extends MasterController
{
    public function index()
    {   
        $list = [];
        $cnt = 0;
        $prev = false;
        $next = false;
        if(isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $page = isset($_GET['p']) && is_numeric($_GET['p']) ? $_GET['p'] : 1;
            $start = ($page - 1) * 5;
            $sql = "SELECT * FROM todos WHERE owner = ? AND date >= NOW() ORDER BY date LIMIT {$start}, 5";
            $list = DB::fetchAll($sql, [$user->id]);

            $sql = "SELECT count(*) AS cnt FROM todos WHERE owner = ? AND date >= NOW()";

            $cnt = DB::fetch($sql, [$user->id]);
            $cnt = $cnt->cnt;

            if(ceil($cnt / 5) > $page) {
                $next = true;
            }

            if($page != 1) {
                $prev =  true;
            }
        }

        $this->render("main", ['list' => $list, 'cnt' => $cnt, 'prev' => $prev, 'next' => $next, 'p' => $page]);
    }
}
