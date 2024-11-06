<?php

require_once('../connexion.php');
require_once('read.php');

if (isset($_GET['deleteAtd'])) {
    if ($_GET['deletetype'] == 'all') {
        $conn->query("DELETE from attendance");
    } elseif ($_GET['deletetype'] == 'byGrp') {
        $id = $_GET['attendance'];
        $conn->query("DELETE from attendance where id='$id'");
    }
    header('Location: ../../controllers/homeController.php?delete=true');
}
if (isset($_GET['deleteAtd'])) {
    $id = $_GET['deleteAtd'];
    $conn->query("DELETE from attendance where id='$id'");
    header('Location: ../../controllers/admin/historyController.php?delete=true');
} elseif (isset($_GET['deleteAll'])) {
    $conn->query("DELETE from attendance");
    header('Location: ../../controllers/admin/historyController.php?delete=true');
}