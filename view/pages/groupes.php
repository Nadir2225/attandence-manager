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
            <div class="h4">Groupes</div>
            <div>
                <button class="btn btn-danger" disabled style="border-radius: 50px;" id="deleteBtnGrp"><i class="fa-solid fa-trash me-2"></i> Delete</button>
                <div class="btn btn-primary" style="border-radius: 50px;" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fa-solid fa-plus"></i> Nouveau</div>
            </div>
        </section>
        <section>
            <table class="table " style="width: 100%;">
                <tr style="border: none;">
                    <th style="border-top-right-radius: 5px; border-top-left-radius: 5px; border: none;" colspan="4">
                        <form action="groupeController.php" method="get" class="position-relative">
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
                    foreach ($groups as $group) {
                        if (
                            $search == substr(strtolower($group->id), 0, $length) ||
                            $search == substr(strtolower($group->titre), 0, $length) 
                            ) {
                            $newArray[] = $group;
                        }
                    }
                    $groups = $newArray;
                }
                ?>
                    <th style="width: 20px;"><input type="checkbox" id="selectAllGrp" <?= count($groups) == 0 ? 'disabled' : '' ?>></th>
                    <th>id</th>
                    <th>Groupe</th>
                    <th style="text-align: end; padding-right: 30px;">actions</th>
                </tr>
                <?php
                    foreach ($groups as $group) {
                        ?>
                        <tr>
                            <td class="py-3"><input class="checkbox" onclick="checkedUpdate('<?= $group->id ?>', 'grp')" type="checkbox" id="<?= $group->id ?>"></td>
                            <td style="width: 50px;" class="py-3">
                                <?= $group->id ?>
                            </td>
                            <td>
                                <div class="d-flex flex-column justify-content-start" style="height: 100%;">
                                    <div>
                                        <?= ucfirst(strtolower($group->titre)) ?>
                                    </div>
                                    <div class="text-secondary" style="font-size: 12px;">
                                        <?php 
                                        foreach ($fills as $fill) {
                                            echo $fill->id == $group->fill ? $fill->titre : '';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </td>
                            <!-- style="width: 10px; white-space: nowrap;" -->
                            <td style="text-align: end; padding-right: 30px;" class="py-3">
                                <span class="h5" style="cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false">...</span>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modify<?= $group->id ?>"><i class="fa-solid fa-pen-to-square me-2"></i> modifier</li>
                                    <li class="dropdown-item text-danger" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modal<?= $group->id ?>"><i class="fa-solid fa-trash me-2"></i> supprimer</li>
                                </ul>
                            </td>
                        </tr>
                        <div class="modal fade" id="modal<?= $group->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Suppression</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        tu es sûr de supprimer <?= ucfirst(strtolower($group->titre)) ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
                                        <a href="../../models/groupe/delete.php?id=<?= $group->id ?>"><button type="button" class="btn btn-danger">Supprimer</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modify<?= $group->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modification</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="../../models/groupe/update.php" method="post">
                                        <div class="modal-body">
                                            <div class="mb-4">
                                                remplissez les champs que vous souhaitez modifier.
                                            </div>
                                            <input type="hidden" name="user" value="<?= $group->id ?>">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control form<?= $group->id ?>"  placeholder="id" value="<?= $group->id ?>" disabled>
                                                <input type="hidden" class="form-control form<?= $group->id ?>"  name="id" placeholder="id" value="<?= $group->id ?>">
                                                <label for="floatingInput">id</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control form<?= $group->id ?>"  name="titre" value="<?= $group->titre ?>" placeholder="Titre" required>
                                                <label for="floatingInput">Titre</label>
                                            </div>
                                            <select class="mb-3 form-control" name="fill" required>
                                                <option value="">selectionner une filliere</option>
                                                <?php
                                                foreach ($fills as $fill) {
                                                    
                                                    echo $fill->id == $group->fill ? "<option value='$fill->id' selected>$fill->titre</option>" : "<option value='$fill->id'>$fill->titre</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
                                            <button type="submit" class="btn btn-primary">Modifier</button>
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
                    <form action="../../models/groupe/create.php" method="post">
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control"  name="titre" placeholder="Titre" required>
                                <label for="floatingInput">Titre</label>
                            </div>
                            <select class="mb-3 form-control" name="fill" required>
                                <option value="">selectionner une filliere</option>
                                <?php
                                foreach ($fills as $fill) {
                                    echo "<option value='$fill->id'>$fill->titre</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
                            <button type="submit" name="addGroupe" class="btn btn-primary">ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['message'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                groupe ajouté avec succès
                <a href="groupeController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php } elseif (isset($_GET['acc'])) { ?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                il y a déjà un groupe avec le même titre.
                <a href="groupeController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php } elseif (isset($_GET['delete'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                groupe(s) a été supprimé.
                <a href="groupeController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php } elseif (isset($_GET['fields'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                les champs sont vides.
                <a href="groupeController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php } elseif (isset($_GET['updated'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                groupe modifié avec succès.
                <a href="groupeController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php }?>
    </main>

    <!-- <script src="../../view/bootstrap-5.3.2-dist/js/bootstrap.min.js"></script> -->
    <script src="../../view/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../view/script/script.js"></script>
</body>
</html>