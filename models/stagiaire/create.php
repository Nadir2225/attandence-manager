<?php

use function PHPSTORM_META\type;

require_once('../connexion.php');
require_once('read.php');

if (isset($_POST['addStr'])) {
    $nom = strtolower($_POST['nom']);
    $prenom = strtolower($_POST['prenom']);
    $gro = $_POST['group'];
    $res = $conn->prepare('INSERT into stagiaire (nom, prenom, groupe) values (?, ?, ?)');
    $res->execute([$nom, $prenom, $gro]);
    header('Location: ../../controllers/admin/stagiairesController.php?message=success');
}

if (isset($_POST['import'])) {
    $gro = $_POST['group'];
    $valid_csv = true;
    if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE) {
        $iteration = 1;
        while (($data = fgetcsv($handle, null, ",",)) !== FALSE) {
            if ($iteration == 1) {
                if (count($data) != 2 || strtolower($data[0]) != 'nom' || strtolower($data[1]) != 'prenom') {
                    $valid_csv = false;
                }
            } else {

                if (count($data) != 2 || gettype($data[0]) != 'string' || gettype($data[1]) != 'string') {
                    $valid_csv = false;
                }
            }
            $iteration += 1;
        }
        fclose($handle);
    }
    if ($valid_csv) {
        if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE) {
            $iteration = 1;
            while (($data = fgetcsv($handle, null, ",",)) !== FALSE) {
                if ($iteration != 1) {
                    $nom = strtolower($data[0]);
                    $prenom = strtolower($data[1]);
                    $res = $conn->prepare('INSERT into stagiaire (nom, prenom, groupe) values (?, ?, ?)');
                    $res->execute([$nom, $prenom, $gro]);
                }
                $iteration += 1;
            }
            fclose($handle);
        }
        header('Location: ../../controllers/admin/stagiairesController.php?message=success');
    } else {
        header('Location: ../../controllers/admin/stagiairesController.php?error=csv');
    }
}