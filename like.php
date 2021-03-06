<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("config/database.php");
require_once("config/setup.php");
session_start();

if (!isset($_SESSION["logged_in"]))
{
    header("Location: login.php");
}
if (isset($_GET['type']))
{
    $type = $_GET['type'];
    $page = $_GET['page'];
    $id =  (int)$_GET['id'];

   if ($type == "photo")
   {
       echo "OK";
       $db->query("
           INSERT INTO photo_likes (user, photo)
       SELECT {$_SESSION['user_id']}, {$id}
       FROM photos
       WHERE EXISTS(
           SELECT id FROM photos where id= {$id})
           AND NOT EXISTS(
               SELECT id
               FROM photo_likes
               WHERE user = {$_SESSION['user_id']}
               AND photo = {$id})
           LIMIT 1
           ");
   }  
}
 header("Location: gallery.php?page=$page");
?>