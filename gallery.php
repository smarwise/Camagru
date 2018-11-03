<?php
// Include the database configuration file
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("config/database.php");
require_once("config/setup.php");
// Get images from the database
$db->query("USE ".$dbname);
$query = $db->prepare("SELECT * FROM photos ORDER BY uploaded_on DESC");
$query->execute();
$num = $query->rowCount();
if($num > 0){
    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        $imageURL = 'uploads/'.$row["file_name"];
?>
    <img width="500px" height="300px" src="<?php echo $imageURL; ?>" alt="" />
<?php }
}else{ ?>
    <p>No image(s) found...</p>
<?php } ?>