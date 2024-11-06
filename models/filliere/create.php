<?php

require_once('../connexion.php');
require_once('read.php');

if (isset($_POST['addFilliere'])) {
    $exists = false;
    foreach ($fills as $fill) {
        $exists = $fill->titre == $_POST['titre'] ? true : $exists;
    }
    
    if ($exists) {
        header('Location: ../../controllers/admin/fillController.php?acc=exsits');
    } else {
        $titre = strtolower($_POST['titre']);
        $res = $conn->prepare('INSERT into filliere (titre) values (?)');
        $res->execute([$titre]);
        header('Location: ../../controllers/admin/fillController.php?message=success');
    }
}