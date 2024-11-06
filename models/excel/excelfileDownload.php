<?php

require_once('./SimpleXLSXGen.php');
require_once('../connexion.php');

if (isset($_POST['type'])) {
    if (isset($_POST['day'])) {
        $day = $_POST['day'];
        $start = strpos($_POST['week'], 'W') + 1;
        $week = intval(substr($_POST['week'], $start));
        $year = intval(substr($_POST['week'], 0, 4));
        $sql = "SELECT 
                f.titre AS filliere,
                g.titre AS groupe,
                s.nom AS nom, 
                s.prenom AS prenom,
                a.week, 
                a.day
            FROM 
                absence ab
            JOIN 
                attendance a ON ab.attendance = a.id
            JOIN 
                stagiaire s ON ab.stagiaire = s.id
            JOIN 
                groupe g ON s.groupe = g.id
            JOIN 
                filliere f ON g.fill = f.id
            WHERE 
                a.year = ? AND a.week = ? AND a.day = ?
            GROUP BY
                s.id
            ORDER BY 
                f.id, g.id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$year, $week, $day]);
        $r = $stmt->fetchAll(PDO::FETCH_OBJ);
    } else {
        $start = strpos($_POST['week'], 'W') + 1;
        $week = intval(substr($_POST['week'], $start));
        $year = intval(substr($_POST['week'], 0, 4));
        $sql = "SELECT 
                f.titre AS filliere,
                g.titre AS groupe,
                s.nom AS nom, 
                s.prenom AS prenom,
                a.week
            FROM 
                absence ab
            JOIN 
                attendance a ON ab.attendance = a.id
            JOIN 
                stagiaire s ON ab.stagiaire = s.id
            JOIN 
                groupe g ON s.groupe = g.id
            JOIN 
                filliere f ON g.fill = f.id
            WHERE 
                a.year AND a.week = ?
            GROUP BY
                s.id
            ORDER BY 
                f.id, g.id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$week]);
        $r = $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    if (count($r) != 0) {
        $attendance = [['Filliere', 'GROUPE', 'NOM STAGIAIRE', 'PRENOM STAGIAIRE']];
        foreach ($r as $s) {
            $attendance[] = [$s->filliere, $s->groupe, $s->nom, $s->prenom];
        }
        $xlsx = Shuchkin\SimpleXLSXGen::fromArray( $attendance );
        $xlsx->saveAs('attendance.xlsx');
        $xlsx->downloadAs('attendance.xlsx');
    } else {
        header('Location: ../../controllers/admin/dailyAbsController.php?abs=zero');
    }
}