<?php

require 'db/PaletteManager.php';

class Palettes extends PaletteManager
{
    public static function updateQuantity() 
    {
        App::sessionFlash();
        $error = "";

        if (!isset($_GET['idpalette'])) {
            $id = "0";
        }else {
            $id = App::secureInput($_GET['idpalette']);
        }

        $palette = self::getPaletteById($id);

		if (isset($_POST['new_quantity']) && $_POST['new_quantity'] >= 0 && is_numeric($_POST['new_quantity'])) {
            $newQuantity = App::secureInput($_POST['new_quantity']);

            $info = $palette['quantity'] . " => " . $newQuantity;
            
            $action = ($newQuantity < $palette['quantity']) ? "Retrait" : "Ajouts";

			if ($newQuantity == 0) { // If the new quantity = 0 then delete the palette

                self::deletePalette($id);
                
                $referer = header('Location: index.php');
                
                $info = $palette['reference'] . " A" . $palette['weg'] . " R" . $palette['shelf'];

                $action ="Suppression";

			}else {
                self::updatePalette($id, $newQuantity, $palette['shelf'], $palette['weg']);

				$referer = header('Location:' . $_SERVER['HTTP_REFERER']);
            }
            LogManager::addLog($_SESSION['auth']['id'], $palette['id'], $action, $info);
            
            $_SESSION['flash']['success'] = "<span>La quantité à bien été mis à jour !</span>";
            $referer;
		}else {
            $_SESSION['flash']['danger'] = "<span>La quantité de platte est incorrecte !</span>";
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
	}

    public static function movePalettes() {

        App::sessionFlash();

		$error = "";

        if (!isset($_GET['idpalette'])) {
            $id = "0";
        }else {
            $id = App::secureInput($_GET['idpalette']);
        }

        $palette = self::getPaletteById($id);

        if (!isset($_POST['quanity_at_move']) || empty($_POST['quanity_at_move']) || !is_numeric($_POST['quanity_at_move'])) {
            $error .= "<span>Veuillez saisir le nombre de palette à déplacer</span></br>";
            $quantity_at_move = 0;
        }else {
            $quantity_at_move = App::secureInput($_POST['quanity_at_move']);
        }

        if (!isset($_POST['new_weg']) || empty($_POST['new_weg']) || !isset($_POST['new_shelf']) || empty($_POST['new_shelf'])) {
            $error .= "<span>Veuillez saisir le futur emplacement</span></br>";
        }else {
            $new_weg = App::secureInput($_POST['new_weg']);
            $new_weg = substr($new_weg, 1);

            $new_shelf = App::secureInput($_POST['new_shelf']);
            $new_shelf = substr($new_shelf, 1);
        

            if ($new_weg < 1 || $new_weg > 14) { 
                $error .= "<span>Le chiffre de l'allée indiqué est incorrecte !</span></br>";
                
            }elseif (($new_weg != 1 && $new_shelf > 22) && ($new_weg != 14 && $new_shelf > 22)) {
                $error .= "<span>Le rayon $new_shelf n'existe pas dans l'allée $new_weg</span></br>";

            }elseif(($new_weg == 1 && $new_shelf > 26) || ($new_weg == 14 && $new_shelf > 26)) {
                $error .= "<span>Le rayon $new_shelf n'existe pas dans l'allée $new_weg</span></br>";

            }elseif($new_weg == $palette['weg'] && $new_shelf == $palette['shelf']) {
                $error .= "<span>Vous ne pouvez pas saisir le même emplacement que celui actuellement utilisé !</span></br>";
            }
        }

        if ($quantity_at_move > $palette['quantity'] || $quantity_at_move < 1) {
            $error .= "<span>Le nombre de palette à déplacer est plus grand que le nombre de palettes total pour cette référence</span></br>";
        }

		if ($error === '') {
            $refExistAtTheLocation = self::refExistAtTheLocation($palette['reference'], $new_weg, $new_shelf);
			if ($quantity_at_move == $palette['quantity']) { // Verify if have move all palette

                if ($refExistAtTheLocation != false) { // Verify if one palette of the reference exist in the new location
                    
                    $newQuantity = $palette['quantity'] + $refExistAtTheLocation['quantity']; 
                    
                    self::deletePalette($refExistAtTheLocation['id']);// The pallet already in the new location is removed
                    self::updatePalette($id, $newQuantity, $new_shelf, $new_weg); // The pallet to be moved is updated by adding the amount of the pallet remove

				}else {
					self::updatePalette($id, $quantity_at_move, $new_shelf, $new_weg);
				}

            }else { // We check if the number of pallets is greater than 1 and less than the total number of pallets
                
                    $newQuantity = $palette['quantity'] - $quantity_at_move;
                    self::updatePalette($id, $newQuantity, $palette['shelf'], $palette['weg']);

					if ($refExistAtTheLocation != false) { // Verify if one palette of the reference exist in the new
						$newQuantity = $quantity_at_move + $refExistAtTheLocation['quantity'];

						$id = $refExistAtTheLocation['id'];
                        self::updatePalette($id, $newQuantity, $refExistAtTheLocation['shelf'], $refExistAtTheLocation['weg']);

					}else {
                        
						self::addPalette($palette['reference'], $new_weg, $new_shelf, $quantity_at_move);
					}
            }
			LogManager::addLog($_SESSION['auth']['id'], $palette['id'], 'Déplacement', "A" . $palette['weg'] . " | R" . $palette['shelf'] . " =>  A" . $new_weg . " | R" . $new_shelf);
			$_SESSION['flash']['success'] =  "<span>Palette déplacé avec success en A$new_weg | R$new_shelf</span>";
		}else {
			$_SESSION['flash']['danger'] = $error;
        }
        
        header('Location:' . $_SERVER['HTTP_REFERER']);
	}

    public static function getPalette() 
    {
        if (!isset($_GET['idpalette'])) {
            $id = "0";
        }else {
            $id = App::secureInput($_GET['idpalette']);
        }

        return self::getPaletteByID($id);
    }

    public static function listPalettes()
    {
        App::sessionFlash();
        if (isset($_POST['search']) || !empty($_POST['search'])){
            $search = App::secureInput($_POST['search']);
        }elseif(isset($_SESSION['search'])) {
            $search = $_SESSION['search'];
        }else {
            $search = "#";
        }

        $result = self::getPalettes($search);
        unset($_SESSION['search']);
        $_SESSION['search'] = $search;
        return $result;
    }

    public static function listPalettesByUser()
    {
        $today = date('Y-m-d');
        return self::getPalettesByUser($_SESSION['auth']['id'], $today);
    }

    public static function newPalette() {

        App::sessionFlash();
        unset($_SESSION['input']);

		$error = "";

        if (!isset($_POST['inputReference']) || empty($_POST['inputReference'])) {
            $error .= "<span>Veuillez saisir la référence</span></br>";
        }else {
            $reference = App::secureInput($_POST['inputReference']);
            $reference = strtoupper($reference);
        }

        if (!isset($_POST['weg']) || empty($_POST['weg']) || !isset($_POST['shelf']) || empty($_POST['shelf'])) {
            $error .= "<span>Veuillez saisir le futur emplacement</span></br>";
        }else {
            $new_weg = App::secureInput($_POST['weg']);
            $new_weg = substr($new_weg, 1);

            $new_shelf = App::secureInput($_POST['shelf']);
            $new_shelf = substr($new_shelf, 1);
        

            if ($new_weg < 1 || $new_weg > 14) { 
                $error .= "<span>Le chiffre de l'allée indiqué est incorrecte !</span></br>";
                
            }elseif (($new_weg != 1 && $new_shelf > 22) && ($new_weg != 14 && $new_shelf > 22)) {
                $error .= "<span>Le rayon $new_shelf n'existe pas dans l'allée $new_weg</span></br>";

            }elseif(($new_weg == 1 && $new_shelf > 26) || ($new_weg == 14 && $new_shelf > 26)) {
                $error .= "<span>Le rayon $new_shelf n'existe pas dans l'allée $new_weg</span></br>";

            }
        }

        if (!isset($_POST['quantity']) || $_POST['quantity'] < 0 || !is_numeric($_POST['quantity'])) {
           $error .= "<span>La quantité de platte est incorrecte !</span>";
        }else {
             $quantity = App::secureInput($_POST['quantity']);
        }

        if (self::getReference($reference) == false) {
            $error .= "<span>La référence n'est pas enregisté souhaité vous l'ajouter ?</br> <a href='index.php?action=addreference' class='p-2 h5 badge badge-success'>Oui</a> | <a href='#' class='p-2 h5 badge badge-danger'>Non</a></span></br>";
            
            $_SESSION['input'] = array('reference' => $reference, 'qunatité' => $quantity);
        }

	 	if ($error === "") {

			$refExistAtTheLocation = self::refExistAtTheLocation($reference, $new_weg, $new_shelf);

			if ($refExistAtTheLocation != false) { //If you add a pallet by selecting a location already taken by a pallet of the same reference you add just the two quantities

				$newQuantity = $refExistAtTheLocation['quantity'] + $quantity;
				$id = $refExistAtTheLocation['id'];
                
                self::updatePalette($id, $newQuantity, $refExistAtTheLocation['shelf'], $refExistAtTheLocation['weg']);

			} else {
				$id = self::addPalette($reference, $new_weg, $new_shelf, $quantity);
            }

            LogManager::addLog($_SESSION['auth']['id'], $id, 'Création', "A" . $new_weg . " | R" . $new_shelf);
			$_SESSION['flash']['success'] = "<span>La palette à bien été ajouté !</span>";
	 	}else {
            $_SESSION['flash']['danger'] = $error;
         }
         header('Location: index.php');
    }
    
    public static function newReference()
    {
        App::sessionFlash();
        self::addReference($_SESSION['input']['reference']);
        $_SESSION['flash']['success'] = '<span>Référence àjouté !</span>';
        header('Location:' . $_SERVER['HTTP_REFERER']);
    }

    public static function logByPalette()
    {
        return self::getLogByPalette($_GET['idpalette']);
    }
}