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
			print_r(App::getAlert()) ;
			Palettes::newReference();
		break;

		case "addpalette":
			print_r(App::getAlert()) ;
			Palettes::newPalette();
		break;

		case "updatequantity":
			print_r(App::getAlert()) ;
			Palettes::updateQuantity();
		break;

		case "movepalette";
			print_r(App::getAlert()) ;
			Palettes::movePalettes();
		break;

		case "getpalette";
			print_r(App::getAlert()) ;
			$getPaletteById = Palettes::getPalette();
			require 'view/client/detailsPalette.php';
		break;

		case "return":
			App::return();
		break;

		case "search":
			print_r(App::getAlert()) ;
			require 'view/client/listPalettes.php';
		break;

		case "adduser":
			print_r(App::getAlert()) ;
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
			print_r(App::getAlert()) ;
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
			print_r(App::getAlert()) ;

			if ($_SESSION['auth']['admin'] == 1) {
				require 'view/secure/home.php';
			}else {
				require 'view/client/home.php';
			}
		break;
    }
    
}else {
	print_r(App::getAlert()) ;
	if($_POST) {
		Users::login();
	}else {
		require 'view/client/login.php';
	}
}

$content = ob_get_clean();

require 'view/template.php';
?>
