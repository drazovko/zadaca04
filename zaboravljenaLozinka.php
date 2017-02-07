<?php
include 'aplikacijskiOkvir/aplikacijskiOkvir.php';

$korisnik = provjeraUloge(ADMINISTRATOR);                          
//dnevnik zapis spušetn niže


$idKorisnika = $_POST["idKorisnika"];
$zakljucan = $_POST["zakljucanPromjena"];
$korIme = $_POST["kor_ime"];
dnevnik_zapis("Otklj/Zaklj kor: $korIme");

$dbc = new baza();

$sql = "UPDATE korisnik SET `zaključan`='$zakljucan' "
            . "WHERE idkorisnik = $idKorisnika";
        
    
$rezultatUpita = $dbc->ostaliUpiti($sql);
    
if ($rezultatUpita == 1) {
    //echo "idKorisnika = " . $idKorisnika . "<br>";
    //echo "zaključan = " . $zakljucan . "<br>";
    //echo "korIme = " . $korIme;
    header("Location: detalji_korisnikaADM.php?korIme=$korIme");
}  else {
    echo "KorIme: " . $korIme . " Id: $idKorisnika" . " Zaključan: " . $zakljucan . " Problem sa upisom u bazu";
}
// Ovo treba završiti!!!