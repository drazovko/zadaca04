<?php
$idZahtijeva = $_GET['idZahtijeva'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Registracija</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <meta name="application-name" content="registracija">
        <meta name="author" content="Dragan Zovko">
        <meta name="description" content="datum_kreiranja: 3.4.2015.">  
        <link rel="stylesheet" type="text/css" href="css/drazovko.css"/>
        <link rel="stylesheet" type="text/css" media="screen and (max-width: 450px)" href="css/drazovko_mobitel.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:451px) and (max-width: 800px)" href="css/drazovko_tablet.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:801px) and (max-width: 1000px)" href="css/drazovko_pc.css" />
        <link rel="stylesheet" type="text/css" media="screen and (min-width:1001px)" href="css/drazovko_tv.css" />
    </head>
    <body>
        <form action="php_xml/uploaderDokumenti.php" method="post" name="uploadSlike" id="obrazac" enctype="multipart/form-data" >
                <div id="greske"></div>
                
                <h3 align="center">Postavljanje dokumenata</h3>
                <label for="datoteka"><b>Odaberite dokumente za selektirani projekt: </b></label>
                <input type="file" name="userfile" id="datoteka" /><br />
                <br><br> 
                <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
                <input type="hidden" name="idZahtijeva" id="idZahtijeva" value="<?php echo $idZahtijeva ?>" />
                <input name="registracija" type="submit" id="submit_btn" value="Slanje podataka" class="gumb" />
                <input name="registracija" type="reset" value="Brisanje formulara" class="gumb" />
            </form>
    </body>
</html>