<?php

include '../aplikacijskiOkvir/baza.class.php';

//$idKor = '2';
$idKor = $_GET['IdKor'];

$dbc = new baza();

$sql = "SELECT `idzahtijeva`, korisnik.kor_ime, `datum_podnosenja`, status.naziv, "
        . "zahtijev_za_legalizacijom.adresa, županija.naziv, `površina_parcele`, "
        . "`površina_stamb_prost`, korisnik.email, `ocjena`, `komentar` "
        . "FROM `zahtijev_za_legalizacijom` JOIN korisnik "
        . "ON zahtijev_za_legalizacijom.idkorisnik_podnositelj_zahtj = korisnik.idkorisnik "
        . "JOIN status ON zahtijev_za_legalizacijom.status_idstatus = status.idstatus "
        . "JOIN županija ON zahtijev_za_legalizacijom.županija_idžupanije = županija.idžupanije "
        . "WHERE `status_idstatus` != 1 AND `idkorisnik_moderator` = '$idKor' "
        . "ORDER BY status.naziv DESC";


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
        $output .= '<name zahtijev="' . $row[0] . '" korIme="' . $row[1] 
                . '" datum="' . $row[2] . '" status="' . $row[3] 
                . '" adresa="' . $row[4] . '" zupanija="' . $row[5] 
                . '" parcela="' . $row[6] . '" mail="' . $row[8] . '">' . $row[7] . '</name>' . "\n";
    }
}
$output .= '</zahtijevi>';

header("Content-Type: text/xml");
print $output;