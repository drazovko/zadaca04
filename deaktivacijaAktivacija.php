<?php
include 'aplikacijskiOkvir/aplikacijskiOkvir.php';

$korisnik = provjeraUloge(ADMINISTRATOR);                          
//dnevnik zapis spušetn niže


$idKorisnika = $_POST["idKorisnika"];
$aktiviran = $_POST["aktiviranPromjena"];
$korIme = $_POST["kor_ime"];
dnevnik_zapis("De/Aktivacija kor: $korIme $aktiviran");

$dbc = new baza();

$sql = "UPDATE korisnik SET `aktiviran`='$aktiviran' "
            . "WHERE idkorisnik = $idKorisnika";
        
    
$rezultatUpita = $dbc->ostaliUpiti($sql);
    
if ($rezultatUpita == 1) {
    header("Location: detalji_korisnikaADM.php?korIme=$korIme");
}  else {
    echo "KorIme: " . $korIme . " Id: $idKorisnika" . " Aktiviran: " . $aktiviran;
}
// Ovo treba završiti!!!
echo "KorIme: " . $korIme . " Id: $idKorisnika" . " Aktiviran: " . $aktiviran;
