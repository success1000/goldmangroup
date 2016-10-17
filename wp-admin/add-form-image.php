<?php 

echo "<br/>Almost done.  One more step and you'll be added to the community.  Let's load an logo for your listing.<br/><br/>";

date_default_timezone_set("America/New_York");
get_currentuserinfo();
	  
$today = date("Y-m-d H:i:s");
$today1 = date("H-i-s");

$com_ID = $_GET['id'];

$target_dir = "wp-content/uploads/logos/";
$target_file = $target_dir . $today1 . "-" . basename($_FILES["fileToUpload"]["name"]);

$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<span style=\"color: #ff0000;\">File is not an image.&nbsp;&nbsp;</span>";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "<span style=\"color: #ff0000;\">Sorry, file already exists.&nbsp;&nbsp;</span>";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "<span style=\"color: #ff0000;\">Sorry, your file is too large.&nbsp;&nbsp;</span>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "<span style=\"color: #ff0000;\">Sorry, only JPG, JPEG, PNG & GIF files are allowed.&nbsp;&nbsp;</span>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "<span style=\"color: #ff0000;\">Your file was not uploaded.<br/><br/></span>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		echo "The file ". $today1 . "-" . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
    } else {
        echo "<span style=\"color: #ff0000;\">Sorry, there was an error uploading your file.</span>";
    }
}

require 'connect.php';

if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}

//SUBMIT IMAGE TO COMPANY
	
$sql = "UPDATE wp_bp_company SET com_image='" . $target_file . "' WHERE com_UserID = '" . $com_ID . "'";

$retval = mysql_query( $sql, $conn );
if(! $retval)
{
  die('Could not enter data: ' . mysql_error());
};

if(isset($_POST['submit'])) {
header('Location: http://www.startupstowatch.com/wp-admin/company-edit.php?uid=' . $com_ID);
}
//////////////////////////// END ADD to DATABASE

echo '<form action="" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>';


?>