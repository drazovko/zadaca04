<?php
include_once('aplikacijskiOkvir/aplikacijskiOkvir.php');
$korisnik = provjeraKorisnika();
dnevnik_zapis("Pregled zahtijeva za legalizacijom");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Početna stranica</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <meta name="application-name" content="zahtijev za legalizacijom">
        <meta name="author" content="Dragan Zovko">
        <meta name="description" content="datum_kreiranja: 9.2.2017.">
        <link rel="stylesheet" type="text/css" href="css/drazovko.css"/>
        <link rel="stylesheet" type="text/css" media="screen and (max-width: 450px)" href="css/drazovko_mobitel.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:451px) and (max-width: 800px)" href="css/drazovko_tablet.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:801px) and (max-width: 1000px)" href="css/drazovko_pc.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:1001px)" href="css/drazovko_tv.css" />
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--    <link rel="stylesheet" href="/resources/demos/style.css"> -->  
         <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   
   <script src="http://datatables.net/download/build/nightly/jquery.dataTables.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/dataTables.jqueryui.min.css"/>
    <!--    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"/>-->
       
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
            <h1>Pregled zahtijeva za legalizacijom</h1>
            
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
            <br><br><br>
            
            <label></label>
            <input type="text" name="IdKor" id="IdKor" readonly="" hidden="" value="<?php 
            echo $korisnik->get_idKorisnika()?>"><br><br>
            <label for="korIme">Korisničko ime: </label>
            <input type="text" disabled="" name="korIme" id="korIme" readonly="" value="<?php 
            echo "- - - " . $korisnik->get_kor_ime(). " - - -"?>"><br><br>
            <div id="tuto"></div><br><br>
            <div id="greske"></div><h1 id="slanjeZahtijeva">Pregled zahtijeva</h1>
                    <p id="prica"></p></div><br>
            <div id="tuto5"></div><br><br>
            <div id="tuto6"></div><br><br>
            <div id="tuto2"></div><br><br>
            <div id="tuto3"></div><br><br>
            <div id="tuto4"></div><br><br>
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
        <script src="js/pregledZahtijeva.js" ></script> 
    </body>
</html>