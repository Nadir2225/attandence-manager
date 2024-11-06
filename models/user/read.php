<?php
// require_once('../connexion.php');

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $res = $conn->query("SELECT * from user where id='$id'");
    $currentUser = $res->fetchAll(PDO::FETCH_OBJ)[0];
}
$res2 = $conn->query("SELECT * from user where role='admin'");
$admins = $res2->fetchAll(PDO::FETCH_OBJ);


$res3 = $conn->query("SELECT * from user where role='user'");
$users = $res3->fetchAll(PDO::FETCH_OBJ);