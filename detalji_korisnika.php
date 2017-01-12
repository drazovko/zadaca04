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
            <section id="osobna_stranica" > 
            <ul>
            <?php
            include 'baza.class.php';
            
            $korIme = $_GET['korIme'];
        
        $dbc = new baza();
        
        $sql = "SELECT `ime`, `prezime`, `adresa`, `zupanija`, `grad`, `email`, "
                . "`kor_ime`, `telefon`, `datum_rodjenja`, `spol`, `pretplata_na_mail` "
                . "FROM `korisnik` WHERE `kor_ime` = '$korIme'";
        
        $odgovor = $dbc->selectUpit($sql);
        
        list($ime, $prezime, $adresa, $zupanija, $grad, $email, $korIme, $telefon, $datumRodjenja, $spol, $pretplataNaMail) = $odgovor->fetch_array();
            echo "<li><a href=\"detalji_korisnika.php?korIme=$korIme\">$korIme</a></li>";
            echo "<ul>";
            echo "<li>$ime</li>";
            echo "<li>$prezime</li>";
            echo "<li>$grad</li></br>";
            echo "</ul>";
        
        
         ?>
            <table id="glupa_tablica" >
                <tr><td>Ime:</td><td><?php echo $ime?></td></tr>    
                <tr><td>Prezime:</td><td><?php echo $ime?></td></tr>
                <tr><td>Slika:</td><td><?php echo $ime?></td></tr>
                <tr><td>Adresa:</td><td>$ime</td></tr>
                <tr><td>Županija:</td><td>$ime</td></tr>
                <tr><td>Grad:</td><td>$ime</td></tr>
                <tr><td>Email:</td><td>$ime</td></tr>
                <tr><td>Korisničko ime:</td><td>$ime</td></tr>
                <tr><td>Lozinka:</td><td>$ime</td></tr>
                <tr><td>Telefon:</td><td>$ime</td></tr>
                <tr><td>Datum rodjenja:</td><td>$ime</td></tr>
                <tr><td>Spol:</td><td>$ime</td></tr>
                <tr><td>Pretplata na mail:</td><td>$ime</td></tr>
                
                
                
            </table>
            <form action="http://arka.foi.hr/WebDiP/2014/materijali/zadace/ispis_forme.php" 
                  method="post" name="registracija" id="obrazac" enctype="multipart/form-data" >
                <div id="greske"></div>
                <label for="ime">Unesite vaše ime: </label>
                <input type="text" name="ime" id="ime" size="20" maxlength="30" 
                       placeholder="  -- ime --" /><br />
                <label for="prezime">Unesite vaše prezime: </label>
                <input type="text" name="prezime" id="prezime" size="20" maxlength="50" 
                       placeholder="  -- prezime --" /><br />
                <label for="datoteka">Odaberite sliku: </label>
                <input type="file" name="datoteka" id="datoteka" /><br />
                <label for="adresa" >Adresa: </label>
                <textarea name="adresa" id="adresa" rows="2" cols="30" ></textarea><br />
                <label for="županije">Županija: </label>
                <select id="županije">
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
                <input type="text" name="grad" id="grad"/><br />
                
                <label for="mail">Email: </label>
                <input type="email" name="mail" id="mail" 
                       pattern="[a-zA-Z0-9]+[@]+foi+[.]+hr" required="" /><br />
                <label for="kor_ime">Korisničko ime: </label>
                <input type="text" name="kor_ime" id="kor_ime" title="pet ili više znakova"
                       pattern=".{5,}" /><br />
                
                <label for="lozinka">Lozinka: </label>
                <input type="password" name="lozinka" id="lozinka" title="šest ili više znakova"
                       pattern=".{6,}"  /><br />
                <label for="telefon">Telefon: </label>
                <input type="tel" name="telefon" id="telefon" pattern="[0-9]{3}[/ ][0-9]{7}"
                       title="Format: xxx xxxxxxx" /><br />
                <label for="dat_rodj">Datum rođenja: </label>
                <input type="date" name="dat_rodj" id="dat_rodj"/><br />
                
                <label for="spol">Spol: </label>
                <input type="radio" name="spol" id="spol" class="točke" value="1">M
                    <input type="radio" name="spol" id="spol1" class="točke" value="2">Ž
                    <input type="radio" name="spol" id="spol2" class="točke" value="3" >Ne znam<br />
                <label for="pretplata">Pretplata na mail: </label>
                <input type="checkbox" name="pretplata" id="pretplata" value="da"/><br />    
                <input name="registracija" type="submit" id="submit_btn" value="Slanje podataka" class="gumb" />
                <input name="registracija" type="reset" value="Brisanje formulara" class="gumb" />
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
        <script src="js/drazovko.js"></script>
    </body>
</html>
