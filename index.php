<?php
if (session_status() == PHP_SESSION_NONE){session_start();}

require 'model/App.php';
require 'model/Users.php';
require 'model/Palettes.php';
require 'model/db/LogManager.php';

if (isset($_COOKIE['PHPUSERID'])) { Users::loginByCookieMember();}

ob_start();

if (isset($_SESSION["auth"])) {

	if(!isset($_GET["action"])){
		header('Location: index.php?action');
	}

	switch ($_GET["action"]) {

		case 'addreference':
			Palettes::newReference();
		break;

		case "addpalette":
			Palettes::newPalette();
		break;

		case "updatequantity":
			Palettes::updateQuantity();
		break;

		case "movepalette";
			Palettes::movePalettes();
		break;

		case "getpalette";
			$getPaletteById = Palettes::getPalette();
			require 'view/client/detailsPalette.php';
		break;

		case "search":
			require 'view/client/listPalettes.php';
		break;

		case "adduser":
            if ($_SESSION['auth']['admin'] == 1) {
				Users::register();
			}else {
				header('LOCATION: index.php?action');
			}
		break;

		case "deluser":
            if ($_SESSION['auth']['admin'] == 1) {
				Users::delete();
			}else {
				header('LOCATION: index.php?action');
			}
		break;

		case "getuser":
			if ($_SESSION['auth']['admin'] == 1) {
				require 'view/secure/detailsUser.php';
			}else {
				header('LOCATION: index.php?action');
			}
		break;

		case "logout":
			Users::logout(); 
		break;

		default:

			if ($_SESSION['auth']['admin'] == 1) {
				require 'view/secure/home.php';
			}else {
				require 'view/client/home.php';
			}
		break;
    }
    
}else {
	if($_POST) {
		Users::login();
	}else {
		require 'view/client/login.php';
	}
}

$content = ob_get_clean();

require 'view/template.php';
?>
