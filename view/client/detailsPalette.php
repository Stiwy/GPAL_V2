<?php $logs = Palettes::logByPalette() ?>
<section id="get_palette_by_id_section">
    <div class="gpbi_body_section">
        <p class="gpbi_title_section">Information de la palette</p>
        <div class="gpbi_row_for_computer">
            <img class="palette_image" src="public/image/palette.png" alt="Icons de palette de transport">
            <div class="gpbi_col">
                <h2 class="gpbi_h2">Réference</h2>
                <p class="gpbi_p"><?=$getPaletteById['reference']?></p>
            </div>
            <div class="gpbi_col">
                <h2 class="gpbi_h2">Emplacement</h2>
                <p class="gpbi_p">A<?=$getPaletteById['weg']?>  R<?=$getPaletteById['shelf']?></p>
            </div>
            <div class="gpbi_col">
                <h2>|</h2>
            </div>
            <div class="gpbi_col">
                <h2 class="gpbi_h2">Quantité</h2>
                <p class="gpbi_p"><?=$getPaletteById['quantity']?></p>
            </div>
        </div>
        <div class="gpbi_row">
            <img class="palette_image" src="public/image/palette.png" alt="Icons de palette de transport">
            <div class="gpbi_col">
                <h2 class="gpbi_h2">Réference</h2>
                <p class="gpbi_p"><?=$getPaletteById['reference']?></p>
            </div>
        </div>
        <div class="gpbi_row">
            <div class="gpbi_col">
                <h2 class="gpbi_h2">Emplacement</h2>
                <p class="gpbi_p">A<?=$getPaletteById['weg']?>  R<?=$getPaletteById['shelf']?></p>
            </div>
            <div class="gpbi_col">
                <h2>|</h2>
            </div>
            <div class="gpbi_col">
                <h2 class="gpbi_h2">Quantité</h2>
                <p class="gpbi_p"><?=$getPaletteById['quantity']?></p>
            </div>
        </div>
    </div>

    <div id="gpbi_move_palette_section" class="gpbi_move_palette_section">
        <p class="gpbi_title_section">Déplacer des palettes</p>
        <form action="index.php?action=movepalette&amp;idpalette=<?=$getPaletteById['id']?>" method="POST">
            <div class="input_quanity_at_move">
                <label for="quanity_at_move">Nombre de palette à déplacer</label>
                <input type="number" inputmode="numeric" name="quanity_at_move" id="quanity_at_move" placeholder="Quantité maximum <?=$getPaletteById['quantity']?>"  value="1"  required>
            </div>
            <div class="input_modif_location">
                <label for="new_location">Selectionner l'emplacement</label>
                <select name="new_weg" id="new_weg" class="new_weg" onfocus="getValueSelctWeg()" required>
                    <option selected="A<?=$getPaletteById['weg']?>">A<?=$getPaletteById['weg']?></option>
                    <option>A1</option>
                    <option>A2</option>
                    <option>A3</option>
                    <option>A4</option>
                    <option>A5</option>
                    <option>A6</option>
                    <option>A7</option>
                    <option>A8</option>
                    <option>A9</option>
                    <option>A10</option>
                    <option>A11</option>
                    <option>A12</option>
                    <option>A13</option>
                    <option>A14</option>
                </select>
                <select name="new_shelf" id="new_shelf" class="new_shelf" onfocus="getPaletteById()" required>
                    <option selected="R<?=$getPaletteById['shelf']?>">R<?=$getPaletteById['shelf']?></option>
                    <option>R1</option>
                    <option>R2</option>
                    <option>R3</option>
                    <option>R4</option>
                    <option>R5</option>
                    <option>R6</option>
                    <option>R7</option>
                    <option>R8</option>
                    <option>R9</option>
                    <option>R10</option>
                    <option>R11</option>
                    <option>R12</option>
                    <option>R13</option>
                    <option>R14</option>
                    <option>R15</option>
                    <option>R16</option>
                    <option>R17</option>
                    <option>R18</option>
                    <option>R19</option>
                    <option>R20</option>
                    <option>R21</option>
                    <option>R22</option>
                    <option id="r23">R23</option>
                    <option id="r24">R24</option>
                    <option id="r25">R25</option>
                    <option id="r26">R26</option>
                </select>
            </div>
            <input type="submit" class="button_modif_palette" value="Valider">
        </form>
    </div>
    <div id="gpbi_update_quantity_section" class="gpbi_update_quantity_section">
        <p class="gpbi_title_section">Modifier la quantitée</p>
        <form action="index.php?action=updatequantity&amp;idpalette=<?=$getPaletteById['id']?>" method="POST">
            <div class="input_new_quanity">
                <label for="new_quanity">Nouvelle quantité</label>
                <input type="number" inputmode="numeric" name="new_quantity" id="new_quantity" placeholder="Quantitée actuel <?=$getPaletteById['quantity']?>"required>
            </div>
            <input type="submit" class="button_modif_palette" value="Valider">
        </form>
    </div>

    <?php if ($logs != false ) : ?>
    <div class="gpbi_body_section">
        <p class="gpbi_title_section">Dérnières modifications</p>
        
        <table id="table" class="table text-center">
            <thead id="thead">
                <tr>
                    <th>Utilisateur</th>
                    <th>Modification</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody id="tbody">
                <?php foreach($logs as $log) : ?>
                    <tr>
                        <td><?= $log['username']?></td>
                        <td><?= $log['action'] . " " . $log['info']?></td>
                        <td><?= $log['date']?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</section>

<div id="div_button_nav_menu">
    <button id="buttonMovePalette" class="buttonMovePalette" onclick="buttonMovePalette()">Déplacer</button>
    <button id="updateQuantity" class="updateQuantity" onclick="buttonUpdateQuantity()">Modifier la quantité</button>
</div>

