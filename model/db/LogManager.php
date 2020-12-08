<?php

require_once 'Manager.php';

class LogManager extends Manager
{

    public static function addLog($id_user, $id_palette, $action, $info)
    {
        self::dbConnect()->prepare('INSERT INTO gpal_logs(id_user, id_palette, action, info, date_log) VALUES(?, ?, ?, ?, NOW())')->execute(array($id_user, $id_palette, $action, $info));
    }
}