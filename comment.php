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
$email = $_SESSION['email'];

$comment_length = strlen($comment);
if ($comment_length > 100)
{
    header("location: gallery.php?error=1");
}
else
{
	$query = "SELECT * FROM photos where id = :photo_id";
    $line = $db->prepare($query);
	$line->bindParam(':photo_id', $name);
	$line->execute();
	$owner_email = "";
	$photo_owner = "";
	while ($row = $line->fetch(PDO::FETCH_ASSOC))
    {
        $photo_owner = $row;
	}
	$owner_email = $photo_owner["owner_email"];
	$htmlStr = "";
    $db->query("INSERT INTO comments (name, comment, photo_id) VALUES ('$name', '$comment', '$name')");
    $htmlStr .= "Hi " . $owner_email . ",<br /><br />";
	$htmlStr .= $_SESSION['username']. " commented on your picture .<br /><br /><br />";
	$htmlStr .= "Kind regards,<br />";
	$name = "Camagru";
	$email_sender = "no-reply@camagru.com";
	$subject = "New Comment| Camagru";
	$recipient_email = $owner_email;
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: {$name} <{$email_sender}> \n";
	$body = $htmlStr;
	mail($recipient_email, $subject, $body, $headers);
    header("location: gallery.php");
}
?>