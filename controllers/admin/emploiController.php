<?php 

session_start();

if (!isset($_SESSION['id'])) {
    header('Location: ../../index.php');
} else if ($_SESSION['role'] != 'admin') {
    header('Location: ../homeController.php');
}
if (isset($_GET['form'])) {
    $page = 'form';
    require_once('../../models/connexion.php');
    require_once('../../models/user/read.php');
    foreach ($users as $form) {
        if ($form->id == $_GET['form']) {
            $formateur = $form;
        }
    }
    require_once('../../models/emploi/read.php');
    require_once('../../view/pages/formEmploi.php');
} else {
    header('Location: formateursController.php');
}