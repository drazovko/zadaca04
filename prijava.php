<?php
include 'aplikacijskiOkvir/aplikacijskiOkvir.php';

//dnevnik zapis premješten niže da ulovi brojač pokušaja

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $brojac = 1 + $_POST['brojac'];
    dnevnik_zapis("Pokušaj prijave br.$brojac");
    $korIme = $_POST['kor_ime'];
    $lozinka = $_POST['lozinka'];
    $vrijednostKukija = "";
    
    $greske = "";
    
    
    $korisnik = autentikacija($korIme, $lozinka);
    
    $uri = $_SERVER["REQUEST_URI"];
    $pos = strrpos($uri, "/");
    $dir = $_SERVER["SERVER_NAME"] . substr($uri, 0, $pos + 1);
    
    if (isset($_POST['zapamti_me']) && $_POST['zapamti_me'] == "da") {
        setcookie("WebDiP2014x074", $korIme);
        $vrijednostKukija = $korIme;
    }  else {
        setcookie("WebDiP2014x074", $korIme, time() - 3600);
        $vrijednostKukija = "";
        
    }
    
    if ($korisnik->get_status() == 1) {
        session_start();
        $_SESSION["WebDiP2014x074"] = $korisnik;
        $adresa = 'http://' . $dir . 'index.php';
        dnevnik_zapis("Uspješno logiranje");
        header("Location: $adresa");
        exit();
    } else {
        if ($korisnik->get_status() == 5) {
            $greske = "Korisnika je potrebno aktivirati prije prijavljivanja!!!</br>";
        }  else {
            $greske = $greske . "Neispravno korisničko ime ili lozinka!!!</br>";
            if ($brojac > 1) {
                $greske = $greske . "Pokušaj broj " . $brojac . "!</br>";
            }    
        }   
    }
}  else {
    $greske = "";
    $brojac = 1;
    dnevnik_zapis("Pokušaj prijave br.$brojac");
    if (isset($_COOKIE['WebDiP2014x074'])) {
        $vrijednostKukija = $_COOKIE['WebDiP2014x074'];
    }  else {
        $vrijednostKukija = "";    
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Prijava</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <meta name="application-name" content="prijava">
        <meta name="author" content="Dragan Zovko">
        <meta name="description" content="datum_kreiranja: 3.4.2015.">     
        <link rel="stylesheet" type="text/css" href="css/drazovko.css"/>
        <link rel="stylesheet" type="text/css" media="screen and (max-width: 450px)" href="css/drazovko_mobitel.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:451px) and (max-width: 800px)" href="css/drazovko_tablet.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:801px) and (max-width: 1000px)" href="css/drazovko_pc.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:1001px)" href="css/drazovko_tv.css" />
    </head>
    <body>
        <header id="zaglvalje">
            <img src="img/logo.png" alt="foi logo" id="logo" />
            <p id="header_naslov">Zadaća 03</p>
        </header>
        <nav id="meni">
            <ul>
                <li><a href="index.php">Početna stranica</a></li>
                <li><a href="osobna.html">O meni</a></li>
                <li><a href="registracija.php">Registracija</a></li>
                <li><a href="prijava.php">Prijava</a></li>
                <li><a href="http://www.foi.unizg.hr" target="_blank">Foi web</a></li>
    
            </ul>
        </nav>
        <section id="sadržaj">
            <article>
                <h2 class="tekst_na_prijavi">Pristup ovoj stranici omogućen je samo autoriziranim korisnicima.</h2>
                <p class="tekst_na_prijavi">Ako imate pravo pristupa, moći ćete pristupiti ovoj stranici nakon što se prijavite.</p>
                <form action="" method="post" name="prijava" id="prijava" enctype="multipart/form-data">
                    <div id="greske"><?php echo $greske ?></div></br>
                    <label for="kor_ime">Korisničko ime: </label>
                    <input type="text" name="kor_ime" id="kor_ime" autofocus="" required=""
                           placeholder="Korisničko ime" value="<?php echo $vrijednostKukija;?>"/><br />
                    <label for="lozinka">Lozinka: </label>
                    <input type="password" name="lozinka" id="lozinka" required=""
                           placeholder="Lozinka"/><br />
                    <label for="zapamti">Zapamti me: </label>
                    
                    <input type="checkbox" name="zapamti_me" id="zapamti" value="da"/><br />
                    <button type="submit" form="prijava" value="submit" class="gumb">
                        Prijavi se</button><br />
                    <input type="text" name='brojac' id="brojac" value="<?php echo $brojac ?>" hidden="">
                </form>
            </article>
            <article class="tekst_na_prijavi">
                Registriraj se <a href="registracija.php">ovdje</a>
            </article>
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