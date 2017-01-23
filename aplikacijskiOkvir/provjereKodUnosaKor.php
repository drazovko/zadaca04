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
    if (isset($_POST['aktiviran'])) {
        $aktiviran = $_POST['aktiviran'];
    }
  
    $dbc2 = new baza();
        
    $sql2 = "SELECT `idkorisnik`, `ime`, `prezime`, `adresa`, županija.naziv, `zupanija`, `grad`, `email`, "
            . "`kor_ime`, `password`, `telefon`, `datum_rodjenja`, `spol`, `pretplata_na_mail`, `aktiviran`"
            . "FROM `korisnik` JOIN županija ON korisnik.zupanija = županija.idžupanije "
            . "WHERE `idkorisnik` = '$idKorisnika'";
        
    $odgovor2 = $dbc2->selectUpit($sql2);
        
    if (!$odgovor2) {
        echo 'Problem kod upita na bazu podataka!';
        exit();
        //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
    }
    
    list($idKorisnika2, $ime2, $prezime2, $adresa2, $zupanija2, $zupanijaBroj2, $grad2, $mail2, 
            $korIme22, $lozinka2, $telefon2, $datumRodjenja2, $spol2, $pretplataNaMail2, $aktiviran2) = 
            $odgovor2->fetch_array();
    
    
    global $greske;
    if ($ime2 != $ime) {
        $greske = "Ime je promijenjeno: " . $ime2 . " - " . $ime ." </br>";
    }
    if ($prezime2 != $prezime) {
        $greske = $greske . "Prezime je promijenjeno: " . $prezime2 . " - " . $prezime ." </br>";
    }
    if ($adresa2 != $adresa) {
        $greske = $greske . "Adresa je promijenjena: " . $adresa2 . " - " . $adresa ." </br>";
    }
    if ($zupanijaBroj2 != $zupanija) {
        $greske = $greske . "Županija je promijenjena. " ." </br>";
    }
    if ($grad2 != $grad) {
        $greske = $greske . "Grad je promijenjen: " . $grad2 . " - " . $grad ." </br>";
    }
    if ($mail2 != $mail) {
        $greske = $greske . "Email je promijenjen: " . $mail2 . " - " . $mail ." </br>";
    }
    if ($korIme22 != $kor_ime) {
        $greske = $greske . "Kor.ime je promijenjeno: " . $korIme22 . " - " . $kor_ime ." </br>";
    }
    if ($lozinka2 != $lozinka) {
        $greske = $greske . "Lozinka je promijenjena." . " </br>";
    }
    if ($telefon2 != $telefon) {
        $greske = $greske . "Telefon je promijenjen: " . $telefon2 . " - " . $telefon ." </br>";
    }
    if ($datumRodjenja2 != $dat_rod) {
        $greske = $greske . "Dat.rođenja je promijenjen: " . $datumRodjenja2 . " - " . $dat_rod ." </br>";
    }
    if ($spol2 != $spol) {
        $greske = $greske . "Spol je promijenjen: " . $spol2 . " - " . $spol ." </br>";
    }
    if ($pretplataNaMail2 != $pretplata) {
        $greske = $greske . "Pretplata je promijenjena." . " </br>";
    }
    
    $dbc = new baza();
    
    $sql = "UPDATE korisnik SET `ime`='$ime',`prezime`='$prezime',`slika_link`='$slika',"
            . "`adresa`='$adresa',`zupanija`='$zupanija',`grad`='$grad',`email`='$mail',"
            . "`kor_ime`='$kor_ime',`password`='$lozinka',`telefon`='$telefon',"
            . "`datum_rodjenja`='$dat_rod',`spol`='$spol',`pretplata_na_mail`='$pretplata', "
            . "`aktiviran`='$aktiviran' "
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