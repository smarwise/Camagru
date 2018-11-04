<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("config/database.php");
require_once("config/setup.php");
session_start();

$db->query("USE ".$dbname);
$name = $_GET['id'];
$comment = $_POST['comment'];

$comment_length = strlen($comment);
if ($comment_length > 100)
{
    header("location: gallery.php?error=1");
}
else
{
    $db->query("INSERT INTO comments (name, comment, photo_id) VALUES ('$name', '$comment', '$name')");
    $htmlStr .= "Hi " . $email . ",<br /><br />";
	$htmlStr .= $_SESSION['username']. "commented on your picture .<br /><br /><br />";
	$htmlStr .= "Kind regards,<br />";
	$name = "Camagru";
	$email_sender = "no-reply@camagru.com";
	$subject = "New Comment| Camagru";
	$recipient_email = $email;
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: {$name} <{$email_sender}> \n";
	$body = $htmlStr;
	mail($recipient_email, $subject, $body, $headers);
    header("location: gallery.php");
}
?>