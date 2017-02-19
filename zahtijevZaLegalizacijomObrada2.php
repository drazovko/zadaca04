<?php

//include_once('../aplikacijskiOkvir/aplikacijskiOkvir.php');
include 'aplikacijskiOkvir/baza.class.php';
include 'aplikacijskiOkvir/vrijeme_sustava.php';
//dnevnik_zapis("Zaboravljena lozinka");
/*
$IdKor = '20';
$idGradjevinaraStr = '11asdf';
$zupanija = '5';
$adresa = 'Lijeva kuća';
$parcela = '33';
$kuca = '366';
*/
$IdKor = $_GET['IdKor'];
$idGradjevinaraStr = $_GET['idGradjevinara'];
$zupanija = $_GET['zupanija'];
$adresa = $_GET['adresa'];
$parcela = $_GET['klizac1'];
$kuca = $_GET['klizac2'];

$idGradjevinara = filter_var($idGradjevinaraStr, FILTER_SANITIZE_NUMBER_INT);

global $virtualnoVrijemeSustava;
$datumDanas = date(DATE_ISO8601, $virtualnoVrijemeSustava);

$dbc = new baza();

$sql = "INSERT INTO `zahtijev_za_legalizacijom`(idkorisnik_podnositelj_zahtj, "
        . "idkorisnik_moderator, datum_podnosenja, status_idstatus, adresa, `županija_idžupanije`, "
        . "`površina_parcele`, `površina_stamb_prost`) VALUES ('$IdKor', '$idGradjevinara', '$datumDanas', 1, "
        . "'$adresa', '$zupanija', '$parcela', '$kuca')";

 $rezultatUpita = $dbc->selectUpit($sql);
   
if (!$rezultatUpita) {
    echo 'Problem kod upita na bazu podataka!';
    exit();
    //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
    }  else {
    $sveOK = 1;
}


$output = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>' . "\n";
$output .= '<kor_ime>';


$output .= '<korisnik korIme="' . $IdKor . '">' . $sveOK . '</korisnik>' . "\n";


$output .= '</kor_ime>';

header("Content-Type: text/xml");
print $output;

