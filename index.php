<?php
session_start();

if (isset($_SESSION['id'])) {
    header('Location: ./controllers/homeController.php');
} else if (isset($_COOKIE['id'])) {
    ?> 
    <form action="./models/security.php" method="post" id="myForm">
        <input type="hidden" name="login">
        <input type="hidden" name="id" value="<?= $_COOKIE['id'] ?>">
        <input type="hidden" name="password" value="<?= $_COOKIE['password'] ?>">
    </form>
    <script>document.getElementById("myForm").submit()</script>
    <?php
}
require_once('./view/pages/login.php');