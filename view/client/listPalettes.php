<?php $listpalettes = Palettes::listPalettes() ?>
<section class="container-fluid">
    <h1 class="h5 my-3 font-weight-normal text-info text-center">Référence correspondant à "<?= $_SESSION['search'] ?>"</h1>

    <div id="headerpalettePage">
        <?= (count($listpalettes) == 0) ? '<p class="badge badge-warning">Aucun résultat trouvé !</p>' : "<p class='badge badge-success'>" . count($listpalettes) ." Résultat( trouvé(s)</p>" ; ?>
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