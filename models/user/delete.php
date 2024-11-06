<?php

require_once('../connexion.php');
session_start();
require_once('./read.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE from user where id='$id'");
    if (isset($_GET['logout'])) {
        if ($_GET['logout'] == 'true') {
            header('Location: ../security.php?logout=logout');
        } else {
            if (isset($_GET['role'])) {
                header('Location: ../../controllers/admin/formateursController.php?delete=true');
            } else {
                header('Location: ../../controllers/admin/adminsController.php?delete=true');
            }
        }
    } else {
        if (isset($_GET['role'])) {
            header('Location: ../../controllers/admin/formateursController.php?delete=true');
        } else {
            header('Location: ../../controllers/admin/adminsController.php?delete=true');
        }
    }
}

if (isset($_POST['ids'])) {
    $ids = $_POST['ids'];
    $currentU = false;
    foreach ($ids as $id) {
        $conn->query("DELETE from user where id='$id'");
        $currentU = $id == $currentUser->id ? true : $currentU;
    }
    if ($currentU) {
        header('Location: ../security.php?logout=logout');
    } else if ($_POST['role'] == 'gest') {
        header('Location: ../../controllers/admin/adminsController.php?delete=true');
    } else if ($_POST['role'] == 'form') {
        header('Location: ../../controllers/admin/formateursController.php?delete=true');
    }
}