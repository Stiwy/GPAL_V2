<?php $listpalettes = Palettes::listPalettesByUser();?>
<section class="container-fluid">
    
<h1 class="h3 mb-3 font-weight-normal my-4 text-center text-primary">Modifié aujourd'hui par <span class="font-weight-bold"><?= $_SESSION['auth']['username'] ?></span></h1>

    <div class="row justify-content-around text-white text-center">
        <div class="badge badge-warning col-6 col-md-3 mb-3">
            <p><em>Nombre</em></p>
            <h5><?= count($listpalettes) ?></h5>
        </div>
        <div class="badge badge-success col-6 col-md-3 mb-3">
            <p><em>Dernière</em></p>
            <h5><?= $listpalettes[0]['reference'] ?></h5>
        </div>
    </div>
    
    <table id="table" class="table text-center">
        <thead id="thead">
            <tr>
                <th>Ref</th>
                <th>Loc</th>
                <th>Qte</th>
            </tr>
        </thead>
        <tbody id="tbody">
            <?php foreach($listpalettes as $palette) : ?>
                <tr onclick="getPalette(<?= $palette['id'] ?>)">
                    <td><?= $palette['reference'] ?></td>
                    <td><?= 'A' . $palette['weg'] . ' | R' . $palette['shelf'] ?></td>
                    <td><?= $palette['quantity'] ?></td>
                </tr>
            <?php endforeach ; ?>
        </tbody>
    </table>
</section>

<p class="ml-1"><a class="badge badge-warning" href="http://bor.santedistri.com/gpal/guide.pdf">Accerder au guide d'utilisation</a></p>
