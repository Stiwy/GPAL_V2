<?php

require_once 'Manager.php';

class PaletteManager extends Manager
{

    private static $getPaletteById;
    private static $getPaletteByUser;

    protected static function addPalette($reference, $weg, $shelf, $quantity)
    {
        self::dbConnect()->prepare('INSERT INTO palette(reference, weg, shelf, quantity, id_user) VALUES(?, ?, ?, ?, ?)')->execute(array($reference, $weg, $shelf, $quantity, $_SESSION['auth']['id']));

        return self::dbConnect()->lastInsertId();
    }

    protected static function updatePalette($id, $newQuantity, $new_shelf, $new_weg) 
    {
        self::dbConnect()->prepare('UPDATE palette SET weg = ?, shelf = ?,  quantity = ?, id_user = ? WHERE id =?')->execute(array($new_weg, $new_shelf, $newQuantity, $_SESSION['auth']['id'], $id));
    }

    protected static function deletePalette($id)
    {
        self::dbConnect()->prepare('DELETE FROM palette WHERE id = ?')->execute(array($id));
    }

    protected static function refExistAtTheLocation($ref, $new_weg, $new_shelf)
    {
        $req = self::dbConnect()->prepare('SELECT * FROM palette WHERE reference = ? AND weg = ? AND shelf = ?');
        $req->execute(array($ref, $new_weg, $new_shelf));

        return $req-> fetch(PDO::FETCH_ASSOC);
    }

    protected static function getReference($reference)
    {
        $req = self::dbConnect()->prepare('SELECT * FROM reference_gpal WHERE reference = ?');
        $req->execute(array($reference));

        return $req->fetch(PDO::FETCH_ASSOC);
    }

    protected static function addReference($reference)
    {
        self::dbConnect()->prepare('INSERT INTO reference_gpal(reference) VALUE(?)')->execute(array($reference));
    }

    protected static function getPaletteById($id)
    {
        if(is_null(self::$getPaletteById) || $id != self::$getPaletteById['id']) {
            $req = self::dbConnect()->prepare('SELECT * FROM palette WHERE id = ?');
            $req->execute(array($id));

            self::$getPaletteById = $req->fetch(PDO::FETCH_ASSOC);
        }
        
        return self::$getPaletteById;
    }

    protected static function getPalettesByUser($id_user, $today)
    {
        if(is_null(self::$getPaletteByUser)) { 
            $req = self::dbConnect()->prepare('SELECT p.id, p.reference, p.weg, p.shelf, p.quantity, p.id_user, gl.date_log FROM palette p LEFT JOIN gpal_logs gl ON p.id_user = gl.id_user and p.id = gl.id_palette WHERE p.id_user = ? and gl.date_log LIKE ? ORDER BY gl.date_log DESC');
            $req->execute(array($id_user, '%' . $today . '%'));

            self::$getPaletteByUser = $req->fetchAll();
        }
        
        return self::$getPaletteByUser;
    }

    protected static function getPalettes($reference)
    {
        $req = self::dbConnect()->prepare('SELECT * FROM palette WHERE reference LIKE ? ORDER BY reference');
        $req->execute(array('%' . $reference . '%'));

        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    protected static function getLogByPalette($id_palette)
    {
        if($_SESSION['auth']['admin'] == 1) {
            $req = self::dbConnect()->prepare('SELECT gl.action, gl.info, DATE_FORMAT(gl.date_log, \'%d/%m/%Y à %Hh%imin%ss\') AS date , w.username FROM gpal_logs gl LEFT JOIN warehouseman w ON gl.id_user = w.id WHERE gl.id_palette = ? ORDER BY gl.date_log DESC LIMIT 0, 50');
        }else {
            $req = self::dbConnect()->prepare('SELECT gl.action, gl.info, DATE_FORMAT(gl.date_log, \'%d/%m/%Y à %Hh%imin%ss\') AS date , w.username FROM gpal_logs gl LEFT JOIN warehouseman w ON gl.id_user = w.id WHERE gl.id_palette = ? ORDER BY gl.date_log DESC LIMIT 0, 10');
        }

        $req->execute(array($id_palette));

        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
}