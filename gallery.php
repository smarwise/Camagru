<link rel="stylesheet"  href="gallery.css">
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("config/database.php");
require_once("config/setup.php");
$db->query("USE ".$dbname);

$query = $db->query("
    SELECT photos.id, photos.file_name,
    COUNT(photo_likes.id) AS likes,
    GROUP_CONCAT(users.username SEPARATOR '|') AS liked_by 
    FROM photos
    
    LEFT JOIN photo_likes
    ON photos.id = photo_likes.photo

    LEFT JOIN users
    ON photo_likes.user = users.id
    GROUP BY id
    ORDER BY uploaded_on DESC
");
$photos = array();
while ($row = $query->fetchobject())
{
    $row->liked_by = $row->liked_by ? explode('|', $row->liked_by) : [];
    $photos[] = $row;
}
// echo '<pre>', print_r($photos, true), '</pre>';
$query = $db->prepare("SELECT * FROM photos ORDER BY uploaded_on DESC");
$query->execute();
$num = $query->rowCount();
$i = 0;
if ($num > 0)
{
    while($line = $query->fetch(PDO::FETCH_ASSOC))
    {
       $imageURL[] = 'uploads/'.$line["file_name"];
    }
        // echo '<pre>', print_r($imageURL, true), '</pre>';
}
else
{
    echo "No image(s) found...";
} 
foreach($photos as $art)
{
    echo 
    $comments = $db->query("SELECT * FROM comments where photo_id = $art->id");
    $rows = $comments->rowCount();
    if ($rows > 0)
    {
        while($line = $comments->fetch(PDO::FETCH_ASSOC))
        {
            $coms[] = $line;
        }
        echo '<pre>', print_r($coms, true), '</pre>';
    }
   
?>
<div class="photos">
    <img width="440px" height="380px" src="<?php echo $imageURL[$i]; ?>" alt="" />
  <a href="like.php?type=photo&id=<?php echo $art->id ?>"> <img src="like.png" id="like"></a>
  <form action="comment.php?id=<?php echo $art->id ?>" method="post">
<textarea name="comment" cols="50" rows="2" placeholder="Enter a comment"></textarea>
<input type="submit" value="post">
</form>
    <p><?php echo $art->likes; ?> people like this</p>
<?php if (!empty($art->liked_by)): ?>
<ul>
    <?php  foreach ($art->liked_by as $user): ?>
     <li>
     <?php
       echo $user; 
      ?>
      </li>
<?php endforeach; ?>
</ul>
<ul>
<?php  foreach ($coms->comment as $com): ?>
     <li>
     <?php
       echo $com; 
      ?>
      </li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<?php $i++ ?>
 <?php } ?>
<div>