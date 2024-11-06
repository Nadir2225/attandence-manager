<?php
session_start();

require_once('../connexion.php');
require_once('read.php');


if (isset($_POST['titre'])) {
    $id = $_POST['id'];
    $titre = strtolower($_POST['titre']);
    $fill = $_POST['fill'];
    $exists = false;
    foreach ($groups as $group) {
        $exists = $group->titre == $titre ? true : $exists;
    }
    if ($exists) {
        header('Location: ../../controllers/admin/groupeController.php?id=exsits');
    } else {
        $res = $conn->query("UPDATE groupe set titre='$titre', fill='$fill' where id='$id'");
        header('Location: ../../controllers/admin/groupeController.php?updated=true');
    }
} 