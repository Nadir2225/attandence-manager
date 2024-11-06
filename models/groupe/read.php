<?php

$r = $conn->query("SELECT * from groupe");
$groups = $r->fetchAll(PDO::FETCH_OBJ);