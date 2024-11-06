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
    <?php 
    echo "<script>";
    echo "let stagiaires = ";
    echo json_encode($stagiaires);
    echo ";let attendances = ";
    echo json_encode($attendances);
    echo ";let count = ";
    echo json_encode($count);
    echo ";let absences = ";
    echo json_encode($absences);
    echo ";let groups = ";
    echo json_encode($groups);
    echo ";let forms = ";
    echo json_encode($users);
    echo "</script>";
    ?>
</head>
<body onload="onloadFun2()">
    <?php 
        require_once('../../view/components/sideBar.php');
        require_once('../../view/components/header.php');
    ?>
    
    <main id="content">
        <div class="d-flex align-items-center">
            <a href="homeController.php"><i class="fa-solid fa-arrow-left ms-2 me-5" style="font-size: 25px; color:black"></i></a>
            <div class="h4">Historique</div>
        </div>
        <?php if ($count > 0 || isset($_GET['week'])) { ?>
            <div class="d-flex justify-content-center align-items-center gap-4 mb-4">
                <div class="btn btn-primary rounded-5" data-bs-toggle="modal" data-bs-target="#filtreModal"><i class="fa-solid fa-filter"></i> Filtre</div>
                <div class="btn btn-danger rounded-5" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i> Supprimer</div>
            </div>
            <div class="modal fade" id="filtreModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <form action="" method="get">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Filtre</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body d-flex flex-column gap-4">
                                <select name="group" id="day" class="form-control">
                                    <option value="">choisir un groupe</option>
                                    <?php foreach($groups as $g) { ?>
                                        <option value="<?= $g->id ?>" <?= isset($_GET['group']) ? ($_GET['group'] == $g->id ? 'selected' : '') : '' ?>><?= $g->titre ?></option>
                                    <?php } ?>
                                </select>
                                <input type="week" name="week" class="form-control" value="<?= isset($_GET['week']) ? $_GET['week'] : '' ?>" required>
                                <select name="day" id="day" class="form-control">
                                    <option value="" <?= isset($_GET['day']) ? ($_GET['day'] == '' ? 'selected' : '') : '' ?>>choisir un jours</option>
                                    <option value="Lundi" <?= isset($_GET['day']) ? ($_GET['day'] == 'Lundi' ? 'selected' : '') : '' ?>>lundi</option>
                                    <option value="Mardi" <?= isset($_GET['day']) ? ($_GET['day'] == 'Mardi' ? 'selected' : '') : '' ?>>mardi</option>
                                    <option value="Mercredi" <?= isset($_GET['day']) ? ($_GET['day'] == 'Mercredi' ? 'selected' : '') : '' ?>>Mercredi</option>
                                    <option value="Jeudi" <?= isset($_GET['day']) ? ($_GET['day'] == 'Jeudi' ? 'selected' : '') : '' ?>>Jeudi</option>
                                    <option value="Vendredi" <?= isset($_GET['day']) ? ($_GET['day'] == 'Vendredi' ? 'selected' : '') : '' ?>>Vendredi</option>
                                    <option value="Samedi" <?= isset($_GET['day']) ? ($_GET['day'] == 'Samedi' ? 'selected' : '') : '' ?>>Samedi</option>
                                </select>
                                <div class="d-flex gap-3 justify-content-center align-items-center">
                                    <div>ascendant <input type="radio" name="order" value="asc" <?= isset($_GET['order']) ? ($_GET['order'] == 'asc' ? 'checked' : '') : 'checked' ?>></div>
                                    <div>descendant <input type="radio" name="order" value="desc" <?= isset($_GET['order']) ? ($_GET['order'] == 'desc' ? 'checked' : '') : '' ?>></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" value="<?= isset($_GET['limit']) ? $_GET['limit'] : 10 ?>" name="limit">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">confirmer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Suppression</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="../../models/attendance/delete.php" method="get">
                            <div class="modal-body">
                                voulez vous supprimer tout les feuilles du presence?
                                <input type="hidden" name="deleteAll">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
                                <button type="submit" onclick="return confirm('cette action va supprimer beaucoup des donnees, t\' es sure?')" name="deleteStrs" class="btn btn-danger">Supprimer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php }?>
        <section class="pb-4">
            <?php if ($count == 0) { ?>
                <div class="d-flex justify-content-center align-items-center" style="width: 100%; height: calc(100vh - 250px)">vide</div>
            <?php }?>
            <div id="historyContent"></div> 
        </section>
    </main>

    <?php if (isset($_GET['delete'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                attendance(s) a été supprimé.
                <a href="historyController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
    <?php } ?>

    <script src="../../view/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../view/script/script.js"></script>
</body>
</html>