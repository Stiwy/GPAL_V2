<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GPAL | Robé Médical</title>

    <link rel="shortcut icon" type="image/png" href="public/image/palette.png"/>

    <!-- CDN Bootstrap V 4.5.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>


    <!-- CSS -->
    <link rel="stylesheet" href="public/css/core/table.css">
    
    <link rel="stylesheet" type="text/css" href="public/css/addPalette.css">
    <link rel="stylesheet" type="text/css" href="public/css/getPaletteById.css">
    <link rel="stylesheet" type="text/css" href="public/css/login.css">
    <link rel="stylesheet" type="text/css" href="public/css/paletteManager.css">
    <link rel="stylesheet" type="text/css" href="public/css/template.css">
</head>
<body>
    <header>
        <nav id="navbar" class="navbar">
            <?php if (isset($_SESSION['auth'])) : ?>
                <a class="navbar-brand d-none d-md-block text-white"><img src="public/image/palette.png" alt="" width="50px">GESTION DES PALETTES</a>
                <form class="d-flex" method="post" action="index.php?action=search">
                    <input class="form-control col-8" type="search" name="search" placeholder="Référence..." aria-label="Search">
                    <button class="btn btn-outline-light col-4" type="submit">Chercher</button>
                </form>
            </nav>
            <div id="nav" class="row border-bottom border-dark">
                <div role="button" class="col-3 p-2 border-right border-dark" onclick="index()">
                    <img src="public/svg/home.svg" alt="">
                </div>
                <div role="button" class="col-3 p-2 border-right border-dark" onclick="returnIndex()">
                    <img src="public/svg/return.svg" alt="">
                </div>
                <div role="button" class="col-3 p-2 border-right border-dark" data-toggle="modal" data-target="#addPalette">
                    <a data-toggle="modal" data-target="#addPalette"><img src="public/svg/plus.svg" alt=""></a>
                </div>
                <div role="button" class="col-3 p-2">
                    <a href="index.php?action=logout"><img src="public/svg/logout.svg" alt=""></a>
                </div>
            </div>
            <?php else : ?>
                <a class="navbar-brand text-white"><img src="public/image/palette.png" alt="" width="50px">GESTION DES PALETTES</a>
            </nav>
            <?php endif; ?>
    </header>

    <!-- Modal -->
    <div class="modal fade" id="addPalette" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter une palette</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="mb-3 font-weight-normal text-primary">Ajouter une palette</h3>

                <form method="post" action="index.php?action=addpalette">

                    <div  class="form-group">
                        <label for="inputReference">Référence de la palette</label><br/>
                        <input type="text" name="inputReference" class="form-control" <?= (isset($_SESSION['input']['reference'])) ? 'value="' . $_SESSION['input']['reference'] . '"' : ''; ?> require>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="weg">Allée</label><br>
                            <select name="weg" id="weg" class="form-control" onclick="getValueSelctWeg()">
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
                        </div>
                        <div class="col-6">
                            <label for="shelf">Rayon</label><br>
                            <select name="shelf" id="shelf" class="form-control" onclick="getValueSelctWeg()">
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
                    </div>

                    <div class="form-group">
                        <label for="inputQuantity">Ajouter la quantitée de produits</label><br/>
                        <input type="number" inputmode="numeric" name="quantity" id="inputQuantity" class="form-control" placeholder="Saisissez la quantitée" <?= (isset($_SESSION['input']['quantity'])) ? 'value="' . $_SESSION['input']['quantity'] . '"' : 'value="1"'; ?> >
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <?php App::flash() ?>

    <?= $content ?>

    <!-- JS -->
    <script type="text/javascript" src="public/js/stock.js"></script>
</body>
</html>