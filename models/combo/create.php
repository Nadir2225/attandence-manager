<?php

require_once('../connexion.php');
require_once('read.php');

if (isset($_POST['addCombo'])) { 
    $formateur = $_POST['form'];
    $groupe = $_POST['group'];
    $res = $conn->prepare('INSERT into combo (formateur, groupe) values (?, ?)');
    $res->execute([$formateur, $groupe]);
    header('Location: ../../controllers/admin/formateursController.php?updated=true');
}