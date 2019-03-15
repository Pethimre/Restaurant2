<?php

include_once "profile.php";
if(!(isset($_SESSION["username"]))){header("location: ../index.php");}
$errors = array();

$db = mysqli_connect('localhost', 'root', '', 'restaurant');

if (isset($_POST['submit'])) 
{
  $username = $_SESSION["username"];
  $inCaseOfOk = "done";
  $newPw = mysqli_real_escape_string($db,$_POST["newPassword"]);
  $confNewPw = mysqli_real_escape_string($db,$_POST["confirmNewPassword"]);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $fullName = mysqli_real_escape_string($db, $_POST['fullName']);
  $BillingAddr = mysqli_real_escape_string($db, $_POST['BillingAddr']);
  $ShippingAddr = mysqli_real_escape_string($db, $_POST['ShippingAddr']);
  $phoneNo = mysqli_real_escape_string($db, $_POST['phoneNo']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  $passhash = md5($password);

  $target_dir = "../images/profiles/".$username."/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  if (empty($email)) { echo "<script>window.location.href='profile.php?error=emptyEmail';</script>"; $uploadOk = 0;}
  if (empty($BillingAddr)) { echo "<script>window.location.href='profile.php?error=emptyBa';</script>"; $uploadOk = 0;}
  if (empty($ShippingAddr)) { echo "<script>window.location.href='profile.php?error=emptySa';</script>"; $uploadOk = 0;}
  if (empty($phoneNo)) { echo "<script>window.location.href='profile.php?error=emptyPhone';</script>"; $uploadOk = 0;}
  if (empty($fullName)) { echo "<script>window.location.href='profile.php?error=emptyFn';</script>"; $uploadOk = 0;}
 
      $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
      $result = mysqli_query($db, $user_check_query);
      $userCheck = mysqli_fetch_assoc($result);

      foreach($userCheck as $usertmp){ $profilepic = $usertmp["profilepic"]; $passconf = $usertmp["password"];}

      $selectAddressQuery = "SELECT * FROM addresses WHERE username='$username'";
      $addressResult = mysqli_query($db, $selectAddressQuery);
      $addressCheck = mysqli_fetch_assoc($addressResult);
  

  if (!empty(basename($_FILES["fileToUpload"]["name"]))) 
  {
    $imgname = basename($_FILES["fileToUpload"]["name"]);
  }
  else
  {
    $imgname = $profilepic;
  }

 if ($_FILES["fileToUpload"]["size"] > 5000000) 
        {
            echo "<script>window.location.href='profile.php?error=largeImg';</script>";
            $uploadOk = 0;
        }
    // Allow certain file formats
        if (!empty($_POST["fileToUpload"])) {
          if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "bmp") 
          {
            echo "<script>window.location.href='profile.php?error=wrongFileFormat';</script>";
            $uploadOk = 0;
          }
        }
        
    // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) 
        {
            echo "<script>window.location.href='profile.php?error=noUpload';</script>";
    // if everything is ok, try to upload file
        } 
        if ($uploadOk == 1) 
        {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
            {
                $insertQuery = "UPDATE `users` SET `email` = '$email', `password` = '$passhash', `Fullname` = '$fullName', `Shipping_addr` = '$ShippingAddr', `Billing_addr` = '$BillingAddr', `PhoneNo` = '$phoneNo' WHERE `users`.`id` ='" .$userCheck["id"] ."'";
                mysqli_query($db, $insertQuery);
               echo "<script>window.location.href='profile.php?success=done';</script>";
            } 
            else 
            {
              if (!empty($_POST["fileToUpload"])) {
                echo "<script>window.location.href='profile.php?error=noUpload';</script>";
              }
            }
        }

        if ($imgname != $user["profilepic"]) {
          $path = "../images/profiles/".$_SESSION["username"]."/".$user["profilepic"];
          chown($path,0777);
          unlink($path);
        }

        if ($passhash == $passconf && $uploadOk == 1) 
        {
          $pp = "";

          if(!empty($_POST["fileToUpload"])){$pp = "`profilepic` = '$imgname'";}
          
          $query = "UPDATE `users` SET `email` = '$email', `password` = '$passhash', `Fullname` = '$fullName', `PhoneNo` = '$phoneNo', ".$pp." WHERE `users`.`id` ='" .$userCheck["id"] ."'";
          $updateAddressQuery = "UPDATE `addresses` SET `shipping_address` = '$ShippingAddr', `billing_address` = '$BillingAddr' WHERE `addresses`.`username` = '$username'";
          mysqli_query($db, $query);
          mysqli_query($db, $updateAddressQuery);

          if (!empty($newPw) || !empty($confNewPw)) {
            if (empty($newPw)) {
              echo "<script>window.location.href='profile.php?error=newPw';</script>";
            }
            elseif (empty($confNewPw)) {
              echo "<script>window.location.href='profile.php?error=confNewPw';</script>";
            }

            else
            {
              if ($newPw == $confNewPw) {
                $newPw = md5($newPw);
                $updatePwQuery = "UPDATE `users` SET `password` = '$newPw' WHERE `users`.`username` = '".$_SESSION["username"]."'";
                $updatePW = $db->query($updatePwQuery);
                $inCaseOfOk .= "Pw";
                echo "<script>window.location.href='profile.php?success=".$inCaseOfOk."';</script>";
              }
              else
              {
                echo "<script>window.location.href='profile.php?error=noMatch';</script>";
              }
            }

          }

          echo "<script>window.location.href='profile.php?success=".$inCaseOfOk."';</script>";
        }
        else
        {
          #echo "<script>window.location.href='profile.php?error=wrongPw';</script>";
        }

    }
?>