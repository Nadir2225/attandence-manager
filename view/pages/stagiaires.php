<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../view/bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../view/style/components.css">
    <link rel="icon" href="../../view/assets/fav.png" type="image/png">
    <title>espace admin</title>
    <script src="https://kit.fontawesome.com/81aebbec1d.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php 
        require_once('../../view/components/sideBar.php');
        require_once('../../view/components/header.php');
    ?>
    
    <main id="content" class="pb-3">
        <section class="content-header d-flex justify-content-between align-items-center mb-4">
            <div class="h4">Stagiaires</div>
            <form action="stagiairesController.php" method="get" class="position-relative">
                <div class="input-group mb-3 rounded-5">
                    <input type="text" class="form-control rounded-start-5" placeholder="Search" name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                    <button class="btn btn-outline-secondary rounded-end-5" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass" style="color: rgb(199, 199, 199);"></i></button>
                </div>
            </form>
            <div>
                <button class="btn btn-danger" style="border-radius: 50px;" data-bs-toggle="modal" data-bs-target="#deleteStr"><i class="fa-solid fa-trash me-2"></i> Delete</button>
                <div class="btn btn-primary" style="border-radius: 50px;" data-bs-toggle="modal" data-bs-target="#import"><i class="fa-solid fa-file-import"></i> Importer</div>
                <div class="btn btn-primary" style="border-radius: 50px;" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fa-solid fa-plus"></i> Nouveau</div>
            </div>
        </section>
        <?php
        $newArrayf = $fills;
        if (isset($_GET['search'])) {
            if ($_GET['search'] != '') {
                $newArrayf = [];
                $newArrays = [];
                $length = strlen($_GET['search']);
                $search = strtolower($_GET['search']);
                foreach ($stagiaires as $stagiaire) {
                    if (
                        $search == substr(strtolower($stagiaire->nom), 0, $length) ||
                        $search == substr(strtolower($stagiaire->prenom), 0, $length) ||
                        $search == substr(strtolower($stagiaire->nom) . ' ' . strtolower($stagiaire->prenom), 0, $length) ||
                        $search == substr(strtolower($stagiaire->prenom) . ' ' . strtolower($stagiaire->nom), 0, $length)
                        ) { 
                            $newArrays[] = $stagiaire;
                            foreach ($groups as $group) {
                                foreach ($fills as $fill) {
                                    if ($fill->id == $group->fill && $group->id == $stagiaire->groupe) {
                                        $newArrayf[] = $fill;
                                    }
                                }
                            }
                    }
                }
                $stagiaires = $newArrays;
            }
        }
        ?>
        <?php
        foreach ($newArrayf as $fill) {
            $thisgroups = [];
            foreach ($groups as $group) {
                if ($group->fill == $fill->id) {
                    $thisgroups[] = $group;
                }
            }
            if (count($thisgroups) != 0) { ?>
            <h5 class="mt-4 mb-2"><?= $fill->titre ?></h5>
            <section class="accordion accordion-flush" id="accordionFlush<?= $fill->id ?>">
                <?php foreach ($thisgroups as $group) { ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $group->id ?>" aria-expanded="false" aria-controls="flush-collapse<?= $group->id ?>">
                                <?= $group->titre ?>
                            </button>
                        </h2>
                        <div id="flush-collapse<?= $group->id ?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlush<?= $fill->id ?>">
                            <ul class="list-group list-group-flush">
                                <?php
                                foreach ($stagiaires as $stagiaire) {
                                    if ($stagiaire->groupe == $group->id) {
                                        $strs[] = $stagiaire;
                                        ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                        <?= ucfirst(strtolower($stagiaire->prenom)) , ' ' , ucfirst(strtolower($stagiaire->nom)) ?>
                                        <div>
                                            <i class="fa-solid fa-pen-to-square text-primary me-2" style="font-size: 18px; cursor:pointer;" title="modifier" data-bs-toggle="modal" data-bs-target="#modify<?= $stagiaire->id ?>"></i>
                                            <i class="fa-solid text-danger fa-trash me-2" style="cursor: pointer;" title="supprimer" data-bs-toggle="modal" data-bs-target="#modal<?= $stagiaire->id ?>"></i>
                                        </div>
                                    </li>
                                <?php }} ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
            </section>
        <?php }} 
        if (isset($strs)) {
        foreach ($strs as $stagiaire) {?>
        <div class="modal fade" id="modal<?= $stagiaire->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Suppression</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        tu es sûr de supprimer <?= ucfirst(strtolower($stagiaire->prenom)) , ' ' , ucfirst(strtolower($stagiaire->nom)) ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
                        <a href="../../models/stagiaire/delete.php?strId=<?= $stagiaire->id ?>"><button type="button" class="btn btn-danger">Supprimer</button></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modify<?= $stagiaire->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modification</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="../../models/stagiaire/update.php" method="post" id="form<?= $stagiaire->id ?>">
                        <div class="modal-body">
                            <div class="mb-4">
                                remplissez les champs que vous souhaitez modifier.
                            </div>
                            <input type="hidden" name="id" value="<?= $stagiaire->id ?>">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control form<?= $stagiaire->id ?>"  name="id" placeholder="id" value="<?= $stagiaire->id ?>" disabled>
                                <label for="floatingInput">id</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control form<?= $stagiaire->id ?>"  name="nom" value="<?= $stagiaire->nom ?>" placeholder="nom" required>
                                <label for="floatingInput">Nom</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control form<?= $stagiaire->id ?>"  name="prenom" value="<?= $stagiaire->prenom ?>" placeholder="prenom" required>
                                <label for="floatingInput">Prenom</label>
                            </div>
                            <select class="mb-3 form-control form<?= $stagiaire->id ?>" name="group" required>
                                <option value="">selectionner un groupe</option>
                                <?php
                                foreach ($groups as $group) {
                                    echo $group->id == $stagiaire->groupe ? "<option value='$group->id' selected>$group->titre</option>" : "<option value='$group->id'>$group->titre</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
                            <button type="submit"  class="btn btn-primary">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php }} ?>

        <div class="modal fade" id="deleteStr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Suppression</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="../../models/stagiaire/delete.php" method="get">
                        <div class="modal-body">
                            <div class="d-flex justify-content-evenly align-items-center mb-4">
                                <div class="d-flex justify-content-center align-items-center"><input type="radio" name="deletetype" value="all" onclick="changeDType(event)" class="me-2" checked>supprimer tout</div>
                                <div class="d-flex justify-content-center align-items-center"><input type="radio" name="deletetype" value="byGrp" onclick="changeDType(event)" class="me-2">supprimer par goupe</div>
                            </div>
                            <div id="groupBlock" style="display: none;">
                                <select class="mb-3 form-control" name="group" id="selectGroup">
                                    <option value="">selectionner un groupe</option>
                                    <?php
                                    foreach ($groups as $group) {
                                        $thisstagiaires = [];
                                        foreach ($stagiaires as $stagiaire) {
                                            $stagiaire->groupe == $group->id ? $thisstagiaires[] = $stagiaire : '';
                                        }
                                        if (count($thisstagiaires) != 0) {
                                            echo "<option value='$group->id'>$group->titre</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
                            <button type="submit" onclick="return confirm('cette action va supprimer beaucoup des donnees, t\' es sure?')" name="deleteStrs" class="btn btn-danger">Supprimer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Ajout</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="../../models/stagiaire/create.php" method="post">
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control"  name="nom" placeholder="nom" required>
                                <label for="floatingInput">Nom</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control"  name="prenom" placeholder="prenom" required>
                                <label for="floatingInput">Prenom</label>
                            </div>
                            <select class="mb-3 form-control" name="group" required>
                                <option value="">selectionner un groupe</option>
                                <?php
                                foreach ($groups as $group) {
                                    echo "<option value='$group->id'>$group->titre</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
                            <button type="submit" name="addStr" class="btn btn-primary">ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
        <div class="modal fade" id="import" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Ajout</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form enctype="multipart/form-data" action="../../models/stagiaire/create.php" method="post">
                        <div class="modal-body">
                            <div class="mb-3">
                                <span>liste des stagiaires (filename.csv*)</span>
                                <input type="file" class="form-control" name="file" accept=".csv" required>
                            </div>
                            <select class="mb-3 form-control" name="group" required>
                                <option value="">selectionner un groupe</option>
                                <?php
                                foreach ($groups as $group) {
                                    echo "<option value='$group->id'>$group->titre</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
                            <button type="submit" name="import" class="btn btn-primary">importer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['message'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                stagiaire(s) ajouté avec succès
                <a href="stagiairesController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php } elseif (isset($_GET['delete'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                stagiaire(s) a été supprimé.
                <a href="stagiairesController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php } elseif (isset($_GET['updated'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                stagiaire(s) modifié avec succès.
                <a href="stagiairesController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
        <?php }?>

    </main>

    
    <script src="../../view/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../view/script/script.js"></script>
</body>
</html>