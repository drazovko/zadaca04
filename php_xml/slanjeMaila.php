<?php
        $mail_to = $_GET["mail_to"];
        $mail_from = $_GET['mail_from'];
        $mail_subject = $_GET['mail_subject'];
        $mail_body = $_GET['mail_body'];

        if (mail($mail_to, $mail_subject, $mail_body, $mail_from)) {
            $poslano = 0;
        } else {
            $poslano = 1;
        }
        
        $output = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>' . "\n";
$output .= '<obrada>';

$output .= '<obradjen mail="' . $mail_to . '">' . $poslano . '</obradjen>' . "\n";

$output .= '</obrada>';


header("Content-Type: text/xml");
print $output;