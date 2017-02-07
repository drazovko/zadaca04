<?php
include 'aplikacijskiOkvir/aplikacijskiOkvir.php';

dnevnik_zapis("Aktivacija preko linka");

$korIme = $_GET['korIme'];
$aktivacijskiKod = $_GET['aktivacijskiKod'];

$dbc = new baza();
    
$sql = "SELECT  `ime` ,  `prezime`, `datum_upisa`, `aktiviran` FROM korisnik "
        . "WHERE kor_ime =  '$korIme' AND "
        . "aktivacijski_kod =  '$aktivacijskiKod'";
    
$odgovor = $dbc->selectUpit($sql);
$brojRedova = $odgovor->num_rows;
    
    if ($brojRedova === 0) {
        echo "<h2 align='center'>Ne postoji korisnik za kojeg vrijedi taj aktivacijski link!!!</h2><br>";
        exit();
    }
    if ($brojRedova > 1) {
        echo "<h2 align='center'>Korisnik više puta upisan u bazu!!!</h2></br>";
        exit();
    }
    if ($brojRedova === 1) {      
        list($ime, $prezime, $datumUpisa, $aktiviran) = $odgovor->fetch_row();
        echo 'Trenutno virtualno vrijeme sustava: ' . date('d.m.Y H:i:s', $virtualnoVrijemeSustava) . "<br>";
        $datumUpisa = strtotime($datumUpisa);
        echo "Vrijeme upisa korisnika u sustav:   " . date('d.m.Y H:i:s', $datumUpisa) . "<br>";
        if ($aktiviran) {
            echo "<h2 align='center'>Korisnik $ime, $prezime, $korIme je već bio aktiviran!!!</h2></br>";
            exit();
        }  else {
            $vrijemeZaAktivaciju = $datumUpisa + (12*60*60);
            echo "Krajnje vrijeme za aktivaciju: " . date('d.m.Y H:i:s', $vrijemeZaAktivaciju) . "<br>";
            if ($vrijemeZaAktivaciju < $virtualnoVrijemeSustava) {
                echo "<h2 align='center'>Vrijeme za aktivaciju od 12 sati od trenutka registracije je isteklo!!!</h2>";
                exit();
            }  else {
                $sql = "UPDATE `korisnik` SET `aktiviran` = '1' WHERE kor_ime =  '$korIme' AND "
                . "aktivacijski_kod =  '$aktivacijskiKod'";
                
                $dbc = new baza();
                $odgovor = $dbc->ostaliUpiti($sql);
                //$brojRedova = $odgovor->num_rows;
                if ($odgovor == 1) {
                    echo "<h2 align='center'>Korisničko ime je $ime, a prezime $prezime!</h2><br>";
                    echo "<h2 align='center'>Korisnik $korIme aktiviran!</h2>";
                    echo "<a href='detalji_korisnika.php'>Detalji korisnika</a>";
                    exit();
                }  else {
                    echo "<h2 align='center'>Korisničko ime je $ime, a prezime $prezime!</h2><br>";
                    echo "<h2 align='center'>Problem sa aktivacijom!</h2>";
                    echo "<h2 align='center'>Korisnik $korIme NIJE aktiviran!</h2>";
                    exit();
                }
            }
        
        }
    }
