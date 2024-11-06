<?php

// require_once('../connexion.php');

// if ($_SERVER['PHP_SELF'] == '/gs/controllers/homeController.php') {
    $absres = $conn->query("SELECT * from absence");
    $absences = $absres->fetchAll(PDO::FETCH_OBJ);
// } elseif($_SERVER['PHP_SELF'] == '/gs/controllers/historyController.php') {
//     if (isset($_GET['group'])) {
//         $limit = $_GET['limit'];
//         if ($_GET['group'] != 'all') {
//             $group = $_GET['group'];
//             $atdres = $conn->query("SELECT * from attendance where form=$currentUser->id and groupe=$group order by id desc limit $limit");
//             $attendances = $atdres->fetchAll(PDO::FETCH_OBJ);
//         } else {
//             $atdres = $conn->query("SELECT * from attendance where form=$currentUser->id order by id desc limit $limit");
//             $attendances = $atdres->fetchAll(PDO::FETCH_OBJ);
//         }
//     } else {
//         $limit = 10;
//         $atdres = $conn->query("SELECT * from attendance where form=$currentUser->id order by id desc limit $limit");
//         $attendances = $atdres->fetchAll(PDO::FETCH_OBJ);
//         // $atdres = $conn->query("SELECT count(*) as len from attendance");
//         // echo $attendances = $atdres->fetchAll(PDO::FETCH_ASSOC)[0]['len'];
//         // $atdres = $conn->query("SELECT groupe , count(*) as len from attendance group by groupe");
//         // print_r($disp = $atdres->fetchAll(PDO::FETCH_ASSOC));
//     }
// }