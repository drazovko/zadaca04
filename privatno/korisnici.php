<?php
//include '../aplikacijskiOkvir/aplikacijskiOkvir.php';
include_once('../aplikacijskiOkvir/baza.class.php');

//$korisnik = provjeraUloge(ADMINISTRATOR);                          
//dnevnik_zapis("Popis svih korisnika");

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
        <link rel="stylesheet" type="text/css" href="../css/drazovko.css"/>
        <link rel="stylesheet" type="text/css" media="screen and (max-width: 450px)" href="../css/drazovko_mobitel.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:451px) and (max-width: 800px)" href="../css/drazovko_tablet.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:801px) and (max-width: 1000px)" href="../css/drazovko_pc.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:1001px)" href="../css/drazovko_tv.css" />
    </head>
    <body>
        <header id="zaglvalje" >
            
            <img src="../img/logo.png" alt="foi logo" id="logo" />
            <p id="header_naslov">Legalizacija</p>
            <p align="right"><a href="logout.php">Odjava </a></p>
        </header>
        <nav id="meni">
            <ul>
                <li><a href="../index.php">Početna stranica</a></li>
                
                <li><a href="../prijava.php">Prijava</a></li>
                
                <li><a href="http://www.foi.unizg.hr" target="_blank">Foi web</a></li>
    
            </ul>
        </nav>
        <section id="sadržaj">
            <h1>Popis svih korisnika</h1>
            <section id="uvod">
            <h3 class="podnaslov">Popis svih korisnika:</h3>
        
            <ul>
        <?php
        $dbc = new baza();
        
        $sql = "SELECT `kor_ime`, `password`, uloga.naziv FROM `korisnik` JOIN uloga ON korisnik.uloga_iduloga = uloga.iduloga";
        
        $odgovor = $dbc->selectUpit($sql);
        
        while (list($korIme, $password, $uloga) = $odgovor->fetch_array()) {
            echo "<li>$korIme</li><br>";
            echo "<ul>";
            echo "<li>Lozinka: $password</li>";
            echo "<li>Vrsta:   $uloga</li>";
            echo "</ul>";
            echo "<hr><br>";
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