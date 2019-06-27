<?php
$to = "muhammedgani@teamtweaks.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: aravind@teamtweaks.com" . "\r\n" .
"CC: aravind@teamtweaks.com";

mail($to,$subject,$txt,$headers);

?>