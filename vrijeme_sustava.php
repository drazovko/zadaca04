<?php
$url = "http://arka.foi.hr/PzaWeb/PzaWeb2004/config/pomak.xml";

if (!($fp = fopen($url, 'r'))) {
    echo "Problem: nije moguće otvoriti url: " . $url;
    exit;
}

// XML data
$xml_string = fread($fp, 10000);
fclose($fp);

// create a DOM object from the XML data
$domdoc = new DOMDocument;
$domdoc->loadXML($xml_string);

$params = $domdoc->getElementsByTagName('pomak');
$sati = 0;

foreach ($params as $param) {
    $attributes = $param->attributes;
    foreach ($attributes as $attr => $val) {
        if ($attr == "brojSati") {
            $sati = $val->value;
        }
    }
}

$vrijemeServera = time();
//global $virtualnoVrijemeSustava;
$virtualnoVrijemeSustava = $vrijemeServera + ($sati * 60 * 60);