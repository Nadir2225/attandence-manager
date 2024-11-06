<?php

require_once('../connexion.php');
require_once('read.php');

$colors = ['#1abc9c', '#16a085', '#2ecc71', '#27ae60', '#9b59b6', '#be44ad', '#2c3e50', '#c0392b', '#d35400', '#f39c12', '#e67e22', '#7f8c8d'];

if (isset($_POST['addAdmin'])) {
    $exists = false;
    foreach ($admins as $admin) {
        $exists = $admin->id == $_POST['id'] ? true : $exists;
    }
    foreach ($users as $user) {
        $exists = $user->id == $_POST['id'] ? true : $exists;
    }
    
    if ($exists) {
        header('Location: ../../controllers/admin/adminsController.php?acc=exsits');
    } else {
        $id = $_POST['id'];
        $nom = strtolower($_POST['nom']);
        $prenom = strtolower($_POST['prenom']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $color = $colors[array_rand($colors)];
        
        $res = $conn->prepare('INSERT into user (nom, prenom, id, password, role, color) values (?, ?, ?, ?, ?, ?)');
        $res->execute([$nom, $prenom, $id, $password, 'admin', $color]);
        header('Location: ../../controllers/admin/adminsController.php?message=success');
    }
} elseif (isset($_POST['addUser'])) {
    $exists = false;
    foreach ($users as $user) {
        $exists = $user->id == $_POST['id'] ? true : $exists;
    }
    foreach ($admins as $admin) {
        $exists = $admin->id == $_POST['id'] ? true : $exists;
    }
    
    if ($exists) {
        header('Location: ../../controllers/admin/formateursController.php?acc=exsits');
    } else {
        $id = $_POST['id'];
        $nom = strtolower($_POST['nom']);
        $prenom = strtolower($_POST['prenom']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $color = $colors[array_rand($colors)];
        
        $res = $conn->prepare('INSERT into user (nom, prenom, id, password, role, color) values (?, ?, ?, ?, ?, ?)');
        $res->execute([$nom, $prenom, $id, $password, 'user', $color]);
        $conn->query("INSERT into week (form) values ('$id')");
        $weekId =  $conn->lastInsertId();
        $conn->query("INSERT into day (name, week) values ('Lundi', $weekId)");
        $conn->query("INSERT into day (name, week) values ('Mardi', $weekId)");
        $conn->query("INSERT into day (name, week) values ('Mercredi', $weekId)");
        $conn->query("INSERT into day (name, week) values ('Jeudi', $weekId)");
        $conn->query("INSERT into day (name, week) values ('Vendredi', $weekId)");
        $conn->query("INSERT into day (name, week) values ('Samedi', $weekId)");
        header('Location: ../../controllers/admin/formateursController.php?message=success');
    }
}