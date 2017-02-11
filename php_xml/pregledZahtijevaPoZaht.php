<?php
include '../aplikacijskiOkvir/baza.class.php';

$IdZahtijeva = '5';
//$IdZahtijeva = $_GET['IdZahtijeva'];

$dbc = new baza();

$sql = "SELECT `idzahtijeva`, `idkorisnik_moderator`, korisnik.ime, korisnik.prezime, "
        . "`datum_podnosenja`, status.naziv, zahtijev_za_legalizacijom.`adresa`, "
        . "županija.naziv, `površina_parcele`, `površina_stamb_prost` "
        . "FROM `zahtijev_za_legalizacijom` JOIN korisnik "
        . "ON zahtijev_za_legalizacijom.idkorisnik_moderator = korisnik.idkorisnik "
        . "JOIN status ON zahtijev_za_legalizacijom.status_idstatus = status.idstatus "
        . "JOIN županija ON zahtijev_za_legalizacijom.županija_idžupanije = županija.idžupanije "
        . "WHERE idkorisnik_podnositelj_zahtj = '$IdKor'";


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
        $output .= '<name idGradjevinara="' . $row[1] . '" ime="' . $row[2]
                . '" prezime="' . $row[3] . '" datum="' . $row[4]
                . '" status="' . $row[5] . '" adresa="' . $row[6]
                . '" zupanija="' . $row[7] . '" parcela="' . $row[8]
                . '" kuca="' . $row[9] . '">' . $row[0] . '</name>' . "\n";
    }
}
$output .= '</zahtijevi>';

header("Content-Type: text/xml");
print $output;
