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