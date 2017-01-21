<?php
function provjeraLozinke($pass) {
    $dobraLozinka = FALSE;
    $imaBroj = 0;
    $imaVelikoSlovo = 0;
    $imaMaloSlovo = 0;
    
    for ($index = 0; $index < strlen($pass); $index++) {
        if (is_numeric($pass[$index])) {
            $imaBroj++;
        } else {
            if ($pass[$index] === strtolower($pass[$index])) {
            $imaMaloSlovo++;
            }
            if ($pass[$index] === strtoupper($pass[$index])) {
            $imaVelikoSlovo++;
            }    
        }  
    }
    
    if ($imaBroj > 1 && $imaMaloSlovo > 1 && $imaVelikoSlovo > 1) {
        $dobraLozinka = TRUE;
    }
    return $dobraLozinka;
}

function provjeraZauzetostiKorImenaMaila($zaProvjeru, $var2=1, $id=0) {
    $imeSlobodno = TRUE;
    $dbc = new baza();
    $sql = "select idkorisnik, kor_ime, email from korisnik "
            . "where kor_ime = '$zaProvjeru'";
    $sql2 = "select idkorisnik, kor_ime, email from korisnik "
            . "where email = '$zaProvjeru'";
    if ($var2 === 1) {
        $rezultatUpita = $dbc->selectUpit($sql);
    }  else {
        $rezultatUpita = $dbc->selectUpit($sql2);
    }
    
    $brojRedova = $rezultatUpita->num_rows;
    if ($brojRedova > 0) {
        $imeSlobodno = FALSE;
        if($brojRedova == 1 && $id != 0){
            list( $idKorisnika, $korIme, $email) = $rezultatUpita->fetch_array();
            if ($id === $idKorisnika) {
                $imeSlobodno = TRUE;
            }
            echo 'ID = ' . $id;
        }
    }
    return $imeSlobodno;
}

function zapisNovogKorisnikaUBazu($aktivacijski_kod){
    $aktivacijskiKod = $aktivacijski_kod;
    if (isset($_POST['ime'])) {
            $ime = $_POST['ime'];
        }
    if (isset($_POST['prezime'])) {
            $prezime = $_POST['prezime'];
    }
    if (isset($_POST['datoteka'])) {
        $slika = "";
    }  else {
        $slika = "";
    }
    if (isset($_POST['adresa'])) {
        $adresa = $_POST['adresa'];
    }
    if (isset($_POST['zupanija'])) {
        $zupanija = intval($_POST['zupanija']);
    }
    if (isset($_POST['grad'])) {
        $grad = $_POST['grad'];
    }
    if (isset($_POST['mail'])) {
        $mail = $_POST['mail'];
    }
    if (isset($_POST['kor_ime'])) {
        $kor_ime = $_POST['kor_ime'];
    }
    if (isset($_POST['lozinka'])) {
        $lozinka = $_POST['lozinka'];
    }
    if (isset($_POST['telefon'])) {
        $telefon = $_POST['telefon'];
    }
    if (isset($_POST['dat_rodj'])) {
        $dat_rod = $_POST['dat_rodj'];
    }
    if (isset($_POST['spol'])) {
        $spol = $_POST['spol'];
    }
    if (isset($_POST['pretplata'])) {
        $pretplata = 1;
    }  else {
        $pretplata = 0;
    }
    global $virtualnoVrijemeSustava;
    $datumDanas = date(DATE_ISO8601, $virtualnoVrijemeSustava);
    
    $dbc = new baza();
    
    $sql = "INSERT INTO korisnik(  `ime` ,  `prezime` ,  `slika_link` ,  `adresa` ,  `zupanija` ,  `grad` ,  `email` ,  `kor_ime` ,  `password` ,  `telefon` ,  `datum_rodjenja` ,  `spol` , `pretplata_na_mail` ,  `uloga_iduloga` ,  `aktiviran` ,  `datum_upisa` ,  `zaključan`, `aktivacijski_kod` ) VALUES ('$ime',  '$prezime',  '$slika',  '$adresa',  '$zupanija',  '$grad',  '$mail',  '$kor_ime',  '$lozinka',  '$telefon',  '$dat_rod',  '$spol',  '$pretplata', 5, 0,  '$datumDanas', 0, '$aktivacijskiKod')";
    
    $rezultatUpita = $dbc->ostaliUpiti($sql);
    
    return $rezultatUpita;
}

function azuriranjeKorisnika($idKorisnika){
    if (isset($_POST['ime'])) {
            $ime = $_POST['ime'];
        }
    if (isset($_POST['prezime'])) {
            $prezime = $_POST['prezime'];
    }
    if (isset($_POST['datoteka'])) {
        $slika = "";
    }  else {
        $slika = "";
    }
    if (isset($_POST['adresa'])) {
        $adresa = $_POST['adresa'];
    }
    if (isset($_POST['zupanija'])) {
        $zupanija = intval($_POST['zupanija']);
    }
    if (isset($_POST['grad'])) {
        $grad = $_POST['grad'];
    }
    if (isset($_POST['mail'])) {
        $mail = $_POST['mail'];
    }
    if (isset($_POST['kor_ime'])) {
        $kor_ime = $_POST['kor_ime'];
    }
    if (isset($_POST['lozinka'])) {
        $lozinka = $_POST['lozinka'];
    }
    if (isset($_POST['telefon'])) {
        $telefon = $_POST['telefon'];
    }
    if (isset($_POST['dat_rodj'])) {
        $dat_rod = $_POST['dat_rodj'];
    }
    if (isset($_POST['spol'])) {
        $spol = $_POST['spol'];
    }
    if (isset($_POST['pretplata'])) {
        $pretplata = 1;
    }  else {
        $pretplata = 0;
    }
    global $virtualnoVrijemeSustava;
    $datumDanas = date(DATE_ISO8601, $virtualnoVrijemeSustava);
    
    $dbc = new baza();
    
    $sql = "UPDATE korisnik SET `ime`='$ime',`prezime`='$prezime',`slika_link`='$slika',"
            . "`adresa`='$adresa',`zupanija`='$zupanija',`grad`='$grad',`email`='$mail',"
            . "`kor_ime`='$kor_ime',`password`='$lozinka',`telefon`='$telefon',"
            . "`datum_rodjenja`='$dat_rod',`spol`='$spol',`pretplata_na_mail`='$pretplata' "
            . "WHERE idkorisnik = $idKorisnika";
    
    
    //$sql = "update korisnik set ime='$ime' where idkorisnik = $idKorisnika";
    $rezultatUpita = $dbc->ostaliUpiti($sql);
    
    return $rezultatUpita;
}

function provjeraZauzetostiAktivacijskogKoda($zaProvjeru) {
    $kodSlobodan = TRUE;
    $dbc = new baza();
    $sql = "select kor_ime from korisnik "
            . "where aktivacijski_kod = '$zaProvjeru'";
    
    $rezultatUpita = $dbc->selectUpit($sql);
    
    $brojRedova = $rezultatUpita->num_rows;
    if ($brojRedova > 0) {
        $kodSlobodan = FALSE;
    }
    return $kodSlobodan;
}