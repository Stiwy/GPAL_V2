<?php
require 'db/UserManager.php';

class Users extends UserManager 
{

    public static function delete()
    {
        self::delUser($_GET['iduser']);
        $_SESSION['flash']['success'] = 'Le compte à était supprimer !';
        header('Location: index.php?action');
    }

    public static function register()
    {
        App::sessionFlash();

        $error= '';
        $count = 0;

        if (!isset($_POST['newUser']) || empty($_POST['newUser']) || strlen($_POST['newUser']) < 3 || strlen($_POST['newUser']) > 50 || !is_string($_POST['newUser'])) {
            $error .= "<span>Veuillez saisir un nom d'utilisateur valide !</span></br>";
        }else {
            $postUsername = APP::secureInput($_POST['newUser']);
        }
        
        do {
            $id = rand(1000, 9999);
            $username = ($count !=0)? $postUsername.$count : $postUsername; 
            $res = self::rowCount($id, $username);
            $count++;
        }while ($res != 0);

        if (!is_null($_POST['admin'])) {
            if (!isset($_POST['password']) || empty($_POST['password'])) {
                $error .= "<span>Aucun mot de passe saisie !</span></br>";
            }

            if (!isset($_POST['passwordConfirm']) || empty($_POST['passwordConfirm']) || $_POST['password'] != $_POST['passwordConfirm']) {
                $error .= "<span>Les mots de passe ne coresspondent pas !</span></br>";
            }

            $password = APP::secureInput($_POST['password']);
        }else {
            $password = $username.(int)substr($id,0,2);
        }

        if ($error === '') {
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            $admin = (!is_null($_POST['admin'])) ? true : false;

            self::add($id, $username, $passwordHash, $admin);
            LogManager::addLog($id, 0, 'Nouveau', ' compte');
            $_SESSION['flash']['info'] = ' Identifiant = ' . $username . ' Mot de Passe = ' . $password;
        }else {
            $_SESSION['flash']['danger'] = $error;
        }
        
        header('LOCATION: index.php?action=dashboard');
    }

    public static function login() 
    {
        App::sessionFlash();
        $error = '';

        if (!isset($_POST['userName']) || empty($_POST['userName'])) {
            $error .= '<span>Veuillez saisir votre identifiant !</span></br>';
        }else {
            $username = App::secureInput($_POST['userName']);
        }

        if (!isset($_POST['userPassword']) || empty($_POST['userPassword'])) {
            $error .= '<span>Veuillez saisir votre mot de passe !</span></br>';
        }else {
            $userPassowrd = App::secureInput($_POST['userPassword']);
        }

        $user = self::fetch($username);

        if ($user === false) {
            $error .= '<span>Identifiant ou mot de passe incorrecte !</span></br>';
        }else {
            if (!password_verify($userPassowrd, $user['password'])) {
                $error .= '<span>Identifiant ou mot de passe incorrecte !</span></br>';
            }
        }

        if ($error === '') {

            self::update($user['id']);

            $cookie_name = "PHPUSERID";
            $cookie_value = $user['id'] . "---" . sha1($user['username'] . $user['password'] . $user['admin']);
            setcookie($cookie_name, $cookie_value, time() + (3600 * 24), "/", "bor.santedistri.com", false, true);

            $_SESSION['auth'] = $user;

            $_SESSION['flash']['success'] = 'Vous êtes maintenant connecté !';
            
            header('LOCATION: index.php?action');
        }else {
            $_SESSION['flash']['danger'] = $error;
            header('LOCATION:' . $_SERVER["HTTP_REFERER"]);
        }
    }

    public static function logout()
    {
        
        App::sessionFlash();
        
        setcookie('PHPUSERID', '', time() - 4200, '/', "bor.santedistri.com", false, true);
        unset($_SESSION['auth']);

        $_SESSION['flash']['success'] = "Vous avez bien était déconnecté.";
        header('location: index.php');
    }

    public static function listUsers($list = "")
    {
        App::sessionFlash();
        $result = array();
        if ($list === "admin"){
            foreach(self::getUsers() as $user){
                if($user['admin'] == "1") {
                    array_push($result, $user);
                }
            }
        }else {
            foreach(self::getUsers() as $user){
                if($user['admin'] == "0") {
                    array_push($result, $user);
                }
            }
        }
       
        return $result;
    }

    public static function userLog($id)
    {
        return self::getLogByUSer($id);
    }

    public static function countLog($id)
    {
        $date = date('Y-m-d');
        return self::countModif($id, $date);
    }

    public static function loginByCookieMember()
    {
        
        $auth = $_COOKIE['PHPUSERID'];
        $auth = explode("---", $auth);
        
        $user = self::fetchId($auth['0']);
        $key = sha1($user['username'] . $user['password']);
        if ($key == $auth[1]) { // Verify if the $key is identiqual as key $auth[1]
            $_SESSION['auth'] = $user;
        }
    }
}