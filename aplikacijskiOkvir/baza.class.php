<?php
/**
 * Description of baza
 *
 * @author jurad
 */
class baza {
    private $server = 'localhost';
    private $korisnik = 'WebDiP2014x074';
    private $lozinka = 'admin_tzNK';
    private $baza = 'WebDiP2014x074';
    private $dbc;
    private $znaci = 'utf8'; 
          
    function __construct() {
        $this->dbc = new mysqli($this->server, $this->korisnik, $this->lozinka, $this->baza);
        if ($this->dbc->connect_errno) {
            echo "Problem kod povezivanja na bazu podataka! "
            . $this->dbc->connect_errno;
            exit();
        }
        $this->dbc->set_charset($this->znaci);
    }
    
    function selectUpit($sql) {
        $odgovor = $this->dbc->query($sql);
        if (!$odgovor) {
            echo 'Problem kod upita na bazu podataka select upit!';
            exit();
        }
        return $odgovor;
    }
    
    function ostaliUpiti($sql) {
        $odgovor = $this->dbc->query($sql);
        if (!$odgovor) {
            echo 'Problem kod upita na bazu podataka ostali upiti!';
            exit();
        }
        return $odgovor;
    }
    
    function zatvoriBazuPodataka() {
        if (isset($this)) {
            $this->dbc->close();
            }
            echo 'Zatvoreno <BR>';
        }
        
    }
    
    
    

