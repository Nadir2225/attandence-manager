<?php

require_once('./SimpleXLSXGen.php');
require_once('../connexion.php');
require_once('../stagiaire/read.php');
require_once('../absence/read.php');
require_once('../groupe/read.php');
if (isset($_POST['week'])) {
    $start = strpos($_POST['week'], 'W') + 1;
    $week = intval(substr($_POST['week'], $start));
    $year = intval(substr($_POST['week'], 0, 4));
    function getStartAndEndDate($w, $y) {
        $dto = new DateTime();
        $dto->setISODate($y, $w);
        $ret = $dto->format('d-m-Y');
        return $ret;
    }
    $atdres = $conn->query("SELECT * from attendance where week=$week and year=$year");
    $attendances = $atdres->fetchAll(PDO::FETCH_OBJ);
    
    $attendance = [['<center>' . getStartAndEndDate($week, $year) . '</center>']];
    $attendance[] = ['<center>GROUPE</center>', '<center>NOM</center>', '<center>PRENOM</center>', '<center>Lundi</center>', null, null, null, '<center>Mardi</center>', null, null, null, '<center>Mercredi</center>', null, null, null, '<center>Jeudi</center>', null, null, null, '<center>Vendredi</center>', null, null, null, '<center>Samedi</center>', null, null, null];
    $attendance[] = [null, null, null, 's1', 's2', 's3', 's4', 's1', 's2', 's3', 's4', 's1', 's2', 's3', 's4', 's1', 's2', 's3', 's4', 's1', 's2', 's3', 's4', 's1', 's2', 's3', 's4'];
    foreach($stagiaires as $s) {
        $thisg = '';
        foreach ($groups as $g) {
            $thisg = $g->id == $s->groupe ? $g->titre : $thisg;
        }
        $thiss = [$thisg, $s->nom, $s->prenom, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
        $daysIndex = ['Lundi' => 3, 'Mardi' => 7, 'Mercredi' => 11, 'Jeudi' => 15, 'Vendredi' => 19, 'Samedi' => 23];
        foreach($attendances as $a) {
            
            if ($a->groupe == $s->groupe) {
                $abs = false;
                foreach ($absences as $ab) {
                    $abs = $ab->attendance == $a->id && $ab->stagiaire == $s->id ? true : $abs;
                }
                $s = ($a->seance == 's1') ? 0 :( ($a->seance == 's2') ? 1 : (($a->seance == 's3') ? 2 : ($a->seance == 's4' ? 3 : '')));
                $thiss[$daysIndex[$a->day] + $s] = $abs == true ? 'a' : 'p';
            }
        }
        $attendance[] = $thiss;
    }
    
    Shuchkin\SimpleXLSXGen::fromArray( $attendance )
        ->mergeCells('a1:aa1')
        ->mergeCells('a2:a3')
        ->mergeCells('b2:b3')
        ->mergeCells('c2:c3')
        ->mergeCells('d2:g2')
        ->mergeCells('h2:k2')
        ->mergeCells('l2:o2')
        ->mergeCells('p2:s2')
        ->mergeCells('t2:w2')
        ->mergeCells('x2:aa2')
        ->setColWidth(1,12)
        ->setColWidth(2, 20)
        ->setColWidth(3, 20)
        ->setColWidth(4,3)
        ->setColWidth(8,3)
        ->setColWidth(12,3)
        ->setColWidth(16,3)
        ->setColWidth(20,3)
        ->setColWidth(24,3)
        // ->saveAs('attendance.xlsx');
        ->downloadAs('attendance.xlsx');
}