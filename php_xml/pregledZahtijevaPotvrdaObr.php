<?php
include '../aplikacijskiOkvir/baza.class.php';

//dnevnik_zapis("Zaboravljena lozinka");

//$IdZahtijeva = '6';
$IdZahtijeva = $_GET['IdZahtijeva'];

$dbc = new baza();

$sql = "UPDATE `zahtijev_za_legalizacijom` SET `status_idstatus`= 4 WHERE `idzahtijeva` = '$IdZahtijeva'";

$rezultatUpita = $dbc->selectUpit($sql);
   
if (!$rezultatUpita) {
    echo 'Problem kod upita na bazu podataka!';
    exit();
    //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
    }  else {
    $sveOK = 1;
}

$output = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>' . "\n";
$output .= '<obrada>';

$output .= '<obradjen idZahtijeva="' . $IdZahtijeva . '">' . $sveOK . '</obradjen>' . "\n";

$output .= '</obrada>';


header("Content-Type: text/xml");
print $output;