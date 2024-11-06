<?php

// require_once('../connexion.php');

if ($_SERVER['PHP_SELF'] == '/gs/controllers/homeController.php') {
    $atdres = $conn->query("SELECT * from attendance");
    $attendances = $atdres->fetchAll(PDO::FETCH_OBJ);
} elseif ($_SERVER['PHP_SELF'] == '/gs/controllers/admin/homeController.php') {
    $atdres = $conn->query("SELECT * from attendance where confirmed=0");
    $attendances = $atdres->fetchAll(PDO::FETCH_OBJ);
    if (isset($_GET['limit'])) {
        $limit = $_GET['limit'];
        $atdres = $conn->query("SELECT * from attendance where confirmed=0 order by id desc limit $limit");
        $atdCres = $conn->query("SELECT count(*) as count from attendance where confirmed=0");
        $attendances = $atdres->fetchAll(PDO::FETCH_OBJ);
        $count = $atdCres->fetchAll(PDO::FETCH_OBJ)[0]->count;
    } else {
        $limit = 10;
        $atdres = $conn->query("SELECT * from attendance where confirmed=0 order by id desc limit $limit");
        $atdCres = $conn->query("SELECT count(*) as count from attendance where confirmed=0");
        $attendances = $atdres->fetchAll(PDO::FETCH_OBJ);
        $count = $atdCres->fetchAll(PDO::FETCH_OBJ)[0]->count;
    }
} elseif($_SERVER['PHP_SELF'] == '/gs/controllers/historyController.php') {
    if (isset($_GET['group'])) {
        $limit = $_GET['limit'];
        if ($_GET['group'] != 'all') {
            $group = $_GET['group'];
            $atdres = $conn->query("SELECT * from attendance where form=$currentUser->id and groupe=$group order by id desc limit $limit");
            $atdCres = $conn->query("SELECT count(*) as count from attendance where form=$currentUser->id and groupe=$group");
            $attendances = $atdres->fetchAll(PDO::FETCH_OBJ);
            $count = $atdCres->fetchAll(PDO::FETCH_OBJ)[0]->count;
        } else {
            $atdres = $conn->query("SELECT * from attendance where form=$currentUser->id order by id desc limit $limit");
            $atdCres = $conn->query("SELECT count(*) as count from attendance where form=$currentUser->id");
            $attendances = $atdres->fetchAll(PDO::FETCH_OBJ);
            $count = $atdCres->fetchAll(PDO::FETCH_OBJ)[0]->count;
        }
    } else {
        $limit = 10;
        $atdres = $conn->query("SELECT * from attendance where form=$currentUser->id order by id desc limit $limit");
        $atdCres = $conn->query("SELECT count(*) as count from attendance where form=$currentUser->id");
        $attendances = $atdres->fetchAll(PDO::FETCH_OBJ);
        $count = $atdCres->fetchAll(PDO::FETCH_OBJ)[0]->count;
    }
} elseif ($_SERVER['PHP_SELF'] == '/gs/controllers/admin/historyController.php') {
    if (isset($_GET['group']) && isset($_GET['week']) && isset($_GET['day']) && isset($_GET['order']) && isset($_GET['limit'])) {
        $limit = $_GET['limit'];
        $order = $_GET['order'];
        $start = strpos($_GET['week'], 'W') + 1;
        $week = intval(substr($_GET['week'], $start));
        $year = intval(substr($_GET['week'], 0, 4));
        if ($_GET['group'] != '' && $_GET['day'] != '') {
            $group = $_GET['group'];
            $day = $_GET['day'];
            $atdres = $conn->query("SELECT * from attendance where week=$week and year=$year and day='$day' and groupe=$group order by id $order limit $limit");
            $atdCres = $conn->query("SELECT count(*) as count from attendance where week=$week and year=$year and day='$day' and groupe=$group");
        } elseif ($_GET['group'] != '' && $_GET['day'] == '') {
            $group = $_GET['group'];
            $atdres = $conn->query("SELECT * from attendance where week=$week and year=$year and groupe=$group order by id $order limit $limit");
            $atdCres = $conn->query("SELECT count(*) as count from attendance where week=$week and year=$year and groupe=$group");
        }  elseif ($_GET['group'] == '' && $_GET['day'] != '') {
            $day = $_GET['day'];
            $atdres = $conn->query("SELECT * from attendance where week=$week and year=$year and day='$day' order by id $order limit $limit");
            $atdCres = $conn->query("SELECT count(*) as count from attendance where week=$week and year=$year and day='$day'");
        } else {
            $atdres = $conn->query("SELECT * from attendance where week=$week and year=$year order by id $order limit $limit");
            $atdCres = $conn->query("SELECT count(*) as count from attendance where week=$week and year=$year");
        }
        $attendances = $atdres->fetchAll(PDO::FETCH_OBJ);
        $count = $atdCres->fetchAll(PDO::FETCH_OBJ)[0]->count;
    } else {
        $limit = 10;
        $atdres = $conn->query("SELECT * from attendance order by id desc limit $limit");
        $atdCres = $conn->query("SELECT count(*) as count from attendance");
        $attendances = $atdres->fetchAll(PDO::FETCH_OBJ);
        $count = $atdCres->fetchAll(PDO::FETCH_OBJ)[0]->count;
    }
} elseif ($_SERVER['PHP_SELF'] == '/gs/controllers/admin/updateController.php') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $atdres = $conn->query("SELECT * from attendance where id=$id");
        $attendance = $atdres->fetchAll(PDO::FETCH_OBJ)[0];
    }
}
