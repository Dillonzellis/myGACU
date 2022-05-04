<?php
$name = $_REQUEST['name'];
$email = $_REQUEST['email'];
$words = $_REQUEST['words'];

mail("admin@HALLCOcu.org", "Annual Meeting RSVP", "Name: $name\nEmail: $email\n\nComments: $words" );
header( "Location: info_sent.php" );
?>