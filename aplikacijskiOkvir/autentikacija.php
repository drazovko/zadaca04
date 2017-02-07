<?php
function autentikacija($user, $pass) {
    $result = -1;
    $dbc = new baza();

    $sql = "select idkorisnik, kor_ime, ime, prezime, email, password, "
            . "uloga_iduloga, aktiviran, zaključan from korisnik "
            . "where kor_ime = '$user'";
    
    $rezultatUpita = $dbc->selectUpit($sql);
   
    if (!$rezultatUpita) {
        echo 'Problem kod upita na bazu podataka!';
        exit();
        //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
    }

    $brojRedova = $rezultatUpita->num_rows;
    
    $korisnik = new Korisnik();

    if ($brojRedova == 1) {
        list($idKorisnika, $korIme, $ime, $prezime, $mail, $password, $uloga_iduloga, 
                $aktiviran, $zakljucan) = $rezultatUpita->fetch_array();
        if ($zakljucan == 1) {
            $result = 6;
        } else {
           if ($password == $pass) {
            
            if ($aktiviran == 1) {
                $korisnik->setDioPodataka($idKorisnika, $ime, $prezime, $mail, $password, $korIme, 
                    $uloga_iduloga, $aktiviran);
                
                $dbc2 = new baza();

                $sql2 = "SELECT `virtualno_vrijeme` from dnevnik WHERE `korisnik` = '$user' "
                        . "AND `tekst` = 'Uspješno logiranje' ORDER BY virtualno_vrijeme desc LIMIT 1";
                
                $rezultatUpita2 = $dbc2->selectUpit($sql2);
                
                list($vrijeme) = $rezultatUpita2->fetch_array();
                
                $korisnik->set_posljednja_uspjesna_prijava($vrijeme);
                
                $result = 1;
            }  else {
                $result = 5;
            } 
        } else {
            $result = 0;
        } 
        }
        
    } else {
        $result = -1;
    }
    $korisnik->set_status($result);

    return $korisnik;
}

function zakljucavanjeKorisnika($user){
    $dbc = new baza();

    $sql = "UPDATE korisnik SET " 
            . "`zaključan`= 1 "
            . "where kor_ime = '$user'";
            
    $rezultatUpita = $dbc->selectUpit($sql);
   
    if (!$rezultatUpita) {
        echo 'Problem kod upita na bazu podataka!';
        exit();
        //trigger_error("Problem kod upita na bazu podataka!", E_USER_ERROR);
    }
}