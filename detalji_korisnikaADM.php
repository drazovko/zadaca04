<?php
include 'aplikacijskiOkvir/aplikacijskiOkvir.php';
include 'aplikacijskiOkvir/vrijeme_sustava.php';
include 'aplikacijskiOkvir/provjereKodUnosaKor.php';

$korisnik = provjeraKorisnika();                          
//dnevnik_zapis("Uspješna autorizacija");

$greske = "";
$greska = FALSE;
$slika = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ime = $_POST["ime"];
    $prezime = $_POST["prezime"];
    $adresa = $_POST["adresa"];
    $zupanijaBroj = $_POST["zupanija"];
    $grad = $_POST["grad"];
    $lozinka = $_POST["lozinka"];
    $mail = $_POST["mail"];
    $korIme = $_POST["kor_ime"];
    $telefon = $_POST["telefon"];
    if (!isset($_POST["spol"])) {
        $spol = "";
    }  else {
        $spol = $_POST["spol"];
    }
    $datumRodjenja = $_POST["dat_rodj"];
    $pretplataNaMail = $_POST["pretplata"];
    
    $bojaPoljaIme = "";
    $bojaPoljaPrezime = "";
    $bojaPoljaGrad = "";
    $bojaPoljaLozinka =  "";
    $bojaPoljaKorIme = "";
    $bojaPoljaMail = "";
    
    
    
    if ($ime === "" || ($ime != ucfirst($ime))) {
        $greske = "Ime, ";
        $bojaPoljaIme = "background: red";
        $greska = TRUE;
    } else {
        $bojaPoljaIme = "background: #00ffff";
    }
    if ($prezime === "" || ($prezime[0] != strtoupper($prezime[0]))) {
        $greske = $greske . "prezime ";
        $bojaPoljaPrezime = "background: red";
        $greska = TRUE;
    }  else {
        $bojaPoljaPrezime = "background: #00ffff";
    }
    if ($grad === "" || ($grad[0] != strtoupper($grad[0]))) {
        $greske = $greske . "i grad ";
        $bojaPoljaGrad = "background: red";
        $greska = TRUE;
    }  else {
        $bojaPoljaGrad = "background: #00ffff";
    }
    if ($greska === TRUE) {
        $greske = $greske . " mora početi velikim slovom! <br>\n";
    }
    if (provjeraLozinke($lozinka)) {
        $bojaPoljaLozinka = "background: #00ffff";
    }  else {
        $greske = $greske . "Lozinka mora sadržavati velika i mala slova i brojke <br>";
        $bojaPoljaLozinka = "background: red";
    }
    if ($korIme === "") {
        $greske = $greske . "Korisničko ime mora biti unešeno! <br>";
        $bojaPoljaKorIme = "background: red";
    }  else {
        if (provjeraZauzetostiKorImenaMaila($korIme)) {
        $bojaPoljaKorIme = "background: #00ffff";
        }  else {
            $greske = $greske . "Korisničko ime je zauzeto! <br>";
            $bojaPoljaKorIme = "background: red";
        }
    }
    if ($mail === "") {
        $greske = $greske . "Mail mora biti unesen! <br>";
        $bojaPoljaMail = "background: red";
    }  else {
        if (provjeraZauzetostiKorImenaMaila($mail, 2)) {
        $bojaPoljaMail = "background: #00ffff";
        }  else {
            $greske = $greske . "Mail je zauzet! <br>";
            $bojaPoljaMail = "background: red";
        }
    }
    if ($spol === "") {
        $greske = $greske . "Spol mora biti unesen! <br>";
    }
    if ($_POST["adresa"]==="") {
        $greske = $greske . "Adresa mora biti unesena! <br>";
    }
    if ($_POST["telefon"]==="") {
        $greske = $greske . "Telefon mora biti unesen! <br>";
    }
    if ($_POST["dat_rodj"]==="") {
        $greske = $greske . "Datum rođenja mora biti unesen! <br>";
    }
    
    
    
}  else {
    $greske = "Svi podaci moraju biti uneseni (osim slike)!";

    if ($korisnik->get_vrsta() == ADMINISTRATOR && isset($_GET['korIme'])) {
        $korIme = $_GET['korIme'];
    }  else {
        $korIme = $korisnik->get_kor_ime();
    }       
    $dbc = new baza();
        
    $sql = "SELECT `ime`, `prezime`, `adresa`, županija.naziv, `zupanija`, `grad`, `email`, "
            . "`kor_ime`, `password`, `telefon`, `datum_rodjenja`, `spol`, `pretplata_na_mail` "
            . "FROM `korisnik` JOIN županija ON korisnik.zupanija = županija.idžupanije "
            . "WHERE `kor_ime` = '$korIme'";
        
    $odgovor = $dbc->selectUpit($sql);
        
    list($ime, $prezime, $adresa, $zupanija, $zupanijaBroj, $grad, $mail, $korIme2, 
            $lozinka, $telefon, $datumRodjenja, $spol, $pretplataNaMail) = 
            $odgovor->fetch_array();
}







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
            <p id="header_naslov">Zadaća 04 - administrator</p>
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
        
         ?>
            <form action="" method="post" name="registracija" id="obrazac" enctype="multipart/form-data" >
                <div id="greske"><?php echo $greske ?></div><br>
                <label for="ime">Ime: </label>
                <input type="text" name="ime" id="ime" size="20" maxlength="30" 
                       value="<?php echo $ime . '" style="' . $bojaPoljaIme ?>" /><br />
                <label for="prezime">Prezime: </label>
                <input type="text" name="prezime" id="prezime" size="20" maxlength="50" 
                       value="<?php echo $prezime . '" style="' . $bojaPoljaPrezime ?>" /><br />
                <label for="slikaJa">Slika: </label>
                <img name="slikaJa" src="img/drazovko.jpg" alt="slika" width="50" height="50"><br />
                <label for="adresa" >Adresa: </label>
                <input name="adresa" id="adresa" rows="2" cols="30" value="<?php echo $adresa?>"  ><br />
                <label for="županije">Županija: </label>
                <?php
                $zupanija1 = "";
                $zupanija2 = "";
                $zupanija3 = "";
                $zupanija4 = "";
                $zupanija5 = "";
                $zupanija6 = "";
                $zupanija7 = "";
                $zupanija8 = "";
                $zupanija9 = "";
                $zupanija10 = "";
                $zupanija11 = "";
                $zupanija12 = "";
                $zupanija13 = "";
                $zupanija14 = "";
                $zupanija15 = "";
                $zupanija16 = "";
                $zupanija17 = "";
                $zupanija18 = "";
                $zupanija19 = "";
                $zupanija20 = "";
                $zupanija21 = "";
                
                switch ($zupanijaBroj) {
                    case "1":
                        $zupanija1 = 'selected="selected"';
                        break;
                    case "2":
                        $zupanija2 = 'selected="selected"';
                        break;
                    case "3":
                        $zupanija3 = 'selected="selected"';
                        break;
                    case "4":
                        $zupanija4 = 'selected="selected"';
                        break;
                    case "5":
                        $zupanija5 = 'selected="selected"';
                        break;
                    case "6":
                        $zupanija6 = 'selected="selected"';
                        break;
                    case "7":
                        $zupanija7 = 'selected="selected"';
                        break;
                    case "8":
                        $zupanija8 = 'selected="selected"';
                        break;
                    case "9":
                        $zupanija9 = 'selected="selected"';
                        break;
                    case "10":
                        $zupanija10 = 'selected="selected"';
                        break;
                    case "11":
                        $zupanija11 = 'selected="selected"';
                        break;
                    case "12":
                        $zupanija12 = 'selected="selected"';
                        break;
                    case "13":
                        $zupanija13 = 'selected="selected"';
                        break;
                    case "14":
                        $zupanija14 = 'selected="selected"';
                        break;
                    case "15":
                        $zupanija15 = 'selected="selected"';
                        break;
                    case "16":
                        $zupanija16 = 'selected="selected"';
                        break;
                    case "17":
                        $zupanija17 = 'selected="selected"';
                        break;
                    case "18":
                        $zupanija18 = 'selected="selected"';
                        break;
                    case "19":
                        $zupanija19 = 'selected="selected"';
                        break;
                    case "21":
                        $zupanija21 = 'selected="selected"';
                        break;
                    case "20":
                        $zupanija20 = 'selected="selected"';
                        break;
                }
                ?>
                <select name="zupanija" id="županije" >
                    <option value="-1" >-- Odaberi županiju --</option>
                    <optgroup label="Sjeverna Hrvatska">
                        <option value="1" <?php echo $zupanija1;?>>BJELOVARSKO-BILOGORSKA</option>
                        <option value="2" <?php echo $zupanija2;?>>KOPRIVNIČKO-KRIŽEVAČKA</option>
                        <option value="3" <?php echo $zupanija3;?>>KRAPINSKO-ZAGORSKA</option>
                        <option value="4" <?php echo $zupanija4;?>>MEĐIMURSKA</option>
                        <option value="5" <?php echo $zupanija5;?>>VARAŽDINSKA</option>
                    </optgroup>
                    <optgroup label="Središnja Hrvatska">
                        <option value="6" <?php echo $zupanija6;?>>GRAD ZAGREB</option>
                        <option value="7" <?php echo $zupanija7;?>>KARLOVAČKA</option>
                        <option value="8" <?php echo $zupanija8;?>>SISAČKO-MOSLAVAČKA</option>
                        <option value="9" <?php echo $zupanija9;?>>ZAGREBAČKA</option>
                    </optgroup>
                    <optgroup label="Zapadna Hrvatska">
                        <option value="10" <?php echo $zupanija10;?>>ISTARSKA</option>
                        <option value="11" <?php echo $zupanija11;?>>LIČKO-SENJSKA</option>
                        <option value="12" <?php echo $zupanija12;?>>PRIMORSKO-GORANSKA</option>
                    </optgroup>
                    <optgroup label="Istočna Hrvatska">
                        <option value="13" <?php echo $zupanija13;?>>BRODSKO-POSAVSKA</option>
                        <option value="14" <?php echo $zupanija14;?>>OSJEČKO-BARANJSKA</option>
                        <option value="15" <?php echo $zupanija15;?>>POŽEŠKO-SLAVONSKA</option>
                        <option value="16" <?php echo $zupanija16;?>>VIROVITIČKO-PODRAVSKA</option>
                        <option value="17" <?php echo $zupanija17;?>>VUKOVARSKO-SRIJEMSKA</option>
                    </optgroup>
                    <optgroup label="Južna Hrvatska">
                        <option value="18" <?php echo $zupanija18;?>>DUBROVAČKO-NERETVANSKA</option>
                        <option value="19" <?php echo $zupanija19;?>>SPLITSKO-DALMATINSKA</option>
                        <option value="20" <?php echo $zupanija20;?>>ŠIBENSKO-KNINSKA</option>
                        <option value="21" <?php echo $zupanija21;?>>ZADARSKA</option>
                    </optgroup>
                </select><br />
                <label for="grad">Grad: </label>  
                <input type="text" name="grad" id="grad" value="<?php echo $grad?>" /><br />
                
                <label for="mail">Email: </label>
                <input type="email" name="mail" id="mail" value="<?php echo $mail?>"  /><br />
                <label for="kor_ime">Korisničko ime: </label>
                <input type="text" name="kor_ime" id="kor_ime" title="pet ili više znakova"
                       value="<?php echo $korIme?>" /><br />
                
                <label for="lozinka">Lozinka: </label>
                <input type="password" name="lozinka" id="lozinka" title="šest ili više znakova"
                       value="<?php echo $lozinka?>"  /><br />
                <label for="telefon">Telefon: </label>
                <input type="tel" name="telefon" id="telefon" value="<?php echo $telefon?>"
                       title="Format: xxx xxxxxxx" /><br />
                <label for="dat_rodj">Datum rođenja: </label>
                <input type="date" name="dat_rodj" id="dat_rodj" value="<?php echo $datumRodjenja?>" /><br />
                
                <label for="spol">Spol: </label>
                <?php
                $mSpol = "";
                $zSpol = "";
                $nSpol = "";
                switch ($spol) {
                    case "M":
                        $mSpol = 'checked=""';
                        break;
                    case "Ž":
                        $zSpol = 'checked=""';
                        break;
                    case "O":
                        $nSpol = 'checked=""';
                        break;
                }
                ?>
                <input type="radio" name="spol" id="spol" class="točke" value="M" <?php echo $mSpol ?>>M
                <input type="radio" name="spol" id="spol1" class="točke" value="Ž" <?php echo $zSpol ?>>Ž
                <input type="radio" name="spol" id="spol2" class="točke" value="O" <?php echo $nSpol ?>>Ne znam<br />  
                <label for="pretplata">Pretplata na mail: </label>
                <?php 
                    $pretplataChecked = "";
                    if($pretplataNaMail == 1){
                        $pretplataChecked = 'checked=""';
                    }
                    ?>
                <input type="checkbox" name="pretplata" id="pretplata" value="da" <?php echo $pretplataChecked ?>/><br /><br />   
                <input name="promijeni" type="submit" id="submit_btn" value="Promijeni" class="gumb" />
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
        <!--<script src="js/drazovko.js"></script>-->
    </body>
</html>