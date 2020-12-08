<?php
if (session_status() == PHP_SESSION_NONE){session_start();}

require 'model/App.php';

if (isset($_SESSION["auth"])) {
    App::return();
}else {
	header('Location: index.php');
}
