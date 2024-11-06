<?php

require_once('../connexion.php');
require_once('read.php');

if (isset($_GET['deleteStrs'])) {
    if ($_GET['deletetype'] == 'all') {
        $conn->query("DELETE from stagiaire");
    } elseif ($_GET['deletetype'] == 'byGrp') {
        $id = $_GET['group'];
        $conn->query("DELETE from stagiaire where groupe='$id'");
    }
    header('Location: ../../controllers/admin/stagiairesController.php?delete=true');
} elseif (isset($_GET['strId'])) {
    $id = $_GET['strId'];
    $conn->query("DELETE from stagiaire where id='$id'");
    header('Location: ../../controllers/admin/stagiairesController.php?delete=true');
}