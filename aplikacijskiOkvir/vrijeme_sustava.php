<?php        
if (!($fp = fopen("aplikacijskiOkvir/postavkePomakaVremena.xml", 'r'))) {
    echo "Problem: nije moguće otvoriti datoteku postavkePomakaVremena.php";
    exit;
}   

$xml_string2 = fread($fp, 10000);
fclose($fp);
// create a DOM object from the XML data
$domdoc = new DOMDocument;
$domdoc->loadXML($xml_string2);

$params = $domdoc->getElementsByTagName('pomak');
$sati22 = 0;

foreach ($params as $param) {
    $attributes = $param->attributes;
    foreach ($attributes as $attr => $val) {
        if ($attr == "brojSati") {
            $sati22 = $val->value;
        }
    }
}

$vrijemeServera = time();
//global $virtualnoVrijemeSustava;
$virtualnoVrijemeSustava = $vrijemeServera + ($sati22 * 60 * 60);
