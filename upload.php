<form action="upload.php" method="post" enctype="multipart/form-data">
    Select Image File to Upload:
    <input type="file" name="file">
    <input type="submit" name="submit" value="Upload">
</form>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("config/database.php");
require_once("config/setup.php");
$statusMsg = '';
$db->query("USE ".$dbname);
$targetDir = "uploads/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
if (isset($_POST["submit"]) && !empty($_FILES["file"]["name"]))
{
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if (in_array($fileType, $allowTypes))
    {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath))
        {
            $query = "INSERT into photos (file_name, uploaded_on) VALUES (:name, NOW())";
            $stmt = $db->prepare( $query );
            $stmt->bindParam(':name', $fileName);
            $insert = $stmt->execute();
            if ($insert)
            {
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
            }
            else
            {
                $statusMsg = "File upload failed, please try again.";
            } 
        }
        else
        {
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }
    else
    {
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}
else
{
    $statusMsg = 'Please select a file to upload.';
}
echo $statusMsg;
?>