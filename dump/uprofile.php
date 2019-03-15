<?php
session_start();
require_once "db.php";
$db = db::get();

$selectUser = "SELECT * FROM users WHERE username='".$_SESSION["username"]."'";
$wtf = $db->getArray($selectUser);

foreach ($wtf as $kek) {
  $profilePicture = $kek["profilepic"];
  $userid = $kek["id"];
}var_dump($kek);

if (isset($_POST["uploadProfile"])) {
  $target_dir = "../images/profiles/".$_SESSION["username"]."/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imgname = "";
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  if (!empty(basename($_FILES["fileToUpload"]["name"]))) 
  {
    $imgname = basename($_FILES["fileToUpload"]["name"]);
  }
  else
  {
    $imgname = $profilePicture;
  }

  if ($imgname != $profilePicture) {
    $path = "../images/profiles/".$_SESSION["username"]."/".$profilePicture;
    chown($path,0777);
    unlink($path);
  }
  

// Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  }
// Check file size
  if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }
// Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";var_dump($imgname);
  $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    header("location: profile.php");
  } else {
    echo "Sorry, there was an error uploading your file.";var_dump($imageFileType);
  }
}

$updateprofilePictureQuery = "UPDATE `users` SET `profilepic` = '$imgname' WHERE `users`.`id` = ".(int)$userid;
$update = $db->query($updateprofilePictureQuery);

}
?>