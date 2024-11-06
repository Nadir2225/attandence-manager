<?php 

session_start();

if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
} else if ($_SESSION['role'] == 'admin') {
    header('Location: ./admin/homeController.php');
}
require_once('../models/connexion.php');
require_once('../models/user/read.php');
$formateur = $currentUser;
require_once('../models/emploi/read.php');
require_once('../models/groupe/read.php');
require_once('../models/combo/read.php');
require_once('../models/attendance/read.php');
require_once('../models/stagiaire/read.php');
require_once('../view/pages/formHome.php');