<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("config/database.php");
require_once("config/setup.php");
$db->query("USE ".$dbname);
session_start();

$photo_id = $_GET['id'];
$email = $db->prepare("SELECT * FROM photos where id = $photo_id");
$email->execute();
while($row = $email->fetch(PDO::FETCH_ASSOC))
{
    $line = $row;
}
$owner_email = $line['owner_email'];
$photo_name = $line['file_name'];
if ($owner_email == $_SESSION['email'])
{
    $del = $db->prepare("DELETE FROM photos WHERE id = $photo_id");
    $del->execute();
    $del = $db->prepare("DELETE FROM photo_likes WHERE photo = $photo_id");
    $del->execute();
    $del = $db->prepare("DELETE FROM comments WHERE photo_id = $photo_id");
    $del->execute();
    $path = $_SERVER['DOCUMENT_ROOT'].'/Camagru/uploads/'.$photo_name;
    unlink($path);
    header("Location:http://localhost:8080/Camagru/gallery.php");
}
else
{
    header("Location:http://localhost:8080/Camagru/gallery.php");
}
?>