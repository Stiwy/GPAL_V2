<?php unset($_SESSION['search']) ?>
<section>

  <h1 class="h3 mb-3 font-weight-normal text-center my-4 text-primary">Espace d'administration</h1> 

  
  <!-- Button trigger modal -->
  <div class="row">
    <button type="button" class="btn btn-sm btn-primary offset-9" data-toggle="modal" data-target="#addMember">Ajouter</button>
  </div>
  

  <!-- Modal -->
  <div class="modal fade" id="addMember" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ajouter un membre</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h3 class="mb-3 font-weight-normal text-primary">Ajouter un utilisateur à l'application</h3>
          <p class="text-secondary">Pour les utilisateurs le mot de passe est générer automatiquement</p>

          <form method="post" action="index.php?action=adduser">
              
            <div class="custom-switch mb-4">
              <input name="admin" type="checkbox" class="custom-control-input" id="customSwitch1" onclick="isAdmin()">
              <label id="isAdmin" class="custom-control-label" for="customSwitch1">Permissions Admin ?</label>
            </div>

              <div class="mb-3">
                  <input type="text" name="newUser" class="form-control" id="validationTextarea" placeholder="Prénom de l'utilisateur" minlength="3" aria-describedby="usernameHelp" required/>
                  <small id="usernameHelp" class="form-text text-danger"><strong>Obligatoire !</strong></small>
              </div>

              <div id="adminPass" class="mb-3 d-none">
                <div class="form-label-group">
                    <input name="password" type="password" id="password" class="form-control" minlength="4" placeholder="Mot de passe" aria-describedby="passwordHelp">
                    <small id="passwordHelp" class="form-text text-danger"><strong>Obligatoire !</strong> Création manuel du mot de passe obligatoire pour les nouveau admin !</small>
                </div>
            </div>

            <div id="adminConfirmPass" class="mb-3 d-none">
                <div class="form-label-group">
                    <input name="passwordConfirm" type="password" id="passwordConfirm" class="form-control" minlength="4" placeholder="Confirmer le mot de passe" aria-describedby="passwordConfirmHelp">
                    <small id="passwordConfirmHelp" class="form-text text-danger"><strong>Obligatoire !</strong></small>
                </div>
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Ajouter</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <p class="h5 font-weight-italic text-secondary border border-top">Vue global des Utilisateurs</p>
  <table id="table" class="table text-center mb-5">
    <thead id="thead">
        <tr>
            <th>Nom</th>
            <th>Connexion</th>
            <th>Modification</th>
        </tr>
    </thead>
    <tbody id='tbody'>
      <?php foreach(Users::listUsers() as $user) : ?>
        <tr  <?= (Users::countLog($user['id']) == 0 &&  $user['username'] != "Bureau") ? 'class="font-weight-bold text-danger"': ''; ?> onclick="getUser(<?= $user['id'] ?>)">
          <td><?= $user['username'] ?></td>
          <td><?= $user['last_login_date'] ?></td>
          <td><?= Users::countLog($user['id']) ?></td> 
        </tr>
      <?php endforeach; ?>
    </tbody>
</table>

  <p class="h5 font-weight-italic text-secondary border border-top">Vue global des Admin </p>
  <table id="table" class="table text-center">
            <thead id="thead" class="bg-danger">
                <tr>
                    <th>Nom</th>
                    <th>Connexion</th>
                    <th>Modification</th>
                </tr>
            </thead>
            <tbody id='tbody'>
              <?php foreach(Users::listUsers('admin') as $admin) : ?>
                <tr  onclick="getUser(<?= $admin['id'] ?>)">
                  <td><?= $admin['username'] ?></td>
                  <td><?= $admin['last_login_date'] ?></td>
                  <td><?= Users::countLog($admin['id']) ?></td> 
                </tr>
              <?php endforeach; ?>
            </tbody>
        </table>
</section>