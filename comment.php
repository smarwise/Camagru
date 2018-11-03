<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("config/database.php");
require_once("config/setup.php");

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
    header("location: gallery.php");
}
?>