<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require 'aplikacijskiOkvir/baza.class.php';
        $baza = new baza();
        echo 'Baza 1 otvorena <br>';
        
        $baza2 = new baza();
        echo "Baza 2 otvorena <br>";
        
        for ($index = 0; $index < 5; $index++) {
            $baza3[$index] = new baza();
        }
      
        echo 'Radi <br>';
        
        $sql = "select prezime, ime, maticni_broj FROM POLAZNICI " .
                "order by prezime, ime";
        
        $upit = $baza->selectUpit($sql);
        
        print "<table border=1><tr><td>Prezime</td><td>Ime</td><td>Maticni_broj</td></tr>\n";

        while (list($prezime, $ime, $maticni_broj) = $upit->fetch_array()) {
            print "<tr><td>$prezime</td><td>$ime</td><td>$maticni_broj</td></tr>\n";
        }
        print "</table>\n";

        $upit->close();
        
        $sql = "insert into POLAZNICI " .
                "(maticni_broj, prezime, ime, lozinka, email_adresa) " .
                "values ('40001/00-R', 'Kermek', 'Dragutin', '123456', 	'dkermek@foi.hr')";
        
        $sql2 = "delete from polaznici where prezime = 'Kermek'";
        
        $upit2 = $baza->ostaliUpiti($sql);
        
        
        
        $sql = "select prezime, ime, maticni_broj FROM POLAZNICI " .
                "order by prezime, ime";
        
        $upit = $baza->selectUpit($sql);
        
        print "<table border=1><tr><td>Prezime</td><td>Ime</td><td>Maticni_broj</td></tr>\n";

        while (list($prezime, $ime, $maticni_broj) = $upit->fetch_array()) {
            print "<tr><td>$prezime</td><td>$ime</td><td>$maticni_broj</td></tr>\n";
        }
        print "</table>\n";

        $upit->close();
        
        $baza->zatvoriBazuPodataka();
        ?>
    </body>
</html>
