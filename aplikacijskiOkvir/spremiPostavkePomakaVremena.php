<?php
$url = "http://arka.foi.hr/PzaWeb/PzaWeb2004/config/pomak.xml";

if (!($fp = fopen($url, 'r'))) {
    echo "Problem: nije moguće otvoriti url: " . $url;
    exit;
}

// XML data
$xml_string = fread($fp, 10000);
fclose($fp);

$fp = fopen("postavkePomakaVremena.xml", "w");
        fwrite($fp, $xml_string);
        fclose($fp);

header("Location: ../postaviVrijemeSustava.php");
