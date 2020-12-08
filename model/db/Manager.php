<?php

class Manager
{

    protected static $db;

    protected static function dbConnect()
    {
        if (is_null(self::$db)) {
            try
            {
                self::$db = new PDO('mysql:host=95.128.74.44;dbname=robem_medical;charset=utf8', 'stiwy', '45uyL36U712',  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            }
            catch(Exception $e)
            {
                    die('Erreur : '.$e->getMessage());
            }
        }
        
        return self::$db;
    }
}   

