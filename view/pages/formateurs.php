<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../view/bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../view/style/components.css">
    <link rel="stylesheet" href="../../view/style/admins.css">
    <link rel="icon" href="../../view/assets/fav.png" type="image/png">
    <title>espace admin</title>
	<script src="https://kit.fontawesome.com/81aebbec1d.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php 
        require_once('../../view/components/sideBar.php');
        require_once('../../view/components/header.php');
    ?>
    
    <main id="content">
        <section class="content-header d-flex justify-content-between align-items-center mb-4">
            <div class="h4">Formateurs</div>
            <div>
                <button class="btn btn-danger" disabled style="border-radius: 50px;" id="deleteBtnF"><i class="fa-solid fa-trash me-2"></i> Delete</button>
                <div class="btn btn-primary" style="border-radius: 50px;" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fa-solid fa-plus"></i> Nouveau</div>
            </div>
        </section>
        <section>
            <table class="table " style="width: 100%;">
                <tr style="border: none;">
                    <th style="border-top-right-radius: 5px; border-top-left-radius: 5px; border: none;" colspan="4">
                        <form action="formateursController.php" method="get" class="position-relative">
                            <input type="text" placeholder="Recherche..." name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" class="search-box">
                            <button type="submit" style="border: none; background-color: transparent; position: absolute; right: 20px; top: 10px;"><i class="fa-solid fa-magnifying-glass" style="color: rgb(199, 199, 199);"></i></button>
                        </form>
                    </th>
                </tr>
                <tr>
                <?php
                if (isset($_GET['search'])) {
                    $length = strlen($_GET['search']);
                    $search = strtolower($_GET['search']);
                    $newArray = [];
                    foreach ($users as $user) {
                        if (
                            $search == substr(strtolower($user->id), 0, $length) ||
                            $search == substr(strtolower($user->nom), 0, $length) ||
                            $search == substr(strtolower($user->prenom), 0, $length)
                            ) {
                            $newArray[] = $user;
                        }
                    }
                    $users = $newArray;
                }
                ?>
                    <th style="width: 20px;"><input type="checkbox" id="selectAllF" <?= count($users) == 0 ? 'disabled' : '' ?>></th>
                    <th></th>
                    <th>Formateur</th>
                    <th style="text-align: end; padding-right: 30px;">actions</th>
                </tr>
                <?php
                    foreach ($users as $user) {
                        ?>
                        <tr>
                            <td class="py-3"><input class="checkbox" onclick="checkedUpdate('<?= $user->id ?>', 'form')" type="checkbox" id="<?= $user->id ?>"></td>
                            <td style="width: 50px;" class="py-3">
                                <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                    <div class="rounded-circle d-flex justify-content-center align-items-center" style="color: white; background-color: <?= $user->color ?>; width: 30px; height: 30px; cursor: pointer;"><?= strtoupper($user->prenom[0]) ?></div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column justify-content-start" style="height: 100%;">
                                    <div>
                                        <?= ucfirst(strtolower($user->prenom)) , ' ' , ucfirst(strtolower($user->nom)) ?>
                                    </div>
                                    <div class="text-secondary" style="font-size: 12px;">
                                        <?= $user->id ?>
                                    </div>
                                </div>
                            </td>
                            <!-- style="width: 10px; white-space: nowrap;" -->
                            <td style="text-align: end; padding-right: 30px;" class="py-3">
                                <span class="h5" style="cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false">...</span>
                                <ul class="dropdown-menu">
                                    <a href="emploiController.php?form=<?= $user->id ?>"><li class="dropdown-item"><i class="fa-solid fa-calendar-days me-2"></i> emplois du temps</li></a>
                                    <li class="dropdown-item" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#groups<?= $user->id ?>"><i class="fa-solid fa-users-rectangle me-2"></i> groupes</li>
                                    <li class="dropdown-item" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#addGrp<?= $user->id ?>"><i class="fa-solid fa-plus me-2"></i> ajouter groupe</li>
                                    <li class="dropdown-item" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modify<?= $user->id ?>"><i class="fa-solid fa-user-pen me-2"></i> modifier</li>
                                    <li class="text-danger dropdown-item" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modal<?= $user->id ?>"><i class="fa-solid fa-trash me-2"></i> supprimer</li>
                                </ul>
                            </td>
                        </tr>
                        <div class="modal fade"  id="groups<?= $user->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog  modal-fullscreen modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">formateur <?= ucfirst(strtolower($user->prenom)) , ' ' , ucfirst(strtolower($user->nom)) ?></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group list-group-flush">
                                            <?php
                                            $thiscombos = [];
                                            foreach ($combos as $combo) {
                                                if ($combo->formateur == $user->id) {?>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <?php foreach($groups as $group) {
                                                    if ($combo->groupe == $group->id) {
                                                        echo $group->titre;
                                                    }
                                                    } ?>
                                                    <a onclick="return confirm('t\'es sure?')" href="../../models/combo/delete.php?id=<?= $combo->id ?>"><i class="fa-solid text-danger fa-trash me-2" style="cursor: pointer;" title="supprimer"></i></a>
                                                </li>
                                            <?php $thiscombos[] = $combo;}} ?>
                                        </ul>
                                        <?php if (count($thiscombos) == 0) { ?>
                                            <div style="width: 100%; color:gray; display: flex; justify-content: center; align-items: center">aucun groupe n'est encore concerné</div>
                                        <?php } ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="addGrp<?= $user->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">formateur <?= ucfirst(strtolower($user->prenom)) , ' ' , ucfirst(strtolower($user->nom)) ?></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="../../models/combo/create.php" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="form" value="<?= $user->id ?>">
                                            <select class="mb-3 form-control" name="group" required>
                                                <option value="">selectionner un groupe</option>
                                                <?php
                                                $newGroups = [];
                                                foreach ($groups as $group) {  
                                                    foreach ($combos as $combo) {  
                                                        if ($group->id == $combo->groupe && $user->id == $combo->formateur) {
                                                            continue 2;
                                                        }
                                                    }
                                                    $newGroups[] = $group;
                                                }
                                                foreach ($newGroups as $group) {  
                                                    echo "<option value='$group->id'>$group->titre</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
                                            <button type="submit" name="addCombo" class="btn btn-primary">ajouter</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modal<?= $user->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Suppression</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        tu es sûr de supprimer <?= ucfirst(strtolower($user->prenom)) , ' ' , ucfirst(strtolower($user->nom)) ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
                                        <a href="../../models/user/delete.php?id=<?= $user->id ?>&role=user"><button type="button" class="btn btn-danger">Supprimer</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modify<?= $user->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modification</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="../../models/user/update.php" method="post" id="form<?= $user->id ?>">
                                        <div class="modal-body">
                                            <div class="mb-4">
                                                remplissez les champs que vous souhaitez modifier.
                                            </div>
                                            <input type="hidden" name="user" value="<?= $user->id ?>">
                                            <input type="hidden" name="role" value="<?= $user->role ?>">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control form<?= $user->id ?>"  name="id" placeholder="id" value="<?= $user->id ?>" >
                                                <label for="floatingInput">id</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control form<?= $user->id ?>"  name="nom" value="<?= $user->nom ?>" placeholder="nom" >
                                                <label for="floatingInput">Nom</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control form<?= $user->id ?>"  name="prenom" value="<?= $user->prenom ?>" placeholder="prenom" >
                                                <label for="floatingInput">Prenom</label>
                                            </div>
                                            <div class="form-floating">
                                                <input type="password" class="form-control form<?= $user->id ?>"  name="password" placeholder="Password" >
                                                <label for="floatingPassword">Password</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
                                            <button type="button" onclick="validate('form<?= $user->id ?>')" class="btn btn-primary">Modifier</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
            </table>
        </section>
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Ajout</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="../../models/user/create.php" method="post">
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control"  name="id" placeholder="id" required>
                                <label for="floatingInput">id</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control"  name="nom" placeholder="nom" required>
                                <label for="floatingInput">Nom</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control"  name="prenom" placeholder="prenom" required>
                                <label for="floatingInput">Prenom</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control"  name="password" placeholder="Password" required>
                                <label for="floatingPassword">Password</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
                            <button type="submit" name="addUser" class="btn btn-primary">ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['message'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                utilisateur ajouté avec succès
                <a href="formateursController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php } elseif (isset($_GET['acc'])) { ?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                il y a déjà un utilisateur avec le même id.
                <a href="formateursController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php } elseif (isset($_GET['delete'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                utilisateur(s) a été supprimé.
                <a href="formateursController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php } elseif (isset($_GET['fields'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                les champs sont vides.
                <a href="formateursController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php } elseif (isset($_GET['id'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                il existe déjà un compte avec cet id.
                <a href="formateursController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php } elseif (isset($_GET['updated'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                utilisateur modifié avec succès.
                <a href="formateursController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php }?>
    </main>

    <!-- <script src="../../view/bootstrap-5.3.2-dist/js/bootstrap.min.js"></script> -->
    <script src="../../view/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../view/script/script.js"></script>
    <script>
        const validate = (id) => {
            let valid = true;
            const myform = document.getElementById(id);
            const inputs = document.querySelectorAll(`.${id}`);
            inputs.forEach(input => valid = input.value.length == 0 ? false : valid);
            valid ? myform.submit() : window.location.href = "formateursController.php?fields=empty";
        }
    </script>
</body>
</html>