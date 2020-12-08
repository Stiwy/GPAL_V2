<?php

class App 
{
    public static function return() 
    {
        header('Location: index.php?action=search');
    }

    public static function sessionFlash() {
        unset($_SESSION['flash']);

        if (session_status() == PHP_SESSION_NONE){session_start();}
    }

    public static function flash()
    {
        if(isset($_SESSION['flash'])) :
            foreach($_SESSION['flash'] as $type => $message) : 
        
                if ($type ===  'warning') {
                    $messageType = 'Attention !';
                }elseif ($type ===  'danger') {
                    $messageType = 'Erreur !';
                }elseif ($type ===  'success') {
                    $messageType = 'Succès !';
                }elseif ($type ===  'info') {
                    $messageType = 'Info :';
                } ?>
        
                <div class="alert alert-<?= $type ?> alert-dismissible fade show" role="alert">
                    <strong><?= $messageType ?></strong> <?= $message ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endforeach ; 
        endif;
    }

    /**
     * secureInput
     * Removes special character and target spaces to avoid security vulnerabilities;
     * @param  mixed $target
     * @return void
     */
    public static function secureInput($target) {
        $target = htmlspecialchars($target); 
        $target = trim($target);
        $target = strip_tags($target); 

        return $target;
    }
}