<?php
include '../aplikacijskiOkvir/baza.class.php';

//$IdZahtijeva = '6';
$IdZahtijeva = $_GET['IdZahtijeva'];

$dbc = new baza();

$sql = "SELECT `naslov`, `link` FROM `dokument` WHERE `zahtijev_idzahtijeva` = '$IdZahtijeva'";


$rezultatUpita = $dbc->selectUpit($sql);
   
if (!$rezultatUpita) {
    echo 'Problem kod upita na bazu podataka!';
    exit();
    //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
    }


$output = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>' . "\n";
$output .= '<dokument>';

$brojRedova = $rezultatUpita->num_rows;

if ($brojRedova) {
    while ($row = $rezultatUpita->fetch_row()) {
        $output .= '<name imeDokumenta="' . $row[0] . '">' . $row[1] . '</name>' . "\n";
    }
}
$output .= '</dokument>';

header("Content-Type: text/xml");
print $output;
