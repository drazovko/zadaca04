<?php
include '../aplikacijskiOkvir/baza.class.php';

$korIme = $_GET['korisnik'];
//$korIme = "juradrugi";

$dbc = new baza();

$sql = "SELECT kor_ime FROM `korisnik` WHERE kor_ime = '$korIme'";
    
$rezultatUpita = $dbc->selectUpit($sql);
   
if (!$rezultatUpita) {
    echo 'Problem kod upita na bazu podataka!';
    exit();
    //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
    }


$output = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>' . "\n";
$output .= '<kor_ime>';

$brojRedova = $rezultatUpita->num_rows;

if ($brojRedova) {
    while ($row = $rezultatUpita->fetch_row()) {
        $output .= '<korisnik korIme="' . $row[0] . '">' . 1 . '</korisnik>' . "\n";
    }
}
$output .= '</kor_ime>';

header("Content-Type: text/xml");
print $output;