<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../view/bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../view/style/components.css">
	<script src="https://kit.fontawesome.com/81aebbec1d.js" crossorigin="anonymous"></script>
    <link rel="icon" href="../view/assets/fav.png" type="image/png">
    <title>espace formateur</title>
</head>
<body>
    <?php 
        require_once('../../view/components/sideBar.php');
        require_once('../../view/components/header.php');
    ?>
    
    <main id="content">
        <div class="d-flex align-items-center">
            <a href="homeController.php"><i class="fa-solid fa-arrow-left ms-2 me-5" style="font-size: 25px; color:black"></i></a>
            <div class="h4">Liste des absences</div>
        </div>
        <form action="../../models/excel/excelfileDownload.php" method="post" class="pt-5 d-flex gap-3 flex-column">
            <div>
                type : 
                <input type="radio" name="type" value="weekly" id="weekly" onchange="toggleType()" checked> par Semaine
                <input type="radio" name="type" value="daily" class="ms-3" onchange="toggleType()"> par Jour
            </div>
            <input type="week" name="week" class="form-control" required>
            <select name="day" id="dayss" class="form-control" disabled required>
                <option value="Lundi">lundi</option>
                <option value="Mardi">mardi</option>
                <option value="Mercredi">Mercredi</option>
                <option value="Jeudi">Jeudi</option>
                <option value="Vendredi">Vendredi</option>
                <option value="Samedi">Samedi</option>
            </select>
            <input type="submit" value="Download" class="btn btn-primary">
        </form>
    </main>
    <?php if (isset($_GET['abs'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                il n y'a aucune absence cette date.
                <a href="dailyAbsController.php"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
    <?php }?>

    <script src="../../view/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../view/script/script.js"></script>
</body>
</html>