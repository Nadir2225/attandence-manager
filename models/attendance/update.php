<?php
session_start();

require_once('../connexion.php');


if (isset($_GET['confirmed'])) {
    $id = $_GET['id'];
    $res = $conn->query("UPDATE attendance set confirmed=1 where id='$id'");
    header('Location: ../../controllers/admin/homeController.php');
} elseif (isset($_POST['stagiaires'])) {
    $stagiaires = explode('-', $_POST['stagiaires']);
    $id = $_POST['id'];
    $conn->query("DELETE FROM absence where attendance='$id'");
    foreach ($stagiaires as $str) {
        if ($_POST[$str] == 'a') {
            $conn->query("INSERT into absence (stagiaire, attendance) values ($str, $id)");
        }
    }
    header("Location: ../../controllers/admin/updateController.php?id=$id&success=true");
}