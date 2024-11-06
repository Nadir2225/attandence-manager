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
<body onload="onloadFun()">
    <?php 
        require_once('../../view/components/sideBar.php');
        require_once('../../view/components/header.php');
    ?>
    
    <main id="content">
        <div class="d-flex justify-content-center align-items-center gap-4 mb-4">
            <div class="d-flex flex-column justify-content-center align-items-center gap-2">
                <a href="weeklyAbsController.php">
                    <div class="bg-danger rounded-5 d-flex justify-content-center align-items-center" style="width: 50px; height: 50px">
                    <i class="fa-solid fa-calendar-week" style="font-size: 20px; color: white;"></i>
                    </div>
                </a>
                présence par semaine
            </div>
            <div class="d-flex flex-column justify-content-center align-items-center gap-2">
                <a href="dailyAbsController.php">
                    <div class="bg-primary rounded-5 d-flex justify-content-center align-items-center" style="width: 50px; height: 50px">
                    <i class="fa-solid fa-clipboard-user" style="font-size: 20px; color: white;"></i>
                    </div>
                </a>
                liste d'absences
            </div>
            <div class="d-flex flex-column justify-content-center align-items-center gap-2">
                <a href="historyController.php">
                    <div class="bg-secondary rounded-5 d-flex justify-content-center align-items-center" style="width: 50px; height: 50px">
                        <i class="fa-solid fa-clock-rotate-left" style="font-size: 20px; color: white"></i>
                    </div>
                </a>
                historique
            </div>
        </div>
        <section class="pb-4">
            <?php if ($count > 0) { ?>
            <div class="h5 py-3">les feuille du presence non lu :</div>
            <?php } else {?>
                <div class="d-flex justify-content-center align-items-center" style="width: 100%; height: calc(100vh - 250px)">tout les feuille du presence sont lu.</div>
            <?php }?>
            <div id="nonluContent"></div> 
        </section>
    </main>

    <script src="../../view/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../view/script/script.js"></script>
</body>
</html>