<?php

class Korisnik {

    private $idKorisnika;
    private $ime;
    private $prezime;
    private $slika_link;
    private $adresa;
    private $zupanija;
    private $grad;
    private $email;
    private $kor_ime;
    private $password;
    private $telefon;
    private $datum_rodjenja;
    private $spol;
    private $pretplata_na_mail;
    private $uloga_iduloga = 9;
    private $aktiviran;
    private $datum_upisa;
    private $zaključan;
    private $aktivacijski_kod;
    private $prijavljen_od;
    private $status = 0;

    public function Korisnik() {
        
    }

    public function setDioPodataka($p_idKorisnika, $p_ime, $p_prezime, $mail, $p_lozinka, 
            $p_kor_ime, $p_uloga_iduloga, $p_aktiviran) {
        $this->idKorisnika = $p_idKorisnika;
        $this->ime = $p_ime;
        $this->prezime = $p_prezime;
        $this->email = $mail;
        $this->password = $p_lozinka;
        $this->kor_ime = $p_kor_ime;
        $this->uloga_iduloga = $p_uloga_iduloga;
        $this->aktiviran = $p_aktiviran;
        $this->prijavljen_od = time();
        $this->status = 0;
        $this->adresa = $_SERVER["REMOTE_ADDR"];
    }

    public function set_status($p_status) {
        $this->status = $p_status;
    }

    public function get_status() {
        return $this->status;
    }

    public function get_kor_ime() {
        return $this->kor_ime;
    }

    public function get_ime_prezime() {
        return $this->ime . " " . $this->prezime;
    }

    public function get_prezime() {
        return $this->prezime;
    }

    public function get_ime() {
        return $this->ime;
    }

    public function get_vrsta() {
        return $this->uloga_iduloga;
    }
    
    public function get_aktiviran() {
        return $this->aktiviran;
    }

    public function get_prijavljen_od() {
        return date("d.m.Y H:i:s", $this->prijavljen_od);
    }

    public function get_aktivan() {
        return time() - $this->prijavljen_od;
    }

    public function get_adresa() {
        return $this->adresa;
    }    
}

?>
