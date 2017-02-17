<?php
include '../aplikacijskiOkvir/baza.class.php';

$idZupanije = $_GET['idZupanije'];
//$idZupanije = '6';

$dbc = new baza();

$sql = "SELECT korisnik.idkorisnik, `korisnik`.`ime`, `korisnik`.`prezime`, `moderator_has_županija`.`županija_idžupanije` "
        . "FROM `korisnik` JOIN `moderator_has_županija` "
        . "ON `moderator_has_županija`.`korisnik_idkorisnik` = `korisnik`.`idkorisnik` "
        . "AND moderator_has_županija.županija_idžupanije = $idZupanije";
    
$rezultatUpita = $dbc->selectUpit($sql);
   
if (!$rezultatUpita) {
    echo 'Problem kod upita na bazu podataka!';
    exit();
    //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
    }


$output = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>' . "\n";
$output .= '<zupanije>';

$brojRedova = $rezultatUpita->num_rows;
$ukupnoZahtijeva = 0;
$ukupnoVideaPoZupaniji = 0;
if ($brojRedova) {
    //prvi ulazak u petlju
    while ($row = $rezultatUpita->fetch_row()) {
        $idModeratora = $row[0];
        $dbc2 = new baza();

        $sql2 = " SELECT `idzahtijeva`, ocjena FROM `zahtijev_za_legalizacijom` "
                . "WHERE `idkorisnik_moderator` = '$idModeratora' AND `županija_idžupanije` = $idZupanije";
    
        $rezultatUpita2 = $dbc2->selectUpit($sql2);
   
        if (!$rezultatUpita2) {
            echo 'Problem kod upita na bazu podataka!';
        exit();
        //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
        }

        $brojRedova2 = $rezultatUpita2->num_rows;
        $brojacZahtijeva = 0;
        $ukupnoSlikaPoGradjevinaru = 0;
        $ukupnoVideaPoGradjevinaru = 0;
        $ukupnoDokumenataPoGradjevinaru = 0;
        $brojacOcjena = 1;
        $ocjena = 0.00;
        $prosjecnaOcjenaPoGradjevinaru = 0.00;
        if ($brojRedova2) {
            //ulazak u drugu petlju
            
            while ($row2 = $rezultatUpita2->fetch_row()) {
                $idZahtijeva = $row2[0];
    //brojač slika po građevinaru po izabranoj županiji        
                $dbc3 = new baza();

                $sql3 = "SELECT `naziv` FROM `galerija_slika` "
                        . "WHERE `zahtijev_za_leg_idzahtijeva` = '$idZahtijeva'";
    
                $rezultatUpita3 = $dbc3->selectUpit($sql3);
   
                if (!$rezultatUpita3) {
                    echo 'Problem kod upita na bazu podataka!';
                    exit();
                //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
                }

                $brojRedova3 = $rezultatUpita3->num_rows;
                $brojacSlika = 0;
                $brojacVidea = 0;
                $brojacDokumenata = 0;
                if ($brojRedova3) {
                //ulazak u treću petlju
                    while ($row3 = $rezultatUpita3->fetch_row()) {
                        //$idZahtijeva = $row2[0];
                        $brojacSlika++;
                        //$output .= '<name ime="' . $row[1] . '" prezime="' . $row[2] . '" brZahtijeva="' . $brojacZahtijeva . '" brSlika="' . $brojacSlika . '" slikaPoGradjevinaru="' . $ukupnoSlikaPoGradjevinaru . '" brVidea="' . $brojacVidea . '" videaPoGradjevinaru="' . $ukupnoVideaPoGradjevinaru . '" brDokumenata="' . $brojacDokumenata . '" dokumenataPoGradjevinaru="' . $ukupnoDokumenataPoGradjevinaru . '">' . $row2[0] . '</name>' . "\n";
                    }
                    $ukupnoSlikaPoGradjevinaru += $brojacSlika;
                }
                
                //$output .= '<name ime="' . $row[1] . '" prezime="' . $row[2] . '" brZahtijeva="' . $brojacZahtijeva . '" brSlika="' . $brojacSlika . '" slikaPoGradjevinaru="' . $ukupnoSlikaPoGradjevinaru . '" brVidea="' . $brojacVidea . '" videaPoGradjevinaru="' . $ukupnoVideaPoGradjevinaru . '" brDokumenata="' . $brojacDokumenata . '" dokumenataPoGradjevinaru="' . $ukupnoDokumenataPoGradjevinaru . '">' . $row2[0] . '</name>' . "\n";
                
    //brojač videa po građevinaru po izabranoj županiji
                $dbc4 = new baza();

                $sql4 = "SELECT `naziv` FROM `video` "
                        . "WHERE `zahtijev_za_leg_idzahtijeva` = '$idZahtijeva'";
    
                $rezultatUpita4 = $dbc4->selectUpit($sql4);
   
                if (!$rezultatUpita4) {
                    echo 'Problem kod upita na bazu podataka!';
                    exit();
                //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
                }

                $brojRedova4 = $rezultatUpita4->num_rows;
                
                if ($brojRedova4) {
                //ulazak u treću petlju
                    while ($row4 = $rezultatUpita4->fetch_row()) {
                        //$idZahtijeva = $row2[0];
                        $brojacVidea++;
                        //$output .= '<name ime="' . $row[1] . '" prezime="' . $row[2] . '" brZahtijeva="' . $brojacZahtijeva . '" brSlika="' . $brojacSlika . '" slikaPoGradjevinaru="' . $ukupnoSlikaPoGradjevinaru . '" brVidea="' . $brojacVidea . '" videaPoGradjevinaru="' . $ukupnoVideaPoGradjevinaru . '" brDokumenata="' . $brojacDokumenata . '" dokumenataPoGradjevinaru="' . $ukupnoDokumenataPoGradjevinaru . '">' . $row2[0] . '</name>' . "\n";
                    }
                    $ukupnoVideaPoGradjevinaru += $brojacVidea;
                }
                
                //$output .= '<name ime="' . $row[1] . '" prezime="' . $row[2] . '" brZahtijeva="' . $brojacZahtijeva . '" brSlika="' . $brojacSlika . '" slikaPoGradjevinaru="' . $ukupnoSlikaPoGradjevinaru . '" brVidea="' . $brojacVidea . '" videaPoGradjevinaru="' . $ukupnoVideaPoGradjevinaru . '" brDokumenata="' . $brojacDokumenata . '" dokumenataPoGradjevinaru="' . $ukupnoDokumenataPoGradjevinaru . '">' . $row2[0] . '</name>' . "\n";
    //brojač dokumenata po gradjevinaru po županiji        
                $dbc5 = new baza();

                $sql5 = "SELECT `naslov` FROM `dokument` "
                        . "WHERE `zahtijev_idzahtijeva` = '$idZahtijeva'";
    
                $rezultatUpita5 = $dbc5->selectUpit($sql5);
   
                if (!$rezultatUpita5) {
                    echo 'Problem kod upita na bazu podataka!';
                    exit();
                //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
                }

                $brojRedova5 = $rezultatUpita5->num_rows;
                
                if ($brojRedova5) {
                //ulazak u treću petlju
                    while ($row5 = $rezultatUpita5->fetch_row()) {
                        //$idZahtijeva = $row2[0];
                        $brojacDokumenata++;
                        //$output .= '<name ime="' . $row[1] . '" prezime="' . $row[2] . '" brZahtijeva="' . $brojacZahtijeva . '" brSlika="' . $brojacSlika . '" slikaPoGradjevinaru="' . $ukupnoSlikaPoGradjevinaru . '" brVidea="' . $brojacVidea . '" videaPoGradjevinaru="' . $ukupnoVideaPoGradjevinaru . '" brDokumenata="' . $brojacDokumenata . '" dokumenataPoGradjevinaru="' . $ukupnoDokumenataPoGradjevinaru . '">' . $row2[0] . '</name>' . "\n";
                    }
                    $ukupnoDokumenataPoGradjevinaru += $brojacDokumenata;
                }
    //računanje prosječne ocjene za moderatora odabrane županije            
                $ocjena = $row2[1];
                if(is_numeric($ocjena)){
                    $prosjecnaOcjenaPoGradjevinaru += $ocjena;
                    $brojacOcjena++;
                }
                $brojacZahtijeva++;
                //$output .= '<name ime="' . $row[1] . '" prezime="' . $row[2] . '" brZahtijeva="' . $brojacZahtijeva . '" brSlika="' . $brojacSlika . '" slikaPoGradjevinaru="' . $ukupnoSlikaPoGradjevinaru . '" brVidea="' . $brojacVidea . '" videaPoGradjevinaru="' . $ukupnoVideaPoGradjevinaru . '" brDokumenata="' . $brojacDokumenata . '" dokumenataPoGradjevinaru="' . $ukupnoDokumenataPoGradjevinaru . '">' . $row2[0] . '</name>' . "\n";
            }
        }
    //računanje prosječne ocjene za moderatora odabrane županije 2. dio
        
        if (!is_numeric($prosjecnaOcjenaPoGradjevinaru) || $prosjecnaOcjenaPoGradjevinaru == 0) {
            $prosjecnaOcjenaPoGradjevinaru = " - ";
        } else{
            $prosjecnaOcjenaPoGradjevinaru = $prosjecnaOcjenaPoGradjevinaru / ($brojacOcjena - 1);
        }
        $ukupnoVideaPoZupaniji += $ukupnoVideaPoGradjevinaru; 
        $ukupnoZahtijeva += $brojacZahtijeva;
        $output .= '<name ime="' . $row[1] . '" prezime="' . $row[2] . '" zahtijevaPoGradjevinaru="' . $brojacZahtijeva . '" ukupnoZahtijeva="' . $ukupnoZahtijeva . '" videaPoGradjevinaru="' . $ukupnoVideaPoGradjevinaru . '" videaPoZupaniji="' . $ukupnoVideaPoZupaniji . '" ocjenaPoGradjevinaru="' . $prosjecnaOcjenaPoGradjevinaru . '">' . $brojacZahtijeva . '</name>' . "\n";
    }
}
$output .= '</zupanije>';

header("Content-Type: text/xml");
print $output;