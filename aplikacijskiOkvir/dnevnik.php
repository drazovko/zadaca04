<?php

function dnevnik_zapis($tekst) {
    $korisnik = isset($_SESSION["WebDiP2014x074"]) ? $_SESSION["WebDiP2014x074"]->get_kor_ime() : "";
    $adresa = $_SERVER["REMOTE_ADDR"];
    $skripta = $_SERVER["REQUEST_URI"];
    $preglednik = $_SERVER["HTTP_USER_AGENT"];
    global $virtualnoVrijemeSustava;
    $vrijeme = date(DATE_ISO8601, $virtualnoVrijemeSustava);
    
    $dbc = new baza();

    $sql = "insert into dnevnik (korisnik, adresa, skripta, tekst, preglednik, virtualno_vrijeme) values " .
            "('$korisnik', '$adresa', '$skripta', '$tekst', '$preglednik', '$vrijeme')";

    $odgovor = $dbc->ostaliUpiti($sql);
    
    if (!$odgovor) {
        echo 'Problem kod upisa u bazu podataka (dnevnik)!';
        //trigger_error("Problem kod upisa u bazu podataka (dnevnik)!" . $dbc->error, E_USER_ERROR);
    }
}
