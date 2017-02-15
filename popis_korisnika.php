<?php
include 'aplikacijskiOkvir/aplikacijskiOkvir.php';

$korisnik = provjeraUloge(ADMINISTRATOR);                          
dnevnik_zapis("Popis svih korisnika");

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Početna stranica</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <meta name="application-name" content="popis korisnika">
        <meta name="author" content="Dragan Zovko">
        <meta name="description" content="datum_kreiranja: 12.1.2017.">
        <link type="text/css" rel="stylesheet" media="print" href="css/pisac.css">
        <link rel="stylesheet" type="text/css" href="css/drazovko.css"/>
        <link rel="stylesheet" type="text/css" media="screen and (max-width: 450px)" href="css/drazovko_mobitel.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:451px) and (max-width: 800px)" href="css/drazovko_tablet.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:801px) and (max-width: 1000px)" href="css/drazovko_pc.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:1001px)" href="css/drazovko_tv.css" />
    </head>
    <body>
        <header id="zaglvalje" >
            
            <img src="img/logo.png" alt="foi logo" id="logo" />
            <p id="header_naslov">Legalizacija</p>
            <p align="right"><a href="logout.php">Odjava </a></p>
        </header>
        <nav id="meni">
            <ul>
                <li><a href="pocetnaRegKor.php">Početna</a></li>
                <li><a href="zahtijevZaLegalizacijom.php">Obrazac</a></li>
                <li><a href="pregledZahtijeva.php">Zahtijevi</a></li>
                <?php
                if ($korisnik->get_vrsta() == ADMINISTRATOR || $korisnik->get_vrsta() == MODERATOR) {
                    echo '<li><a href="zahtijeviGradjevinar.php">Zahtijevi građevinar</a></li>';
                }
                if ($korisnik->get_vrsta() == ADMINISTRATOR) {
                    echo '<li><a href="popis_korisnika.php">Korisnici</a></li>';
                    echo '<li><a href="postaviVrijemeSustava.php">Postavi vrijeme sustava</a></li>';
                }
                ?>
                <li><a href="detalji_korisnikaADM.php">Detalji korisika</a></li>
                <li><a href="logout.php">Odjava</a></li>
    
            </ul>
        </nav>
        <section id="sadržaj">
            <h1>Popis svih korisnika</h1>
            <section id="uvod">
            <h3 class="podnaslov">Popis svih korisnika:</h3>
        
            <ul>
        <?php
        $dbc = new baza();
        
        $sql = "SELECT `kor_ime`, `ime`, `prezime`, `grad` FROM `korisnik` ";
               // . "WHERE `aktiviran` = 1";
        
        $odgovor = $dbc->selectUpit($sql);
        
        while (list($korIme, $ime, $prezime, $grad) = $odgovor->fetch_array()) {
            echo "<li><a href=\"detalji_korisnikaADM.php?korIme=$korIme\">$korIme</a></li>";
            echo "<ul>";
            echo "<li>$ime</li>";
            echo "<li>$prezime</li>";
            echo "<li>$grad</li></br>";
            echo "</ul>";
        }
        
        ?>
            </ul>
            
            </section>
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
