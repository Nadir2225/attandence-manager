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
            <div class="h4">Gestionnaires</div>
            <div>
                <button class="btn btn-danger" disabled style="border-radius: 50px;" id="deleteBtnG"><i class="fa-solid fa-trash me-2"></i> Delete</button>
                <div class="btn btn-primary" style="border-radius: 50px;" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fa-solid fa-plus"></i> Nouveau</div>
            </div>
        </section>
        <section>
            <table class="table " style="width: 100%;">
                <tr style="border: none;">
                    <th style="border-top-right-radius: 5px; border-top-left-radius: 5px; border: none;" colspan="5">
                        <form action="adminsController.php" method="get" class="position-relative">
                            <input type="text" placeholder="Recherche..." name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" class="search-box">
                            <button type="submit" style="border: none; background-color: transparent; position: absolute; right: 20px; top: 10px;"><i class="fa-solid fa-magnifying-glass" style="color: rgb(199, 199, 199);"></i></button>
                        </form>
                    </th>
                </tr>
                <?php
                if (isset($_GET['search'])) {
                    $length = strlen($_GET['search']);
                    $search = strtolower($_GET['search']);
                    $newArray = [];
                    foreach ($admins as $admin) {
                        if (
                            $search == substr(strtolower($admin->id), 0, $length) ||
                            $search == substr(strtolower($admin->nom), 0, $length) ||
                            $search == substr(strtolower($admin->prenom), 0, $length)
                            ) {
                                $newArray[] = $admin;
                        }
                    }
                    $admins = $newArray;
                }
                ?>
                <tr>
                    <th style="width: 20px;"><input type="checkbox" id="selectAllG" <?= count($admins) == 0 ? 'disabled' : '' ?>></th>
                    <th></th>
                    <th>Gestionnaire</th>
                    <th style="text-align: end; padding-right: 30px;">actions</th>
                </tr>
                <?php
                    foreach ($admins as $admin) {
                        ?>
                        <tr>
                            <td class="py-3"><input class="checkbox" onclick="checkedUpdate('<?= $admin->id ?>', 'gest')" type="checkbox" id="<?= $admin->id ?>"></td>
                            <td style="width: 50px;" class="py-3">
                                <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                    <div class="rounded-circle d-flex justify-content-center align-items-center" style="color: white; background-color: <?= $admin->color ?>; width: 30px; height: 30px; cursor: pointer;"><?= strtoupper($admin->prenom[0]) ?></div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column justify-content-start" style="height: 100%;">
                                    <div>
                                        <?= ucfirst(strtolower($admin->prenom)) , ' ' , ucfirst(strtolower($admin->nom)) ?>
                                    </div>
                                    <div class="text-secondary" style="font-size: 12px;">
                                        <?= $admin->id ?>
                                    </div>
                                </div>
                            </td>
                            <!-- style="width: 10px; white-space: nowrap;" -->
                            <td style="text-align: end; padding-right: 30px;" class="py-3">
                                <span class="h5" style="cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false">...</span>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modify<?= $admin->id ?>"><i class="fa-solid fa-user-pen me-2"></i> modifier</li>
                                    <li class="dropdown-item text-danger" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modal<?= $admin->id ?>"><i class="fa-solid fa-trash me-2"></i> supprimer</li>
                                </ul>
                            </td>
                        </tr>
                        <div class="modal fade" id="modal<?= $admin->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Suppression</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        tu es sûr de supprimer <?= ucfirst(strtolower($admin->prenom)) , ' ' , ucfirst(strtolower($admin->nom)) ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
                                        <a href="../../models/user/delete.php?id=<?= $admin->id ?>&logout=<?= $admin->id == $currentUser->id ? 'true' : 'false' ?>"><button type="button" class="btn btn-danger">Supprimer</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modify<?= $admin->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modification</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="../../models/user/update.php" method="post" id="form<?= $admin->id ?>">
                                        <div class="modal-body">
                                            <div class="mb-4">
                                                remplissez les champs que vous souhaitez modifier.
                                            </div>
                                            <input type="hidden" name="user" value="<?= $admin->id ?>">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control form<?= $admin->id ?>"  name="id" placeholder="id" value="<?= $admin->id ?>" >
                                                <label for="floatingInput">id</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control form<?= $admin->id ?>"  name="nom" value="<?= $admin->nom ?>" placeholder="nom" >
                                                <label for="floatingInput">Nom</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control form<?= $admin->id ?>"  name="prenom" value="<?= $admin->prenom ?>" placeholder="prenom" >
                                                <label for="floatingInput">Prenom</label>
                                            </div>
                                            <div class="form-floating">
                                                <input type="password" class="form-control form<?= $admin->id ?>"  name="password" placeholder="Password" >
                                                <label for="floatingPassword">Password</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
                                            <button type="button" onclick="validate('form<?= $admin->id ?>')" class="btn btn-primary">Modifier</button>
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
                            <button type="submit" name="addAdmin" class="btn btn-primary">ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['message'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                utilisateur ajouté avec succès
                <a href="adminsController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php } elseif (isset($_GET['acc'])) { ?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                il y a déjà un utilisateur avec le même id.
                <a href="adminsController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php } elseif (isset($_GET['delete'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                utilisateur(s) a été supprimé.
                <a href="adminsController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php } elseif (isset($_GET['fields'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                les champs sont vides.
                <a href="adminsController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php } elseif (isset($_GET['id'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                il existe déjà un compte avec cet id.
                <a href="adminsController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php } elseif (isset($_GET['updated'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                utilisateur modifié avec succès.
                <a href="adminsController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
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
            valid ? myform.submit() : window.location.href = "adminsController.php?fields=empty";
        }
    </script>
</body>
</html>