<?php 

$host = 'localhost';
$db = 'gs';
$user = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);
} catch(PDOException $e) {
    echo $e->getMessage();
}