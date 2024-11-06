<?php 

session_start();

if (!isset($_SESSION['id'])) {
    header('Location: ../../index.php');
} else if ($_SESSION['role'] != 'admin') {
    header('Location: ../homeController.php');
}
$page = 'fill';
require_once('../../models/connexion.php');
require_once('../../models/user/read.php');
require_once('../../models/filliere/read.php');
require_once('../../view/pages/fillieres.php');