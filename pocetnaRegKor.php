<?php
include_once('aplikacijskiOkvir/aplikacijskiOkvir.php');
$korisnik = provjeraKorisnika();
dnevnik_zapis("Početak aplikacije RegKor");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Početna stranica</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <meta name="application-name" content="početna stranica">
        <meta name="author" content="Dragan Zovko">
        <meta name="description" content="datum_kreiranja: 17.1.2017.">
        <link rel="stylesheet" type="text/css" href="css/drazovko.css"/>
        <link rel="stylesheet" type="text/css" media="screen and (max-width: 450px)" href="css/drazovko_mobitel.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:451px) and (max-width: 800px)" href="css/drazovko_tablet.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:801px) and (max-width: 1000px)" href="css/drazovko_pc.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:1001px)" href="css/drazovko_tv.css" />
   
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script src="http://datatables.net/download/build/nightly/jquery.dataTables.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/dataTables.jqueryui.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"/>
        
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
                <li><a href="gradjevinariRegKor.php">Građevinari</a></li>
                <?php
                if ($korisnik->get_vrsta() == ADMINISTRATOR) {
                    echo '<li><a href="popis_korisnika.php">Korisnici</a></li>';
                    echo '<li><a href="http://arka.foi.hr/PzaWeb/PzaWeb2004/config/vrijeme.html" '
                    . 'target="_blank">Postavi vrijeme sustava</a></li>';  
                    
                }
                ?>
                <li><a href="detalji_korisnikaADM.php">Detalji korisika</a></li>
                <li><a href="logout.php">Odjava</a></li>
            </ul>
        </nav>
        <section id="sadržaj">
            <h1>Županije i građevinari</h1>
            
            <form action="" method="post" name="registracija" id="obrazac" enctype="multipart/form-data" > 
            <p class="header_poruka">
                Korisnik <b><?php echo $korisnik->get_ime_prezime()?></b> 
                je prijavljen od: <?php echo $korisnik->get_prijavljen_od() .
            " i aktivan : " . $korisnik->get_aktivan() . " sek";
            ?>
            </p>
            <p class="header_poruka">
                Posljednja uspješna prijava korisnika 
                <b><?php echo $korisnik->get_ime_prezime()?></b>
                 je bila: <?php echo $korisnik->get_posljednja_uspjesna_prijava() ?>
            </p> 
            <hr>
            <h3>Popis županija</h3>
            <p>Odabirom županije vidi se popis građevinara sa brojem koliko ima 
                ukupno postavljenih videa, slika i dokumenata.</p><br>
                <label for="zupanija">Županija: </label>
                <select name="zupanija" id="zupanije" size="5">
                    <option value="-1" selected="selected" >-- Odaberi županiju --</option>
                </select><br><br>
                
            </form>
            <section id="uvod" style="width: 87%">
            
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
        <!--<script src="https://code.jquery.com/jquery-1.10.2.js"></script>-->
        <script src="js/pocetna_stranica_jquery.js" ></script> 
    </body>
</html>