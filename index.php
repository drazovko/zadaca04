<?php
include_once('aplikacijskiOkvir/aplikacijskiOkvir.php');
$korisnik = provjeraKorisnika();
dnevnik_zapis("Početak aplikacije");
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
    </head>
    <body>
        <header id="zaglvalje" >
            
            <img src="img/logo.png" alt="foi logo" id="logo" />
            <p id="header_naslov">Zadaća 05</p>
            <p align="right"><a href="logout.php">Odjava </a></p>
        </header>
        <nav id="meni">
            <ul>
                <li><a href="index.php">Početna stranica</a></li>
                <li><a href="osobna.html">O meni</a></li>
                <li><a href="registracija.php">Registracija</a></li>
                <li><a href="prijava.php">Prijava</a></li>
                <?php
                if ($korisnik->get_vrsta() == ADMINISTRATOR) {
                    echo '<li><a href="popis_korisnika.php">Korisnici</a></li>';
                    echo '<li><a href="http://arka.foi.hr/PzaWeb/PzaWeb2004/config/vrijeme.html" '
                    . 'target="_blank">Postavi vrijeme sustava</a></li>';  
                    
                }
                ?>
                <li><a href="detalji_korisnikaADM.php">Detalji korisika</a></li>
                <li><a href="http://www.foi.unizg.hr" target="_blank">Foi web</a></li>
                
            </ul>
        </nav>
        <section id="sadržaj">
            <h1>Web dizajn i programiranje</h1><br>
            <section id="uvod">
            <h2>Osnovne informacije</h2><br>
            
            <h3 class="podnaslov">Cilj kolegija:</h3>
        
            <p class = "tekst">
                Cilj kolegija je upoznavanje studenata s elementima dizajna web stranica i razvoja web aplikacija. Predmetom se obrađuju glavni elementi koji čine pojedinačne sastavne komponente cjelovitog projektnog rješenja na web platformi. Predmet prati moguće razine realizacije Web projekata tako da se studentima pruža uvid u različite tehnološke mogućnosti koje mogu primijeniti u konkretnim situacijama. Studenti tijekom praktičnog dijela kolegija rade vježbe kojima postepeno razvijaju pojedine gradive blokove kasnijih web stranica i aplikacija. Prezentacijom izabranih rješenja otvara se diskusija tijekom koje studenti mogu izraziti svoje mišljenje o dizajnu, dovršenosti i drugim dogovorenim kriterijima kvalitete, čime se potiče kritičko razmišljanje o tuđem i vlastitom rješenju
            </p>
            <h3 class="podnaslov">Ishodi učenja predmeta</h3>
            <ul>
                <li>analizirati opterećenje Web poslužitelja i predložiti potrebne radnje za poboljšanje njegovih performansi</li>
                <li>izraditi Web aplikacije različite namjene i složenosti ...</li>
                <li>razlikovati Web tehnologije</li>
                <li>razumijeti osobine skriptnih programskih jezika i koristiti ih u realizaciji Web aplikacije</li>
                <li>razumjeti i koristiti razne servise za potrebe Web aplikacija</li>
                <li>razumjeti i primijeniti hipertekstualno i hipermedijsko povezivanje dokumenata</li>
                <li>razumjeti i primijeniti preporuke Web dizajna</li>
                <li>razumjeti i primijeniti preporuke Web inženjerstva</li>
                <li>razumjeti način funkcioniranja Web mjesta i Web aplikacija</li>
                <li>razumjeti osobine korisničke i poslužiteljske strane Web aplikacija te ih primijeniti na način koji odgovara specifičnostima pojedinog projekta</li>
                <li>razumjeti principe rada Web autorskih alata i znati ih koristiti ih u razvoju Web mjesta</li>
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
