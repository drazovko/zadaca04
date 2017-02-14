<?php
include '../aplikacijskiOkvir/baza.class.php';

//dnevnik_zapis("Zaboravljena lozinka");


//$idKor = '2';
//$idZahtijeva = '4';

$idZahtijeva = $_GET['idZahtijeva'];

$dbc = new baza();

$sql = "UPDATE `zahtijev_za_legalizacijom` "
        . "SET `status_idstatus`= '3' "
        . "WHERE `idzahtijeva` = '$idZahtijeva'";


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

$output .= '<obradjen idZah="' . $idZahtijeva . '">' . $sveOK . '</obradjen>' . "\n";

$output .= '</obrada>';


header("Content-Type: text/xml");
print $output;
