<?php
include '../aplikacijskiOkvir/baza.class.php';

//dnevnik_zapis("Zaboravljena lozinka");

//$idGradjevinara = '7';
//$idKor = '33';
//$komentarRegKor = 'probni tekst komentara';
$IdZahtijeva = $_GET['idZahtijeva'];
$idGradjevinara = $_GET['idGradjevinara'];
$idKor = $_GET['idKorisnika'];
$komentarRegKor = $_GET['komentarRegKor'];

$dbc = new baza();

$sql = "UPDATE `zahtijev_za_legalizacijom` SET `komentar`= '$komentarRegKor' WHERE `idzahtijeva` = '$IdZahtijeva'";

$rezultatUpita = $dbc->selectUpit($sql);
   
if (!$rezultatUpita) {
    echo 'Problem kod upita na bazu podataka!';
    exit();
    //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
    }  else {
    $sveOK = 1;
}

$output = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>' . "\n";
$output .= '<obrada>';

$output .= '<obradjen idKor="' . $idKor . '">' . $sveOK . '</obradjen>' . "\n";

$output .= '</obrada>';


header("Content-Type: text/xml");
print $output;
