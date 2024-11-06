<?php

require_once('../connexion.php');
// require_once('read.php');

if (isset($_POST['stagiaires'])) {
    $stagiaires = explode('-', $_POST['stagiaires']);
    $form = $_POST['form'];
    $year = $_POST['year'];
    $week = $_POST['week'];
    $day = $_POST['day'];
    $seance = $_POST['seance'];
    $group = $_POST['group'];
    $conn->query("INSERT into attendance (form, year, week, day, seance, groupe) values ('$form', $year, $week, '$day', '$seance', $group)");

    $attendanceId =  $conn->lastInsertId();
    foreach ($stagiaires as $str) {
        if ($_POST[$str] == 'a') {
            $conn->query("INSERT into absence (stagiaire, attendance) values ($str, $attendanceId)");
        }
    }
    
    // $stagiaire = strtolower($_POST['stagiaire']);
    // $form = strtolower($_POST['form']);
    // $week = $_POST['week'];
    // $day = $_POST['day'];
    // $senace = $_POST['seance'];
    header('Location: ../../controllers/homeController.php?message=success');
}