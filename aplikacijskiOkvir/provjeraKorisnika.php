<?php

include_once('aplikacijskiOkvir/korisnik.class.php');

define('ADMINISTRATOR', 1);
define('MODERATOR', 3);
define('REG_KORISNIK', 5);

function provjeraKorisnika() {
    $korisnik = null;

    session_start();
    if (!isset($_SESSION["WebDiP2014x074"])) {
        header("Location: error.php?e=2");
        exit();
    } else {
        $korisnik = $_SESSION["WebDiP2014x074"];
        if ($korisnik->get_status() != 1) {
            header("Location: error.php?e=2");
            exit();
        } 
        if($korisnik->get_adresa() != $_SERVER["REMOTE_ADDR"]) {
            header("Location: error.php?e=2");
            exit();
        }
    }
    return $korisnik;
}

function provjeraUloge($uloga) {
    session_start();
    $korisnik = isset($_SESSION["WebDiP2014x074"]) ? $_SESSION["WebDiP2014x074"] : "";
    if ($korisnik == "" || $korisnik->get_status() != 1 || $korisnik->get_vrsta() != $uloga) {
        header("Location: error.php?e=2");
        exit();
    }
}
?>