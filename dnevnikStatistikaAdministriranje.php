<?php
include 'aplikacijskiOkvir/aplikacijskiOkvir.php';

$korisnik = provjeraUloge(ADMINISTRATOR);                          
dnevnik_zapis("Pregled dnevnika");

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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--    <link rel="stylesheet" href="/resources/demos/style.css"> -->  
         <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   
   <script src="http://datatables.net/download/build/nightly/jquery.dataTables.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/dataTables.jqueryui.min.css"/>
    <!--    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"/>-->
    <link rel="stylesheet" type="text/css" href="css/drazovko_tables.css"/>
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
                    echo '<li><a href="dnevnikStatistikaAdministriranje.php">Dnevnik</a></li>';
                }
                ?>
                <li><a href="detalji_korisnikaADM.php">Detalji korisika</a></li>
                <li><a href="logout.php">Odjava</a></li>
    
            </ul>
        </nav>
        <section id="sadržaj">
            <h1>Administratorski poslovi</h1>
            <section id="uvod">
                <?php
                $vrijemeServera =  time();
                $vrijemeVirtulanoDate = date('d.m.Y H:i:s', $virtualnoVrijemeSustava);
                echo 'Stvarno vrijeme servera: '. date('d.m.Y H:i:s', $vrijemeServera) . "<br>";
                echo 'Virtualno vrijeme sustava: ' . $vrijemeVirtulanoDate . " i pomak je: " . $sati22 . " sati";
                ?>
            <h2 align="center" class="podnaslov">Pregled dnevnika:</h2>
            
            
            
            
            <form action="php_xml/pdfStatiskikaDnevnika.php" method="get" target="_blank" name="pdfStatistike" id="pdfStatistike" enctype="multipart/form-data">
            <a id="a3" href="javascript:statistikaDnevnika()"><h3>Statistika dnevnika</h3></a>
                <label>Korisnik:</label>
            <input name="korisnik" id="korisnik"><br>
                <?php
                
                $poc = date('Y-m') . "-01";
                $zav = date('Y-m-d');
                ?>
            Od datuma: <input name = "odDatuma" id="odDatuma" type="date"value="<?php echo $poc; ?>"><br>
            Do datuma: <input name = "doDatuma" id="doDatuma" type="date"value="<?php echo $zav; ?>"><br>
            <label for="prijave">Prijave: </label>
            <input type="radio" name="prijave" id="ispravnePr" class="točke" value="1">Ispravne
            <input type="radio"  name="prijave" id="pogresnePr"  class="točke" value="0">Pogrešne
            <p align="right"><button type="submit" form="pdfStatistike" value="submit">PDF</button></p>
            <hr><br>
            </form>
            <a id="a2" href="javascript:dnevnik()"><h3>Pregled i pretraživanje dnevnika</h3></a>
            <label>Pretraživanje podataka iz dnevnika:</label>
            
            <input name="korisnik2" id="korisnik2"><br>
            <div id="tuto2"></div>
            <div id="tuto1"></div><hr><br>
            <form action="php_xml/pdfStatistikaAplikativna.php" method="get" target="_blank" name="pdfAplikativni" id="pdfAplikativni" enctype="multipart/form-data">
            <h2 align="center" class="podnaslov">Aplikativna statistika:</h2>
            <h4 align="center">Broj zahtijeva po županiji i/ili moderatoru</h4>
            <p align="right"><button type="submit" form="pdfAplikativni" value="submit">PDF</button></p>
            <label for="zupanija">Županija: </label>
                <select name="zupanija" id="zupanije" >
                    <option value="-1" selected="selected" >-- Odaberi županiju --</option>
                </select><br><br>
            <div id="tuto3"></div>
            <div id="tuto4"></div>
            </form>
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
        <script src="js/dnevnikStatistikaAdministriranje.js" ></script> 
    </body>
</html>
