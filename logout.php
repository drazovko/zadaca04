<?php
//include_once('aplikacijskiOkvir/aplikacijskiOkvir.php');

//dnevnik_zapis("Odjava korisnika");


session_start();
unset($_SESSION["WebDiP2014x074"]);
session_destroy();
header("Location: prijava.php");
