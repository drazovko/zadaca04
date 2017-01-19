<?php
include 'aplikacijskiOkvir/baza.class.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Detalji korisnika</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <meta name="application-name" content="detalji korisnika">
        <meta name="author" content="Dragan Zovko">
        <meta name="description" content="datum_kreiranja: 12.01.2017.">  
        <link rel="stylesheet" type="text/css" href="css/drazovko.css"/>
        <link rel="stylesheet" type="text/css" media="screen and (max-width: 450px)" href="css/drazovko_mobitel.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:451px) and (max-width: 800px)" href="css/drazovko_tablet.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:801px) and (max-width: 1000px)" href="css/drazovko_pc.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:1001px)" href="css/drazovko_tv.css" />
        
    </head>
    <body>
        <header id="zaglvalje">
            <img src="img/logo.png" alt="foi logo" id="logo" />
            <p id="header_naslov">Zadaća 04</p>
        </header>
        <nav id="meni">
            <ul>
                <li><a href="index.html">Početna stranica</a></li>
                <li><a href="osobna.html">O meni</a></li>
                <li><a href="registracija.html">Registracija</a></li>
                <li><a href="prijava.html">Prijava</a></li>
                <li><a href="korisnici.html">Korisnici</a></li>
                <li><a href="http://www.foi.unizg.hr" target="_blank">Foi web</a></li>
    
            </ul>
        </nav>
        
        <section id="sadržaj"> 
            
            
        <?php
        $korIme = $_GET['korIme'];
        
        $dbc = new baza();
        
        $sql = "SELECT `ime`, `prezime`, `adresa`, županija.naziv, `grad`, `email`, "
                . "`kor_ime`, `telefon`, `datum_rodjenja`, `spol`, `pretplata_na_mail` "
                . "FROM `korisnik` JOIN županija ON korisnik.zupanija = županija.idžupanije WHERE `kor_ime` = '$korIme'";
        
        $odgovor = $dbc->selectUpit($sql);
        
        list($ime, $prezime, $adresa, $zupanija, $grad, $email, $korIme2, $telefon, $datumRodjenja, $spol, $pretplataNaMail) = 
                $odgovor->fetch_array();
        
        $slika = "";
         ?>
        <form action="http://arka.foi.hr/WebDiP/2014/materijali/zadace/ispis_forme.php" 
                  method="post" name="registracija" id="obrazac" enctype="multipart/form-data" >
                
                <label for="ime">Ime: </label>
                <input type="text" name="ime" id="ime" size="20" maxlength="30" 
                       value="<?php echo $ime?>" disabled=""/><br />
                <label for="prezime">Prezime: </label>
                <input type="text" name="prezime" id="prezime" size="20" maxlength="50" 
                       value="<?php echo $prezime?>" disabled=""/><br />
                <label for="slikaJa">Slika: </label>
                <img name="slikaJa" src="img/drazovko.jpg" alt="slika" width="50" height="50"><br />
                <label for="adresa" >Adresa: </label>
                <input name="adresa" id="adresa" rows="2" cols="30" value="<?php echo $adresa?>" disabled="" ><br />
                <label for="županije">Županija: </label>
                <input type="text" name="županije" id="županije" size="20" maxlength="50" 
                       value="<?php echo $zupanija?>" disabled=""/><br />
                
                <label for="grad">Grad: </label>  
                <input type="text" name="grad" id="grad" value="<?php echo $grad?>" disabled=""/><br />
                
                <label for="mail">Email: </label>
                <input type="email" name="mail" id="mail" value="<?php echo $email?>" disabled="" /><br />
                <label for="kor_ime">Korisničko ime: </label>
                <input type="text" name="kor_ime" id="kor_ime" title="pet ili više znakova"
                       value="<?php echo $korIme?>" disabled="" /><br />
                
                <label for="lozinka">Lozinka: </label>
                <input type="password" name="lozinka" id="lozinka" title="šest ili više znakova"
                       value="**********" disabled=""  /><br />
                <label for="telefon">Telefon: </label>
                <input type="tel" name="telefon" id="telefon" value="<?php echo $telefon?>" disabled=""
                       title="Format: xxx xxxxxxx" /><br />
                <label for="dat_rodj">Datum rođenja: </label>
                <input type="date" name="dat_rodj" id="dat_rodj" value="<?php echo $datumRodjenja?>" disabled=""/><br />
                
                <label for="spol">Spol: </label>
                <input type="text" name="spol" id="spol"  value="<?php echo $spol?>" disabled="">
                    
                <label for="pretplata">Pretplata na mail: </label>
                <input type="text" name="pretplata" id="pretplata" value="<?php 
                    if($pretplataNaMail == 1){
                        echo "Da";
                    }  else {
                        echo "Ne";
                    }
                    ?>" disabled=""/><br />    

            </form>
            </section>
        
        <footer id="footer">
            <address>
                Kontakt:
                <a href="mailto:drazovko@foi.hr">Dragan Zovko</a>
                <p>Vrijeme potrebno za riješavanje aktivnog dokumenta ~ jedan sat</p>
                <p>Vrijeme potrebno za riješavanje cijelokupnog riješenja ~ jedan dan</p>
                <a href="http://validator.w3.org/check?uri=referer">
                    <img src="http://4.bp.blogspot.com/-Cf1ZOzD0qJ4/VJ-gbgf4EMI/AAAAAAAAAUo/vZrtEJa_sBQ/s1600/W3C_HTML5_certified.png" alt="HTML validator" width="102" height="30"></a>
                <a href="http://jigsaw.w3.org/css-validator/check/referer">
                    <img src="http://3.bp.blogspot.com/-aZnVc1Yv54E/UVWLLkTNtmI/AAAAAAAAAEk/xwN9Vkkhofc/s1600/512px-Valid-css-v_(W3C_Markup_Validation_Service).svg.png" alt="css validator" width="102" height="30"></a>
            
            </address>
        </footer>
        <script src="js/drazovko.js"></script>
    </body>
</html>
