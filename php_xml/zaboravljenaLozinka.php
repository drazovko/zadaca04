<?php
//include_once('../aplikacijskiOkvir/aplikacijskiOkvir.php');
include '../aplikacijskiOkvir/baza.class.php';
//dnevnik_zapis("Zaboravljena lozinka");

$korIme = $_GET['korisnik'];
//$korIme = "jurajjji";

$dbc = new baza();

$sql = "SELECT kor_ime, email FROM `korisnik` WHERE kor_ime = '$korIme'";
    
$rezultatUpita = $dbc->selectUpit($sql);
   
if (!$rezultatUpita) {
    echo 'Problem kod upita na bazu podataka!';
    exit();
    //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
    }

$row = $rezultatUpita->fetch_row();
$mail = "";
$mail = $row[1];
if ($mail != "") {
    $pass = openssl_random_pseudo_bytes(3);
    $pass = bin2hex($pass);


    $dbc3 = new baza();

    $sql = "UPDATE korisnik SET " 
            . "`password`= '$pass' "
            . "where kor_ime = '$korIme'";
            
    
    $rezultatUpita3 = $dbc3->selectUpit($sql);
   
    if (!$rezultatUpita3) {
        echo 'Problem kod upita na bazu podataka!';
        exit();
        //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
    }

    //$mailPoslan = 1;
    $mailPoslan = slanjeMaila($korIme, $mail, $pass);
} else {
    $mailPoslan = 0;
}

$output = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>' . "\n";
$output .= '<kor_ime>';


$output .= '<korisnik korIme="' . $korIme . '">' . $mailPoslan . '</korisnik>' . "\n";


$output .= '</kor_ime>';

header("Content-Type: text/xml");
print $output;

function slanjeMaila($korIme, $mail, $pass){
    $mail_from = "From: WebDiP_2014@foi.hr";
    $mail_subject = "Nova lozinka za korisnika " . $korIme;
    $mail_body = "Nova lozinka je: " . $pass . "    http://arka.foi.hr/WebDiP/2014_projekti/WebDiP2014x074/prijava.php";

    if (mail($mail, $mail_subject, $mail_body, $mail_from)) {
        $rezultat = 1;
    } else {
        $rezultat = 0;
    }
    return $rezultat;
}