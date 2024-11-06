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
    echo ";let attendance = ";
    echo json_encode($attendance);
    echo ";let absences = ";
    echo json_encode($absences);
    echo ";let groups = ";
    echo json_encode($groups);
    echo ";let forms = ";
    echo json_encode($users);
    echo "</script>";
    ?>
</head>
<body onload="onloadFun3()">
    <?php 
        require_once('../../view/components/sideBar.php');
        require_once('../../view/components/header.php');
    ?>
    
    <main id="content">
        <div class="d-flex align-items-center">
            <a href="historyController.php"><i class="fa-solid fa-arrow-left ms-2 me-5" style="font-size: 25px; color:black"></i></a>
            <div class="h4">Modification</div>
        </div>
        <div id="cont" class="my-3"></div>
    </main>

    <?php if (isset($_GET['success'])) {?>
        <div style="position: fixed; z-index: 500; left: 0; right: 0; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                feuille d'absence modifié avec succès
                <a href="updateController.php?id=<?= $_GET['id'] ?>"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></a>
            </div>
        </div>
    <?php } ?>

    <script src="../../view/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../view/script/script.js"></script>
</body>
</html>