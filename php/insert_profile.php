<?php
session_start();
include_once "profile.php";
if(!(isset($_SESSION["username"]))){header("location: ../index.php");}
$errors = array();

$db = mysqli_connect('localhost', 'root', '', 'restaurant');

if (isset($_POST['submit'])) 
{

  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $fullName = mysqli_real_escape_string($db, $_POST['fullName']);
  $BillingAddr = mysqli_real_escape_string($db, $_POST['BillingAddr']);
  $ShippingAddr = mysqli_real_escape_string($db, $_POST['ShippingAddr']);
  $phoneNo = mysqli_real_escape_string($db, $_POST['phoneNo']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  $passhash = md5($password);
  $_SESSION["success"] = "";

  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($fullName)) { array_push($errors, "Full Name is required"); }
  if (empty($BillingAddr)) { array_push($errors, "Billing address is required"); }
  if (empty($ShippingAddr)) { array_push($errors, "Shipping address is required"); }
  if (empty($phoneNo)) { array_push($errors, "Phone number is required"); }
  if (empty($fullName)) { array_push($errors, "Password is required"); }

      $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
      $result = mysqli_query($db, $user_check_query);
      $userCheck = mysqli_fetch_assoc($result);
      
      if ($userCheck) { // if user exists
        if ($userCheck['username'] === $username) {
          array_push($errors, "Username already exists");
        }

        if ($userCheck['email'] === $email) {
          array_push($errors, "Email already exists");
        }
      }

      if (count($errors) == 0) 
      {
        //$password = md5($password_1);

        $query = "UPDATE `users` SET `username` = '$username', `email` = '$email', `password` = '$passhash', `Fullname` = '$fullName', `Shipping_addr` = '$ShippingAddr', `Billing_addr` = '$BillingAddr', `PhoneNo` = '$phoneNo' WHERE `users`.`id` =" .$userCheck["id"];
        mysqli_query($db, $query);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "Successful modifications.";
        header('location: profile.php');
      }
    }
?>