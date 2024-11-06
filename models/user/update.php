<?php
session_start();

require_once('../connexion.php');
require_once('read.php');

if (isset($_POST['user'])) {
    $userr = $_POST['user'];
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $exists = false;
        if ($userr != $id) {
            foreach ($admins as $admin) {
                $exists = $admin->id == $id ? true : $exists;
            }
            foreach ($users as $user) {
                $exists = $user->id == $id ? true : $exists;
            }
        }
        if ($exists) {
            if (isset($_POST['role'])) {
                header('Location: ../../controllers/admin/formateursController.php?id=exsits');
            } else {
                header('Location: ../../controllers/admin/adminsController.php?id=exsits');
            }
        } else {
            $_SESSION['id'] = $userr == $currentUser->id ? $id : $_SESSION['id'];
            $res = $conn->query("UPDATE user set id='$id' where id='$userr'");
            if (isset($_POST['nom'])) {
                $nom = strtolower($_POST['nom']);
                $res = $conn->query("UPDATE user set nom='$nom' where id='$id'");
            }
            if (isset($_POST['prenom'])) {
                $prenom = strtolower($_POST['prenom']);
                $res = $conn->query("UPDATE user set prenom='$prenom' where id='$id'");
            }
            if (isset($_POST['password'])) {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $res = $conn->query("UPDATE user set password='$password' where id='$id'");
            }
            if (isset($_POST['role'])) {
                header('Location: ../../controllers/admin/formateursController.php?updated=true');
            } else {
                header('Location: ../../controllers/admin/adminsController.php?updated=true');
            }
        }
    } else {
        if (isset($_POST['nom'])) {
            $nom = strtolower($_POST['nom']);
            $res = $conn->query("UPDATE user set nom='$nom' where id='$userr'");
        }
        if (isset($_POST['prenom'])) {
            $prenom = strtolower($_POST['prenom']);
            $res = $conn->query("UPDATE user set prenom='$prenom' where id='$userr'");
        }
        if (isset($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $res = $conn->query("UPDATE user set password='$password' where id='$userr'");
        }
        if (isset($_POST['role'])) {
            header('Location: ../../controllers/admin/formateursController.php?updated=true');
        } else {
            header('Location: ../../controllers/admin/adminsController.php?updated=true');
        }
    }
}