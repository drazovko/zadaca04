<?php
include '../aplikacijskiOkvir/baza.class.php';


$dbc = new baza();

$sql = "SELECT `idkorisnik`, `ime`, `prezime` FROM `korisnik` "
        . "WHERE `uloga_iduloga` = '3'";
    
$rezultatUpita = $dbc->selectUpit($sql);
   
if (!$rezultatUpita) {
    echo 'Problem kod upita na bazu podataka!';
    exit();
    //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
    }


$output = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>' . "\n";
$output .= '<gradjevinari>';

$brojRedova = $rezultatUpita->num_rows;

if ($brojRedova) {
    //prvi ulazak u petlju
    while ($row = $rezultatUpita->fetch_row()) {
        $idModeratora = $row[0];
        $dbc2 = new baza();

        $sql2 = " SELECT `idzahtijeva`, ocjena FROM `zahtijev_za_legalizacijom` "
                . "WHERE `idkorisnik_moderator` = '$idModeratora'";
    
        $rezultatUpita2 = $dbc2->selectUpit($sql2);
   
        if (!$rezultatUpita2) {
            echo 'Problem kod upita na bazu podataka!';
        exit();
        //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
        }

        $brojRedova2 = $rezultatUpita2->num_rows;
        
        $brojacZahtijeva = 0;
        $brojacOcjena = 1;
        $ocjena = 0.00;
        $prosjecnaOcjenaPoGradjevinaru = 0.00;
        if ($brojRedova2) {
            //ulazak u drugu petlju
            
            while ($row2 = $rezultatUpita2->fetch_row()) {
                $idZahtijeva = $row2[0];
                $ocjena = $row2[1];
                if(is_numeric($ocjena)){
                    $prosjecnaOcjenaPoGradjevinaru += $ocjena;
                    $brojacOcjena++;
                }
                $brojacZahtijeva++;
            }
        }
        //echo $prosjecnaOcjenaPoGradjevinaru . "<br>";
        if (!is_numeric($prosjecnaOcjenaPoGradjevinaru) || $prosjecnaOcjenaPoGradjevinaru == 0) {
            $prosjecnaOcjenaPoGradjevinaru = " - ";
        } else{
            $prosjecnaOcjenaPoGradjevinaru = $prosjecnaOcjenaPoGradjevinaru / ($brojacOcjena - 1);
        }
        $output .= '<name ime="' . $row[1] . '" prezime="' . $row[2] . '" zahtijevaPoGradjevinaru="' . $brojacZahtijeva . '" prosjecnaOcjenaPoGradjevinaru="' . $prosjecnaOcjenaPoGradjevinaru . '">' . $brojacZahtijeva . '</name>' . "\n";
    }
}
$output .= '</gradjevinari>';

header("Content-Type: text/xml");
print $output;




