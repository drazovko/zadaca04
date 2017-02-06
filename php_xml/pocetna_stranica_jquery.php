<?php
include '../aplikacijskiOkvir/baza.class.php';

$dbc = new baza();

$sql = "SELECT idžupanije, naziv FROM `županija`";
    
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
        $output .= '<name sifra="' . $row[0] . '">' . $row[1] . '</name>' . "\n";
    }
}
$output .= '</zupanije>';

header("Content-Type: text/xml");
print $output;