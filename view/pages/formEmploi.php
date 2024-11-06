<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../view/bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../view/style/components.css">
    <link rel="stylesheet" href="../../view/style/emploi.css">
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
            <a href="formateursController.php"><i class="fa-solid fa-arrow-left ms-2 me-5" style="font-size: 25px; color:black"></i></a>
            <div class="h4">formateur : <?= ucfirst($formateur->nom) . ' ' . ucfirst($formateur->prenom) ?></div>
        </div>
        <form action="../../models/emploi/update.php" method="post">
            <input type="hidden" name="week" value="<?= $week->id ?>">
            <div class="emploi my-5 d-flex flex-column gap-3">
                <div class="d-flex justify-content-between align-items-center emploi-row gap-3" style="height: 30px;">
                    <div></div>
                    <div style="font-weight: bold;">8:30 - 11:00</div>
                    <div style="font-weight: bold;">11:00 - 13:30</div>
                    <div style="font-weight: bold;">13:30 - 16:00</div>
                    <div style="font-weight: bold;">16:00 - 18:30</div>
                </div>
                <?php foreach ($days as $index => $day) { ?>
                <div class="d-flex justify-content-between align-items-center emploi-row gap-3"  style="height: 50px;">
                    <div  style="font-weight: bold;">
                        <?= $day->name ?>
                    </div>
                    <div class="session locked <?= $day->s1 == 0 ? '' : 'unlocked' ?>">
                        <div class="checkbox-wrapper-8">
                            <input class="tgl tgl-skewed" name="sessions[]" value="<?= $day->id . '-' . 's1' ?>" id="cb3-<?= $day->id . 's1' ?>" onclick="handleToggle(this)" type="checkbox" <?= $day->s1 == 0 ? '' : 'checked' ?>/>
                            <label class="tgl-btn" data-tg-off="verrouillé" data-tg-on="disponible" for="cb3-<?= $day->id . 's1' ?>"></label>
                        </div>
                    </div>
                    <div class="session locked <?= $day->s2 == 0 ? '' : 'unlocked' ?>">
                        <div class="checkbox-wrapper-8">
                            <input class="tgl tgl-skewed" name="sessions[]" value="<?= $day->id . '-' . 's2' ?>" id="cb3-<?= $day->id . 's2' ?>" onclick="handleToggle(this)" type="checkbox" <?= $day->s2 == 0 ? '' : 'checked' ?>/>
                            <label class="tgl-btn" data-tg-off="verrouillé" data-tg-on="disponible" for="cb3-<?= $day->id . 's2' ?>"></label>
                        </div>
                    </div>
                    <div class="session locked <?= $day->s3 == 0 ? '' : 'unlocked' ?>">
                        <div class="checkbox-wrapper-8">
                            <input class="tgl tgl-skewed" name="sessions[]" value="<?= $day->id . '-' . 's3' ?>" id="cb3-<?= $day->id . 's3' ?>" onclick="handleToggle(this)" type="checkbox" <?= $day->s3 == 0 ? '' : 'checked' ?>/>
                            <label class="tgl-btn" data-tg-off="verrouillé" data-tg-on="disponible" for="cb3-<?= $day->id . 's3' ?>"></label>
                        </div>
                    </div>
                    <div class="session locked <?= $day->s4 == 0 ? '' : 'unlocked' ?>">
                        <div class="checkbox-wrapper-8">
                            <input class="tgl tgl-skewed" name="sessions[]" value="<?= $day->id . '-' . 's4' ?>" id="cb3-<?= $day->id . 's4' ?>" onclick="handleToggle(this)" type="checkbox" <?= $day->s4 == 0 ? '' : 'checked' ?>/>
                            <label class="tgl-btn" data-tg-off="verrouillé" data-tg-on="disponible" for="cb3-<?= $day->id . 's4' ?>"></label>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="pb-5 d-flex justify-content-end align-items-center px-4">
                <button class="btn btn-primary rounded-5" type="submit" style="width: 100px;">Save</button>
            </div>
        </form>
    </main>

    <script src="../../view/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../view/script/script.js"></script>
</body>
</html>