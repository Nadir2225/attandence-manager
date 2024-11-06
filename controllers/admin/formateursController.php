<?php 

session_start();

if (!isset($_SESSION['id'])) {
    header('Location: ../../index.php');
} else if ($_SESSION['role'] != 'admin') {
    header('Location: ../homeController.php');
}
$page = 'form';
require_once('../../models/connexion.php');
require_once('../../models/user/read.php');
require_once('../../models/groupe/read.php');
require_once('../../models/combo/read.php');
require_once('../../view/pages/formateurs.php');