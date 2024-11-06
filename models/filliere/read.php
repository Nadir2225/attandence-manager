<?php

$rs = $conn->query("SELECT * from filliere");
$fills = $rs->fetchAll(PDO::FETCH_OBJ);