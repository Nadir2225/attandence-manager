<?php

require_once('../connexion.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE from filliere where id='$id'");
    header('Location: ../../controllers/admin/fillController.php?delete=true');
}

if (isset($_POST['ids'])) {
    $ids = $_POST['ids'];
    foreach ($ids as $id) {
        $conn->query("DELETE from filliere where id='$id'");
    }
    header('Location: ../../controllers/admin/fillController.php?delete=true');
}