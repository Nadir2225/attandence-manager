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
    
    <main id="content">
        <div class="d-flex align-items-center">
            <a href="homeController.php"><i class="fa-solid fa-arrow-left ms-2 me-5" style="font-size: 25px; color:black"></i></a>
            <div class="h4">presence par semaine</div>
        </div>
        <form action="../../models/excel/excelfileDownload2.php" method="post" class="pt-5 d-flex gap-3 flex-column">
            <input type="week" name="week" class="form-control" required>
            <input type="submit" value="Download" class="btn btn-primary">
        </form>
    </main>

    <script src="../../view/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../view/script/script.js"></script>
</body>
</html>