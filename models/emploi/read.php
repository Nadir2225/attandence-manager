<?php

if (isset($formateur)) {
    $weekres = $conn->query("SELECT * from week where form='$formateur->id'");
    $week = $weekres->fetchAll(PDO::FETCH_OBJ)[0];
    $daysres = $conn->query("SELECT * from day where week='$week->id'");
    $days = $daysres->fetchAll(PDO::FETCH_OBJ);
}