<?php

require_once('connexion.php');

session_start();

if (isset($_GET['logout'])) {
    setcookie("matricule", '', time() - 1, '/');
    setcookie("id", '', time() - 1, '/');
    setcookie("password", '', time() - 1, '/');
    session_destroy(); 
    header('Location: ../index.php');
} else {
    if (isset($_POST['login'])) {
        $id = $_POST['id'];
        $password = $_POST['password'];
        $res = $conn->query("SELECT * from user where id='$id'");
        $table = $res->fetchAll(PDO::FETCH_OBJ);
        if (count($table) === 0) {
            header('Location: ../index.php?error=id');
        } elseif (!password_verify($password, $table[0]->password))  {
            header('Location: ../index.php?error=password');
        } else {
            $_SESSION['id'] = $table[0]->id;
            $_SESSION['role'] = $table[0]->role;
            if (isset($_POST['rememberme'])) {
                setcookie("id", $id, time() + 25920000, '/');
                setcookie("password", $password, time() + 25920000, '/');
            }
            if ($table[0]->role == 'admin') {
                header('Location: ../controllers/admin/homeController.php');
            } else {
                header('Location: ../controllers/homeController.php');
            }
        }
    }
}