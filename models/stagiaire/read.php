<?php
$strres = $conn->query("SELECT * from stagiaire order by groupe");
$stagiaires = $strres->fetchAll(PDO::FETCH_OBJ);