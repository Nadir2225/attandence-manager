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
            <div class="h4">Fillieres</div>
            <div>
                <button class="btn btn-danger" disabled style="border-radius: 50px;" id="deleteBtnFi"><i class="fa-solid fa-trash me-2"></i> Delete</button>
                <div class="btn btn-primary" style="border-radius: 50px;" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fa-solid fa-plus"></i> Nouveau</div>
            </div>
        </section>
        <section>
            <table class="table " style="width: 100%;">
                <tr style="border: none;">
                    <th style="border-top-right-radius: 5px; border-top-left-radius: 5px; border: none;" colspan="4">
                        <form action="fillController.php" method="get" class="position-relative">
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
                    foreach ($fills as $fill) {
                        if (
                            $search == substr(strtolower($fill->id), 0, $length) ||
                            $search == substr(strtolower($fill->titre), 0, $length) 
                            ) {
                            $newArray[] = $fill;
                        }
                    }
                    $fills = $newArray;
                }
                ?>
                    <th style="width: 20px;"><input type="checkbox" id="selectAllFi" <?= count($fills) == 0 ? 'disabled' : '' ?>></th>
                    <th>id</th>
                    <th>Filliere</th>
                    <th style="text-align: end; padding-right: 30px;">actions</th>
                </tr>
                <?php
                    foreach ($fills as $fill) {
                        ?>
                        <tr>
                            <td class="py-3"><input class="checkbox" onclick="checkedUpdate('<?= $fill->id ?>', 'fill')" type="checkbox" id="<?= $fill->id ?>"></td>
                            <td style="width: 50px;" class="py-3">
                                <?= $fill->id ?>
                            </td>
                            <td class="py-3">
                                <?= ucfirst(strtolower($fill->titre)) ?>
                            </td>
                            <!-- style="width: 10px; white-space: nowrap;" -->
                            <td style="text-align: end; padding-right: 30px;" class="py-3">
                                <span class="h5" style="cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false">...</span>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modify<?= $fill->id ?>"><i class="fa-solid fa-pen-to-square me-2"></i> modifier</li>
                                    <li class="dropdown-item text-danger" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modal<?= $fill->id ?>"><i class="fa-solid fa-trash me-2"></i> supprimer</li>
                                </ul>
                            </td>
                        </tr>
                        <div class="modal fade" id="modal<?= $fill->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Suppression</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        tu es sûr de supprimer <?= ucfirst(strtolower($fill->titre)) ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
                                        <a href="../../models/filliere/delete.php?id=<?= $fill->id ?>"><button type="button" class="btn btn-danger">Supprimer</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modify<?= $fill->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modification</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="../../models/filliere/update.php" method="post">
                                        <div class="modal-body">
                                            <div class="mb-4">
                                                remplissez les champs que vous souhaitez modifier.
                                            </div>
                                            <input type="hidden" name="user" value="<?= $fill->id ?>">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control form<?= $fill->id ?>"  placeholder="id" value="<?= $fill->id ?>" disabled>
                                                <input type="hidden" class="form-control form<?= $fill->id ?>"  name="id" placeholder="id" value="<?= $fill->id ?>">
                                                <label for="floatingInput">id</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control form<?= $fill->id ?>"  name="titre" value="<?= $fill->titre ?>" placeholder="Titre" required>
                                                <label for="floatingInput">Titre</label>
                                            </div>
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
                    <form action="../../models/filliere/create.php" method="post">
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control"  name="titre" placeholder="Titre" required>
                                <label for="floatingInput">Titre</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
                            <button type="submit" name="addFilliere" class="btn btn-primary">ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['message'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                filliere ajouté avec succès
                <a href="fillController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php } elseif (isset($_GET['acc'])) { ?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                il y a déjà une filliere avec le même titre.
                <a href="fillController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php } elseif (isset($_GET['delete'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                filliere(s) a été supprimé.
                <a href="fillController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php } elseif (isset($_GET['fields'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                les champs sont vides.
                <a href="fillController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php } elseif (isset($_GET['updated'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                filliere modifié avec succès.
                <a href="fillController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php }?>
    </main>

    <!-- <script src="../../view/bootstrap-5.3.2-dist/js/bootstrap.min.js"></script> -->
    <script src="../../view/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../view/script/script.js"></script>
</body>
</html>