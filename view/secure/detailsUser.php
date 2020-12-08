<?php $userLog = Users::userLog($_GET['iduser']) ?>
<section class="container-fluid">
    <h1 class="h3 mb-3 font-weight-normal text-center my-4 text-primary">Suivi d'activité</h1> 
<!-- Enregister l'url dans une session pour le boutton retour 
    Gestion des session
    Mise en page du tableau reduire la taille de police
    Afiicher l'ancienne référence d'une palette supprimer
    Cookie limiter à 1jours
-->
    <div class="row text-center my-4">
        <div class="col-6 col-md-2">
            <h6 class="text-primary">Profil ciblé</h6>
            <h5><span class="badge badge-secondary text-white"><?= $userLog['0']['username']?></span></h5>
        </div>
        <div class="col-6 col-md-2">
            <h6 class="text-primary">ID</h6>
            <h5><span class="badge badge-secondary text-white"><?= $userLog['0']['id_user']?></span></h5>
        </div>
        <div class="text-center d-block d-md-none my-4 offset-2 col-8 border-bottom border border-secondary"></div>
        <div class="col-6 col-md-4">
            <h6 class="text-primary">Dernière connexion</h6>
            <h5><span class="badge badge-secondary text-white"><?= $userLog['0']['last_login_date']?></span></h5>
        </div>
        <div class="col-6 col-md-4">
            <h6 class="text-primary">Action</h6>
            <button class="btn btn-danger btn-sm">Supprimer</button>
        </div>
    </div>

    <table id="table" class="table text-center">
        <thead>
            <tr id="thead">
                <th>Ref</th>
                <th>Modif</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody id="tbody">
            <?php foreach(Users::userLog($_GET['iduser']) as $log) : ?>
                <tr onclick="getPalette(<?= $log['id_palette'] ?>)">
                    <td <?= ($log['reference'] === null) ?  'class="text-danger font-weight-bold">Supprimer' : '>' . substr($log['reference'], 0, 10) ;?></td>    
                    <td><?= $log['action'] . ' ' . $log['info']?></td>   
                    <td><?= $log['date_log']?></td> 
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>