<?php
include '../aplikacijskiOkvir/baza.class.php';

$dbc = new baza();

$sql = "SELECT `id_dnevnik`, `korisnik`, `adresa`, `skripta`, `tekst`, `preglednik`, "
        . "`virtualno_vrijeme`, `stvarno_vrijeme` FROM `dnevnik`";


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
        $output .= '<name iddnevnik="' . $row[0] . '" korisnik="' . $row[1] 
                . '" adresa="' . $row[2] 
                . '" tekst="' . $row[4] 
                . '" virVrijeme="' . $row[6] . '" stvVrijeme="' . $row[7] . '">' . $row[0] . '</name>' . "\n";
    }
}
$output .= '</zahtijevi>';

header("Content-Type: text/xml");
print $output;

//. '" preglednik="' . $row[5] 
  //. '" skripta="' . $row[3]       