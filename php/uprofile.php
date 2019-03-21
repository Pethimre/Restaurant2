<?php
session_start();
require_once "db.php";
$db = db::get();

$selectUser = "SELECT * FROM users WHERE username='".$_SESSION["username"]."'";
$wtf = $db->getArray($selectUser);

foreach ($wtf as $kek) {
  $profilePicture = $kek["profilepic"];
  $userid = $kek["id"];
}

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
  if(isset($_POST["uploadProfile"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
      $uploadOk = 1;
    } else {
      $uploadOk = 0;
    }
  }
// Check file size
  if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "<script>window.location.href='profile.php?error=largeImg';</script>";
    $uploadOk = 0;
  }
// Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "<script>window.location.href='profile.php?error=wrongFileFormaton';</script>";
  $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 1) {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $updateprofilePictureQuery = "UPDATE `users` SET `profilepic` = '$imgname' WHERE `users`.`id` = ".(int)$userid;
    $update = $db->query($updateprofilePictureQuery);
    var_dump($updateprofilePictureQuery);
    echo "<script>window.location.href='profile.php?success=done';</script>";
  } else {
    echo "<script>window.location.href='profile.php?error=noUpload';</script>";
  }

} else {
  echo "<script>window.location.href='profile.php?error=noUpload';</script>";
}

}
?>