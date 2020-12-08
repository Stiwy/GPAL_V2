<?php

require_once 'Manager.php';

class UserManager extends Manager 
{
    private static $getUsers;

    protected static function fetchId($id)
    {
        $req = self::dbConnect()->prepare('SELECT * FROM warehouseman WHERE id = ?');
        $req->execute(array($id));

        return $req->fetch(PDO::FETCH_ASSOC);
    }

    protected static function delUser($id)
    {
        $req = self::dbConnect()->prepare('DELETE FROM warehouseman WHERE id = ?'); 
        $req->execute(array($id));
    }

    protected static function fetch($username)
    {
        $req = self::dbConnect()->prepare('SELECT * FROM warehouseman WHERE username = ?');
        $req->execute(array($username));

        return $req->fetch(PDO::FETCH_ASSOC);
    }

    protected static function rowCount($id, $username) 
    {
        $req =self::dbconnect()->prepare('SELECT * FROM warehouseman WHERE id=? or username=?');
        $req->execute(array($id, $username));
        return $req->rowCount();
    }

    protected static function add($id, $username, $passwordHash, $admin)
    {
        $req = self::dbconnect()->prepare('INSERT INTO warehouseman(id, username, password, admin, last_login_date) VALUE(?, ?, ?, ?, NULL)');
        $req->execute(array($id, $username, $passwordHash, $admin));
    }

    protected static function update($id)
    {
        self::dbConnect()->prepare("UPDATE warehouseman SET last_login_date = NOW() WHERE id = ?")->execute(array($id));

    }

    protected static function getUsers()
    {
        if(is_null(self::$getUsers)) {
            $req = self::dbConnect()->query('SELECT id, username, admin, DATE_FORMAT(last_login_date, \'%d/%m/%Y à %Hh%imin%ss\') AS last_login_date FROM warehouseman');
            self::$getUsers = $req->fetchAll(PDO::FETCH_ASSOC);
        }
        return self::$getUsers;
    }

    protected static function getLogByUSer($id)
    {
        $req = self::dbConnect()->prepare('SELECT 
        gl.id, 
        gl.id_user, 
        gl.id_palette, 
        gl.action, 
        gl.info, 
        DATE_FORMAT(gl.date_log, \'%d/%m/%Y à %Hh%imin%ss\') AS date_log, 
        p.reference, 
        w.username,
        DATE_FORMAT(w.last_login_date, \'%d/%m/%Y </br> %Hh%imin%ss\') AS last_login_date
        FROM gpal_logs gl
        LEFT JOIN palette p 
            ON gl.id_palette = p.id  
        LEFT JOIN warehouseman w
            ON w.id = gl.id_user
        WHERE gl.id_user = ?
        ORDER BY gl.date_log DESC
        LIMIT 0, 50
        ');
        $req->execute(array($id));
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    protected static function countModif($id, $date)
    {
        $req = self::dbConnect()->prepare('SELECT * FROM gpal_logs WHERE id_user = ? and date_log LIKE ?');
            $req->execute(array($id, '%' . $date . '%'));
        return $req->rowCount();
    }
}