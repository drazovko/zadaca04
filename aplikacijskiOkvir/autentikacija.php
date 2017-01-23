<?php
function autentikacija($user, $pass) {
    $result = -1;
    $dbc = new baza();

    $sql = "select idkorisnik, kor_ime, ime, prezime, email, password, "
            . "uloga_iduloga, aktiviran from korisnik "
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
                $aktiviran) = $rezultatUpita->fetch_array();

        if ($password == $pass) {
            
            if ($aktiviran == 1) {
                $korisnik->setDioPodataka($idKorisnika, $ime, $prezime, $mail, $password, $korIme, 
                    $uloga_iduloga, $aktiviran);
                $result = 1;
            }  else {
                $result = 5;
            } 
        } else {
            $result = 0;
        }
    } else {
        $result = -1;
    }
    $korisnik->set_status($result);

    return $korisnik;
}

