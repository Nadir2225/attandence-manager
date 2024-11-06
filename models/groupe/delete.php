<?php

require_once('../connexion.php');
require_once('read.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE from groupe where id='$id'");
    header('Location: ../../controllers/admin/groupeController.php?delete=true');
}

if (isset($_POST['ids'])) {
    $ids = $_POST['ids'];
    foreach ($ids as $id) {
        $conn->query("DELETE from groupe where id='$id'");
    }
    header('Location: ../../controllers/admin/groupeController.php?delete=true');
}