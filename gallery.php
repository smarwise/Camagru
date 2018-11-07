<head>
	<link rel="stylesheet"  href="gallery.css">
</head>
<?php
// require_once("navbar.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("config/database.php");
require_once("config/setup.php");
$db->query("USE ".$dbname);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perpage = 5;
$start = ($page > 1) ? ($page * $perpage) - $perpage : 0;
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
    limit {$start},{$perpage}
    
");
$photos = array();
while ($row = $query->fetchobject())
{
    $row->liked_by = $row->liked_by ? explode('|', $row->liked_by) : [];
    $photos[] = $row;
}
$query = $db->prepare("SELECT * FROM photos ORDER BY uploaded_on DESC");
$query->execute();
$num = $query->rowCount();

//pages
$total = $num;
$pages = $total % $perpage == 0 ? $total / $perpage : $total / $perpage + 1;
$pages = (int)$pages;
$query = $db->prepare("SELECT * FROM photos ORDER BY uploaded_on DESC limit {$start},{$perpage}");
$query->execute();
$num = $query->rowCount();
$i = 0;
if ($num > 0)
{
    while($line = $query->fetch(PDO::FETCH_ASSOC))
    {
       $imageURL[] = 'uploads/'.$line["file_name"];
    }
}
else
{
    echo "No image(s) found...";
}
$n = 0;
// echo '<pre>' . print_r($photos, true) . '</pre>';
foreach($photos as $art)
{
    if ($n < 5)
    {
        if (!isset($photos[$n]))
             break;
        $comments = $db->prepare("SELECT * FROM comments where photo_id = $art->id");
        $comments->execute();
        $rows = $comments->rowCount();
        $coms = array();
        if ($rows > 0)
        {
            while($line = $comments->fetch(PDO::FETCH_ASSOC))
            {
                $coms[] = $line;
            }
        }
   
?>
<section class="container some_about"><br>
<div class="photos">
    <img width="440px" height="380px" src="<?php echo $imageURL[$i]; ?>" alt="" />
  <a href="like.php?type=photo&id=<?php echo $art->id ?>&page=<?php echo $page ?>"> <img src="like.png" id="like"></a>
  <form action="comment.php?id=<?php echo $art->id ?>&page=<?php echo $page ?>" method="post">
<textarea name="comment" cols="50" rows="2" placeholder="Enter a comment"></textarea>
<input type="submit" value="post">
<a href="delete.php?type=photo&id=<?php echo $art->id ?>">delete</a>
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
<?php endif; ?>
<?php if (!empty($coms[0]["comment"])): ?>
<ul>
    <?php foreach ($coms as $com): ?>
     <li>
     <?php
       echo $com['comment']; 
      ?>
      </li>
<?php endforeach; ?>

</ul>
<?php endif; ?>
<?php $i++ ?>
<?php $n++; } ?>
 <?php } ?>
 <div class="">
  <?php if ($page <= $pages): ?>
    <a href="?page=<?php echo $page-1;?>">previous</a>
    <a href="?page=<?php echo $page+1;?>">next</a>
  <?php endif; ?>
</div>
<div class="space-30"></div>
</section>
<div>