<?php

require_once('../connexion.php');

if (isset($_POST['week'])) {
    $week = $_POST['week'];
    $res = $conn->query("UPDATE day set s1='0', s2='0', s3='0', s4='0'  where week='$week'");
    if (isset($_POST['sessions'])) {
        $sessions = $_POST['sessions'];
        foreach ($sessions as $session) {
            $dayId = explode('-', $session)[0];
            $sess = explode('-', $session)[1];
            $res = $conn->query("UPDATE day set $sess='1' where id='$dayId'");
        }
    }
    header('Location: ../../controllers/admin/formateursController.php?updated=true');
}