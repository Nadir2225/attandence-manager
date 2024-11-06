<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../view/style/formateursHome.css">
    <link rel="stylesheet" href="../view/bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <link rel="icon" href="../view/assets/fav.png" type="image/png">
    <title>espace formateur</title>
	<script src="https://kit.fontawesome.com/81aebbec1d.js" crossorigin="anonymous"></script>
    <?php 
    echo "<script>
    let days = ";
    echo json_encode($days);
    echo ";let attendances = ";
    echo json_encode($attendances);
    echo ";let stagiaires = ";
    echo json_encode($stagiaires);
    echo ";let currentUser = ";
    echo json_encode($currentUser);
    echo ";let groups = ";
    echo json_encode($groups);
    echo "</script>";
    ?>
</head>
<body onload="fillDays()">
    <header class="d-flex justify-content-between align-items-center px-4">
        <div class="" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
            <i class="fa-solid fa-bars-staggered" style="font-size: 25px;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions"></i>    
        </div>
        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header d-flex justify-content-end align-items-center  py-4">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column align-items-center">
                <div class="rounded-circle d-flex justify-content-center align-items-center mb-2" style="color: white; background-color: <?= $currentUser->color ?>; width: 60px; height: 60px; cursor: pointer; font-size: 25px;"><?= strtoupper($currentUser->prenom[0]) ?></div>
                <div class="h5 mb-5"><?= ucfirst(strtolower($currentUser->prenom)) , ' ' , ucfirst(strtolower($currentUser->nom)) ?></div>
                <div class="d-flex flex-column align-items-center">
                    <a href="homeController.php"><div class="selected-el mb-3">Acceuil</div></a>
                    <a href="historyController.php"><div class="el mb-5">Historique</div></a>
                    <div class="mt-5">
                        <!-- <button class="btn btn-outline-dark">
                            <i class="fa-solid fa-gear" style="cursor: pointer; font-size: 20px;"></i> settings
                        </button> -->
                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#logout">
                            <i class="fa-solid fa-arrow-right-from-bracket" style="transform: rotate(180deg);"></i> Logout
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center gap-4">
            <!-- <i class="fa-solid fa-gear" style="cursor: pointer; font-size: 20px;"></i> -->
            <i title="logout" class="fa-solid fa-arrow-right-from-bracket text-danger" style="cursor: pointer; font-size: 20px; transform: rotate(180deg);" data-bs-toggle="modal" data-bs-target="#logout"></i>
        </div>
    </header>

    <main>
        <section class="selects-div flex-wrap d-flex justify-content-evenly align-items-center gap-4 px-3 py-5">
            <input class="form-control" type="week" id="week" onchange="fillDays()">
            <select class="form-select" name="" id="selectedDay" onchange="fillSeances()"></select>
            <select class="form-select" name="" id="selectedSeance" onchange="toggleGroup()">
                <option value="">Choisir la seance</option>
            </select>
            <select class="form-select" name="" id="selectedGroup" onchange="displayData()" disabled>
                <option value="">Choisir le groupe</option>
                <?php
                foreach ($groups as $group) {
                    foreach ($combos as $combo) {
                        if ($combo->formateur == $currentUser->id && $combo->groupe == $group->id ) {
                            echo "<option value='$group->id'>$group->titre</option>";
                        }
                    }
                }
                ?>
            </select>
        </section>
        <section class="abs-section py-5 px-3 d-flex flex-column align-items-center" id="list-section"></section>
    </main>

    <?php if (isset($_GET['message'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                feuille d'absence a été confirmé avec succès
                <a href="homeController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
    <?php }?>

    <div class="modal fade" id="logout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Logout</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                t'es sure tu veux logout ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="../models/security.php?logout=logout"><button type="button" class="btn btn-danger">Logout</button></a>
            </div>
        </div>
    </div>


    <script src="../view/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../view/script/script2.js"></script>
</body>
</html>