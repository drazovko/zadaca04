<?php
include '../aplikacijskiOkvir/baza.class.php';

//$idKor = '33';
//$idGradjevinara = '7';

$idKor = $_GET['idKor'];
$idGradjevinara = $_GET['idGradjevinara'];

$dbc = new baza();

$sql = "SELECT korisnik.kor_ime, `komentar` FROM `zahtijev_za_legalizacijom` "
        . "JOIN korisnik ON zahtijev_za_legalizacijom.idkorisnik_podnositelj_zahtj = korisnik.idkorisnik "
        . "WHERE zahtijev_za_legalizacijom.idkorisnik_moderator = '$idGradjevinara' "
        . "AND zahtijev_za_legalizacijom.idkorisnik_podnositelj_zahtj != '$idKor' "
        . "AND zahtijev_za_legalizacijom.komentar IS NOT null";


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
        $output .= '<gradjevinar korIme="' . $row[0] . '">' . $row[1] . '</gradjevinar>' . "\n";
    }
}
$output .= '</zahtijevi>';

header("Content-Type: text/xml");
print $output;