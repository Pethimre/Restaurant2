<?php
session_start();

$username = "";
$email    = "";
$errors = array(); 

$db = mysqli_connect('localhost', 'root', '', 'restaurant');

// REGISTER
if (isset($_POST['reg_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['new_username']);
  $email = mysqli_real_escape_string($db, $_POST['new_email']);
  $phoneNumber = mysqli_real_escape_string($db, $_POST['phoneNumber']);
  $fullname = mysqli_real_escape_string($db, $_POST['fullName']);
  $billingAddr = mysqli_real_escape_string($db, $_POST['billingAddr']);
  $shppingAddr = mysqli_real_escape_string($db, $_POST['shppingAddr']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password2']);

  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($phoneNumber)) { array_push($errors, "Phone Number is required"); }
  if (empty($fullname)) { array_push($errors, "Full Name is required"); }
  if (empty($billingAddr)) { array_push($errors, "Billing Addresss is required"); }
  if (empty($shppingAddr)) { array_push($errors, "Shipping Addresss is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) { array_push($errors, "The two passwords do not match"); }

  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    #echo("$email is a valid email address");
  } else {
    array_push($errors, "This is not a valid email address");
  }

  if (count($errors) == 0) {
  	$password = md5($password_1);

  	$query = "INSERT INTO `users` (`id`, `username`, `email`, `password`, `Fullname`, `PhoneNo`, `profilepic`, `role_id`) VALUES (NULL, '$username', '$email', '$password', '$fullname', '$phoneNumber', NULL, '2')";
    $addressQuery = "INSERT INTO `addresses` (`id`, `shipping_address`, `billing_address`, `username`) VALUES (NULL, '$shppingAddr', '$billingAddr', '$username');";
  	mysqli_query($db, $query);
    mysqli_query($db, $addressQuery);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
    mkdir('images/profiles/'.$username, 0777, true);
  	header('location: index.php');
  }
}

if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
    array_push($errors, "Username is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    $password = md5($password);
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
      $_SESSION['username'] = $username;
      $_SESSION['success'] = "You are now logged in";
      header('location: index.php');
    }else {
      array_push($errors, "Wrong username/password combination");
    }
  }
}

?>