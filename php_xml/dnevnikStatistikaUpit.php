<?php
include '../aplikacijskiOkvir/baza.class.php';
/*
$korIme = "%";
$pd = date_create_from_format("d.m.Y", '01.01.2015');
$odDatuma = date_format($pd, "Y.m.d 00:00:00");
$doDatuma = date("Y.m.d 23:55:55");
$prijave = "Uspje%";
*/
if (!isset($_GET["korisnik"]) || $_GET["korisnik"] == "") {
    $korIme = "%";
} else {
    $korIme = $_GET["korisnik"] . "%";
   }
   
if (!isset($_GET["odDatuma"])) {
    $pd = date_create_from_format("d.m.Y", '01.01.2015');
    $odDatuma = date_format($pd, "Y.m.d 00:00:00");
} else {
    $pd = date_create_from_format("Y-m-d", $_GET["odDatuma"]);
    $odDatuma = date_format($pd, "Y.m.d 00:00:00");
    
}   

if (!isset($_GET["doDatuma"]) || empty($_GET["doDatuma"])) {
    $doDatuma = date("Y.m.d 23:55:55");
} else {
    $pd = date_create_from_format("Y-m-d", $_GET["doDatuma"]);
    $doDatuma = date_format($pd, "Y.m.d 00:00:00");
}

if (!isset($_GET["prijave"]) || $_GET["prijave"] == "") {
    $prijave = "%";
} else {
    $prijave = $_GET['prijave'];
    if ($prijave) {
        $prijave = "Uspje%";
    }  else {
        $prijave = "Poku%";
    }
}

$dbc = new baza();

$sql = "SELECT `korisnik`, COUNT(`tekst`) FROM `dnevnik` "
        . "WHERE `korisnik` LIKE '" . $korIme . "' "
        . "AND `tekst` LIKE '" . $prijave . "' "
        . "AND `stvarno_vrijeme` BETWEEN '" . $odDatuma . "' AND '" . $doDatuma . "' group by korisnik";


$rezultatUpita = $dbc->selectUpit($sql);
   
if (!$rezultatUpita) {
    echo 'Problem kod upita na bazu podataka!';
    exit();
    //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
    }


$output = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>' . "\n";
$output .= '<zahtijevi>';

$brojRedova = $rezultatUpita->num_rows;

if ($brojRedova) {
    while ($row = $rezultatUpita->fetch_row()) {
        $output .= '<name korisnik="' . $row[0] . '" broj="' . $row[1] 
                 . '">' . $row[1] . '</name>' . "\n";
    }
}
$output .= '</zahtijevi>';

header("Content-Type: text/xml");
print $output;

//. '" preglednik="' . $row[5] 
  //. '" skripta="' . $row[3]       
