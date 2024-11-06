<?php

$combores = $conn->query("SELECT * from combo");
$combos = $combores->fetchAll(PDO::FETCH_OBJ);