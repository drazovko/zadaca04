<?php
include 'aplikacijskiOkvir/aplikacijskiOkvir.php';

$korisnik = provjeraUloge(ADMINISTRATOR);                          
//dnevnik_zapis("Početak aplikacije");


$idKorisnika = $_POST["idKorisnika"];
$aktiviran = $_POST["aktiviranPromjena"];
$korIme = $_POST["kor_ime"];

$dbc = new baza();

$sql = "UPDATE korisnik SET `aktiviran`='$aktiviran' "
            . "WHERE idkorisnik = $idKorisnika";
        
    
$rezultatUpita = $dbc->ostaliUpiti($sql);
    
if ($rezultatUpita == 1) {
    header("Location: detalji_korisnikaADM.php?korIme=$korIme");
}  else {
    echo "KorIme: " . $korIme . " Id: $idKorisnika" . " Aktiviran: " . $aktiviran;
}

echo "KorIme: " . $korIme . " Id: $idKorisnika" . " Aktiviran: " . $aktiviran;
