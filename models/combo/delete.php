<?php

require_once('../connexion.php');
require_once('read.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE from combo where id='$id'");
    header('Location: ../../controllers/admin/formateursController.php?updated=true');
}