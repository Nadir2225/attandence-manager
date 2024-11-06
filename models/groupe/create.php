<?php

require_once('../connexion.php');
require_once('read.php');

if (isset($_POST['addGroupe'])) {
    $exists = false;
    foreach ($groups as $group) {
        $exists = $group->titre == $_POST['titre'] ? true : $exists;
    }
    
    if ($exists) {
        header('Location: ../../controllers/admin/groupeController.php?acc=exsits');
    } else {
        $titre = strtolower($_POST['titre']);
        $fill = $_POST['fill'];
        $res = $conn->prepare('INSERT into groupe (titre, fill) values (?, ?)');
        $res->execute([$titre, $fill]);
        header('Location: ../../controllers/admin/groupeController.php?message=success');
    }
}