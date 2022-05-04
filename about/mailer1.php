<?php
$name = $_REQUEST['name'];
$email = $_REQUEST['email'];
$words = $_REQUEST['words'];

mail("memberservices@HALLCOcu.org", "Contact Us Form", "Name: $name\nEmail: $email\n\nComments: $words" );
header( "Location: info_sent.php" );
?>