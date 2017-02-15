<?php
include 'aplikacijskiOkvir/aplikacijskiOkvir.php';
include 'aplikacijskiOkvir/provjereKodUnosaKor.php';

dnevnik_zapis("Registracija korisnika");

$greske = "";
$greska = FALSE;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ime = $_POST["ime"];
    $prezime = $_POST["prezime"];
    $grad = $_POST["grad"];
    $lozinka = $_POST["lozinka"];
    $mail = $_POST["mail"];
    $korIme = $_POST["kor_ime"];
    if (!isset($_POST["spol"])) {
        $spol = "";
    }  else {
        $spol = $_POST["spol"];
    }
    
    
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
    //Ugradnja captcha provjere
    $captcha;
    if(isset($_POST['g-recaptcha-response'])){
        $captcha=$_POST['g-recaptcha-response'];
    }
    if(!$captcha){
        echo '<h2>Please check the the captcha form.</h2>';
        exit();
    }
    $secretKey = "6Lc7lA4UAAAAALWV4wyhXVD5tVwxlZCIBgU4N3YD";
    $ip = $_SERVER['REMOTE_ADDR'];
    $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
    $responseKeys = json_decode($response,true);
    if(intval($responseKeys["success"]) !== 1) {
        echo '<h2>You are spammer ! Get the @$%K out</h2>';
        exit();
    } /*else {
        $greske = $greske . "Nisi robot! <br>";
    }   */
    //Završna provjera da je sve ok
    if ($greske == "") {
        $aktivacijkiKod = md5(rand(1, 100000));
        //echo 'Generiran aktivacijski kod!</br>';
        while (!provjeraZauzetostiAktivacijskogKoda($aktivacijkiKod)) {
            //echo 'Ponovo generiran aktivacijski kod!</br>';
            $aktivacijkiKod = md5(rand(1, 100000));
        }
        $zapis = zapisNovogKorisnikaUBazu($aktivacijkiKod);
        if ($zapis === 0) {
            echo 'Korisnik nije upisan u bazu';
            exit();
        }  else {
            //echo 'Korisnik upisan u bazu!</br>';
        }
        //slanje aktivacijskog e-maila sa linkom za aktivaciju korisničkog 
        //računa na mail adresu unesenu u obrazac za registraciju
        $korIme = $_POST['kor_ime'];
        $mail_to = $_POST["mail"];
        $mail_from = "From: WebDiP_2014@foi.hr";
        $mail_subject = "Link za aktivaciju korisničkog računa";
        $mail_body = "http://arka.foi.hr/WebDiP/2014_projekti/WebDiP2014x074/"
                . "aktivacija.php?aktivacijskiKod=$aktivacijkiKod&korIme=$korIme";

        if (mail($mail_to, $mail_subject, $mail_body, $mail_from)) {
            //echo("Poslana poruka za: '$mail_to'!");
        } else {
            echo("Problem kod poruke za: '$mail_to'!");
        }
        
        header("Location: prijava.php");
        exit();
    }
} else {
    $greske = "Svi podaci moraju biti uneseni (osim slike)!";
    $ime = "";
    $prezime = "";
    $grad = "";
    $lozinka = "";
    $korIme = "";
    $mail = "";
    $spol = "";
    
    $bojaPoljaIme = "";
    $bojaPoljaPrezime = "";
    $bojaPoljaGrad = "";
    $bojaPoljaLozinka = "";
    $bojaPoljaKorIme = "";
    $bojaPoljaMail = "";
}


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body>
        <head>
        <title>Registracija</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <meta name="application-name" content="registracija">
        <meta name="author" content="Dragan Zovko">
        <meta name="description" content="datum_kreiranja: 3.4.2015.">  
        <link type="text/css" rel="stylesheet" media="print" href="css/pisac.css">
        <link rel="stylesheet" type="text/css" href="css/drazovko.css"/>
        <link rel="stylesheet" type="text/css" media="screen and (max-width: 450px)" href="css/drazovko_mobitel.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:451px) and (max-width: 800px)" href="css/drazovko_tablet.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:801px) and (max-width: 1000px)" href="css/drazovko_pc.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:1001px)" href="css/drazovko_tv.css" />
        
    </head>
    <body>
        <header id="zaglvalje">
            <img src="img/logo.png" alt="foi logo" id="logo" />
            <p id="header_naslov">Legalizacija</p>
        </header>
        <nav id="meni">
            <ul>
                <li><a href="pocetna.php">Početna</a></li>
                <li><a href="registracija.html">Registracija - klijent</a></li>
                <li><a href="registracija.php">Registracija - server</a></li>
                <li><a href="prijava.php">Prijava</a></li>
            </ul>
        </nav>
        <section id="sadržaj">
            <form action="" method="post" name="registracija" id="obrazac" enctype="multipart/form-data" >
                <div id="greske"><?php echo $greske ?></div></br>
                <label for="ime">Unesite vaše ime: </label>
                <input type="text" name="ime" id="ime" size="20" maxlength="30" 
                       placeholder="  -- ime --" 
                       value="<?php echo $ime . '" style="' . $bojaPoljaIme ?>"/><br />
                <label for="prezime">Unesite vaše prezime: </label>
                <input type="text" name="prezime" id="prezime" size="20" maxlength="50" 
                       placeholder="  -- prezime --" 
                       value="<?php echo $prezime . '" style="' . $bojaPoljaPrezime ?>"/><br />
                <label for="datoteka">Odaberite sliku: </label>
                <input type="file" name="datoteka" id="datoteka" /><br />
                <label for="adresa" >Adresa: </label>
                <textarea name="adresa" id="adresa" rows="2" cols="30" ></textarea><br />
                <label for="županije">Županija: </label>
                <select name="zupanija" id="županije">
                    <option value="-1" >-- Odaberi županiju --</option>
                    <optgroup label="Sjeverna Hrvatska">
                        <option value="1" >BJELOVARSKO-BILOGORSKA</option>
                        <option value="2" >KOPRIVNIČKO-KRIŽEVAČKA</option>
                        <option value="3" >KRAPINSKO-ZAGORSKA</option>
                        <option value="4" >MEĐIMURSKA</option>
                        <option value="5" selected="selected">VARAŽDINSKA</option>
                    </optgroup>
                    <optgroup label="Središnja Hrvatska">
                        <option value="5" >GRAD ZAGREB</option>
                        <option value="6" >KARLOVAČKA</option>
                        <option value="7" >SISAČKO-MOSLAVAČKA</option>
                        <option value="8" >ZAGREBAČKA</option>
                    </optgroup>
                    <optgroup label="Zapadna Hrvatska">
                        <option value="9" >ISTARSKA</option>
                        <option value="10" >LIČKO-SENJSKA</option>
                        <option value="11" >PRIMORSKO-GORANSKA</option>
                    </optgroup>
                    <optgroup label="Istočna Hrvatska">
                        <option value="12" >BRODSKO-POSAVSKA</option>
                        <option value="13" >OSJEČKO-BARANJSKA</option>
                        <option value="14" >POŽEŠKO-SLAVONSKA</option>
                        <option value="15" >VIROVITIČKO-PODRAVSKA</option>
                        <option value="16" >VUKOVARSKO-SRIJEMSKA</option>
                    </optgroup>
                    <optgroup label="Južna Hrvatska">
                        <option value="17" >DUBROVAČKO-NERETVANSKA</option>
                        <option value="18" >SPLITSKO-DALMATINSKA</option>
                        <option value="19" >ŠIBENSKO-KNINSKA</option>
                        <option value="20" >ZADARSKA</option>
                    </optgroup>
                </select><br />
                
                <label for="grad">Grad: </label>  
                <input type="text" name="grad" id="grad"
                       value="<?php echo $grad . '" style="' . $bojaPoljaGrad ?>"/><br />
                
                <label for="mail">Email: </label>
                <input type="email" name="mail" id="mail" 
                        value="<?php echo $mail . '" style="' . $bojaPoljaMail ?>" /><br />
                <label for="kor_ime">Korisničko ime: </label>
                <input type="text" name="kor_ime" id="kor_ime" title="pet ili više znakova"
                        value="<?php echo $korIme . '" style="' . $bojaPoljaKorIme ?>"/><br />
                
                <label for="lozinka">Lozinka: </label>
                <input type="password" name="lozinka" id="lozinka" title="šest ili više znakova"
                       value="<?php echo $lozinka . '" style="' . $bojaPoljaLozinka ?>"/><br />
                <label for="telefon">Telefon: </label>
                <input type="tel" name="telefon" id="telefon" pattern="[0-9]{3}[/ ][0-9]{7}"
                       title="Format: xxx xxxxxxx" /><br />
                <label for="dat_rodj">Datum rođenja: </label>
                <input type="date" name="dat_rodj" id="dat_rodj"/><br />
                
                <label for="spol">Spol: </label>
                <input type="radio" name="spol" id="spol" class="točke" value="M">M
                    <input type="radio" name="spol" id="spol1" class="točke" value="Ž">Ž
                    <input type="radio" name="spol" id="spol2" class="točke" value="O" >Ne znam<br />
                <label for="pretplata">Pretplata na mail: </label>
                <input type="checkbox" name="pretplata" id="pretplata" value="da"/><br /><br />    
                <div align="center" class="g-recaptcha" data-sitekey="6Lc7lA4UAAAAAHriIQlNqFYCjYIJlDsppKKroNv9"></div><br />
                <input name="registracija" type="submit" id="submit_btn" value="Slanje podataka" class="gumb" />
                <input name="registracija" type="reset" value="Brisanje formulara" class="gumb" />
                
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
    </body>
</html>
