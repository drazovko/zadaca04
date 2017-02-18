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
        . "AND `stvarno_vrijeme` BETWEEN '" . $odDatuma . "' AND '" . $doDatuma . "'";


$rezultatUpita = $dbc->selectUpit($sql);
   
if (!$rezultatUpita) {
    echo 'Problem kod upita na bazu podataka!';
    exit();
    //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
    }


$brojRedova = $rezultatUpita->num_rows;

$vrijeme = date("d.m.Y H:i:s");


$p = PDF_new();

/*  open new PDF file; insert a file name to create the PDF on disk */
if (PDF_begin_document($p, "", "") == 0) {
    die("Error: " . PDF_get_errmsg($p));
}

PDF_set_info($p, "Creator", "pdfStatiskikaDnevnika.php");
PDF_set_info($p, "Author", "Jura Drugi");
PDF_set_info($p, "Title", "Statiskika dnevnika!");

PDF_begin_page_ext($p, 595, 842, "");

$font = PDF_load_font($p, "Helvetica-Bold", "winansi", "");
PDF_setfont($p, $font, 20.0);
PDF_set_text_pos($p, 80, 750);
PDF_show($p, "Statistika dnevnika - " . $vrijeme);


if ($prijave == "Uspje%") {
        $prijave = "uspjesnih";
    }  else {
        $prijave = "neuspjesnih";
    }
$textPdf = "Pregled " . $prijave . " prijava na sustav po odabranom korisniku i vremenskom periodu.";
PDF_setfont($p, $font, 12.0);
PDF_set_text_pos($p, 50, 600);
PDF_show($p, $textPdf);


$pozicija = 520;
$broj = 1;
$velicina = 20;
$razmak = 0;
PDF_setfont($p, $font, 14.0);
PDF_set_text_pos($p, 60, $pozicija);




while (list($korisnik, $ukupno) = $rezultatUpita->fetch_row()) {
    if ($korisnik == "") {
        $korisnik = "Nepoznati korisnici";
    }
  $razmak = (($broj++) * $velicina) + 10;
  PDF_show($p, $korisnik . "  -  " . $ukupno . "  -  " . $odDatuma . "  -  " . $doDatuma);
  PDF_set_text_pos($p, 50, $pozicija - $razmak);
}

PDF_end_page_ext($p, "");
PDF_end_document($p, "");

$buf = PDF_get_buffer($p);
$len = strlen($buf);

header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=pdf_1.pdf");
print $buf;

PDF_delete($p);