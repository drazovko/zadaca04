<?php

include '../aplikacijskiOkvir/baza.class.php';

//$idKor = '20';
$idKor = $_GET['IdKor'];

$dbc = new baza();

$sql = "SELECT županija.naziv, zahtijev_za_legalizacijom.idzahtijeva, status.naziv "
        . "FROM `moderator_has_županija` JOIN županija "
        . "ON moderator_has_županija.`županija_idžupanije` = županija.idžupanije "
        . "LEFT JOIN zahtijev_za_legalizacijom "
        . "ON županija.idžupanije = zahtijev_za_legalizacijom.županija_idžupanije "
        . "JOIN status ON zahtijev_za_legalizacijom.status_idstatus = status.idstatus "
        . "WHERE moderator_has_županija.korisnik_idkorisnik = '$idKor'";


$rezultatUpita = $dbc->selectUpit($sql);
   
if (!$rezultatUpita) {
    echo 'Problem kod upita na bazu podataka!';
    exit();
    //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
    }


$output = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>' . "\n";
$output .= '<zahtijevi>';

$brojRedova = $rezultatUpita->num_rows;

if ($brojRedova) {
    while ($row = $rezultatUpita->fetch_row()) {
        $output .= '<name zupanija="' . $row[0] . '" status="' . $row[2] .'">' . $row[1] . '</name>' . "\n";
    }
}
$output .= '</zahtijevi>';

header("Content-Type: text/xml");
print $output;