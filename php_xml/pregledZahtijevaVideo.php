<?php
include '../aplikacijskiOkvir/baza.class.php';

//$IdZahtijeva = '6';
$IdZahtijeva = $_GET['IdZahtijeva'];

$dbc = new baza();

$sql = "SELECT `naziv`, `link` FROM `video` "
        . "WHERE `zahtijev_za_leg_idzahtijeva` = '$IdZahtijeva'";


$rezultatUpita = $dbc->selectUpit($sql);
   
if (!$rezultatUpita) {
    echo 'Problem kod upita na bazu podataka!';
    exit();
    //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
    }


$output = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>' . "\n";
$output .= '<video>';

$brojRedova = $rezultatUpita->num_rows;

if ($brojRedova) {
    while ($row = $rezultatUpita->fetch_row()) {
        $output .= '<name imeVidea="' . $row[0] . '">' . $row[1] . '</name>' . "\n";
    }
}
$output .= '</video>';

header("Content-Type: text/xml");
print $output;
