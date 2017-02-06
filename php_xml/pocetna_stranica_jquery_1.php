<?php
include '../aplikacijskiOkvir/baza.class.php';

$idZupanije = $_GET['idZupanije'];
//$idZupanije = 21;

$dbc = new baza();

$sql = "SELECT `korisnik`.`ime`, `korisnik`.`prezime`, `moderator_has_županija`.`županija_idžupanije` "
        . "FROM `korisnik` JOIN `moderator_has_županija` "
        . "ON `moderator_has_županija`.`korisnik_idkorisnik` = `korisnik`.`idkorisnik` "
        . "AND moderator_has_županija.županija_idžupanije = $idZupanije";
    
$rezultatUpita = $dbc->selectUpit($sql);
   
if (!$rezultatUpita) {
    echo 'Problem kod upita na bazu podataka!';
    exit();
    //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
    }


$output = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>' . "\n";
$output .= '<zupanije>';

$brojRedova = $rezultatUpita->num_rows;

if ($brojRedova) {
    while ($row = $rezultatUpita->fetch_row()) {
        $output .= '<name ime="' . $row[0] . '" prezime="' . $row[1] . '">' . $row[2] . '</name>' . "\n";
    }
}
$output .= '</zupanije>';

header("Content-Type: text/xml");
print $output;