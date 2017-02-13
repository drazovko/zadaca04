<?php
include '../aplikacijskiOkvir/baza.class.php';

$dbc = new baza();

$sql = "SELECT `ime`, `prezime`, COALESCE(zahtijev_za_legalizacijom.idzahtijeva, '-') as zahtijev, "
        . "COALESCE(zahtijev_za_legalizacijom.ocjena, '-') "
        . "FROM `korisnik` LEFT JOIN zahtijev_za_legalizacijom "
        . "ON korisnik.idkorisnik = zahtijev_za_legalizacijom.idkorisnik_moderator "
        . "WHERE korisnik.uloga_iduloga = 3";


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
        $output .= '<name imeGradjevinara="' . $row[0] . '" prezime="' . $row[1]
                . '" zahtijev="' . $row[2]
                . '">' . $row[3] . '</name>' . "\n";
    }
}
$output .= '</zahtijevi>';

header("Content-Type: text/xml");
print $output;

