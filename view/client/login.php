<section class="container">
    <div class="col align-self-center mt-5  offset-md-3 col-md-6">
        <div class="mt-5 text-center">
            <img src="public/image/palette.png" alt="" width="100px">
            <h1 class="h3 mb-3 font-weight-normal"><?= (isset($_GET['admin'])) ? 'Administration' : 'Connexion'; ?></h1>
            <p><em id="sub-title-login">Application de gestion des stock de palettes</em><br> <?= (isset($_GET['admin'])) ? 'Saisir votre identifiant' : 'Séléctionner un profils et connectez-vous.'; ?></p>
        </div>
        
        <form class="was-validated" method="post" action="index.php">
            <?php if (isset($_GET['admin'])) : ?>
                <div class="mb-3">
                    <div class="form-label-group">
                        <input name="userName" type="text" class="form-control  is-invalid" minlength="4" maxlength="20" placeholder="Identifiant" aria-describedby="validatedInputGroupPrepend" required="">
                    </div>
                </div>
            <?php else : ?>
                <div class="mb-3">
                    <select class="custom-select" name="userName" required>
                        <option value="">Choisir un profil</option>
                        <?php foreach(Users::listUsers() as $user) : ?>
                            <option value="<?=$user['username'] ?>"><?=$user['username'] ?></option>
                        <?php endforeach ; ?>
                    </select>
                    <div class="invalid-feedback">Veuillez séléctionner un profil pour vous connecter</div>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <div class="form-label-group">
                    <input   name="userPassword" type="password" id="inputPassword" class="form-control  is-invalid" minlength="4" placeholder="Votre mot de passe" aria-describedby="validatedInputGroupPrepend" required="">
                </div>
            </div>
            <!--- pattern="[0-9]{4,6}" --->
            <button class="btn btn-lg btn-primary btn-block" type="submit">Se connecter</button>
        </form>

        <div class="mt-5">
            <?= (isset($_GET['admin'])) ? '<a class="badge badge-pill badge-warning" href="index.php">Vous êtes utilisateur ?</a>' : '<a class="badge badge-pill badge-danger" href="index.php?admin">Vous êtes administarteur ?</a>'; ?>
        </div>
    </div>
</section>