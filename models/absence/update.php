<?php
session_start();

require_once('../connexion.php');
require_once('read.php');


if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $group = $_POST['group'];
    $res = $conn->query("UPDATE absence set nom='$nom', prenom='$prenom', groupe='$group' where id='$id'");
    header('Location: ../../controllers/admin/stagiairesController.php?updated=true');
} 