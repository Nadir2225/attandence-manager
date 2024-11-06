<?php
session_start();

require_once('../connexion.php');
require_once('read.php');


if (isset($_POST['titre'])) {
    $id = $_POST['id'];
    $titre = strtolower($_POST['titre']);
    $exists = false;
    foreach ($fills as $fill) {
        $exists = $fill->titre == $titre ? true : $exists;
    }
    if ($exists) {
        header('Location: ../../controllers/admin/fillController.php?id=exsits');
    } else {
        $res = $conn->query("UPDATE filliere set titre='$titre' where id='$id'");
        header('Location: ../../controllers/admin/fillController.php?updated=true');
    }
} 