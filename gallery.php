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
foreach($photos as $art)
{
    if($num > 0){
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $imageURL = 'uploads/'.$row["file_name"];
?>
<div class="photos">
    <img width="640px" height="480px" src="<?php echo $imageURL; ?>" alt="" />
    <a href="like.php?type=photo&id=<?php echo $art->id ?>">Like</a>
    <p><?php echo $art->likes; ?> people like this</p>
<?php if (!empty($art->liked_by)): ?>
<ul>
    <?php foreach ($art->liked_by as $user): ?>
    <li> <?php echo $user; ?></li>
<?php endforeach;?>
</ul>
<?php endif; ?>

</div>
<?php }
}else{ ?>
    <p>No image(s) found...</p>
<?php } }?>