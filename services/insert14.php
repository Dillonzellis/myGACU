<?
$username="hallc2";
$password="zbcna+an";
$database="hallc2";

$choice=$_POST['choice'];
$date=$_POST['date'];
$name=$_POST['name'];
$account=$_POST['account'];
$email=$_POST['email'];
$hphone1=$_POST['hphone'];
$cphone=$_POST['cphone'];

mysql_connect('localhost',$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query = "INSERT INTO optin VALUES ('','$choice','$date','$name','$account','$email','$hphone','$cphone',)";


mysql_query($query);

mysql_close();

echo "Your information has been submitted!<br>";
echo "Click <a href='optin.html'>here</a> to return.<br>"
?>

<?php 
$email_to = "Memberservices@hallcocu.org, cameronc@gcua.org";
$email_subject = "Overdraft Opt-In Form Submitted by $name";
$email_body = "A new overdraft opt-in form has been submitted by $name.";

if(mail($email_to, $email_subject, $email_body)){
    echo "The email $email_subject was successfully sent.";
} else {
    echo "The email $email_subject was NOT sent.";
}
?>
