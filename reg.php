<?php
session_start();
#error_reporting(E_ALL & ~E_NOTICE); //Hide php notifications on the page

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

  if (empty($username)) {echo "<script>window.location.href='register.php?result=noUser'</script>";}
  if (empty($phoneNumber)) {echo "<script>window.location.href='register.php?result=noPN'</script>";}
  if (empty($fullname)) {echo "<script>window.location.href='register.php?result=noFN'</script>";}
  if (empty($billingAddr)) {echo "<script>window.location.href='register.php?result=noBA'</script>";}
  if (empty($shppingAddr)) {echo "<script>window.location.href='register.php?result=noSA'</script>";}
  if (empty($email)) {echo "<script>window.location.href='register.php?result=noEmail'</script>";}
  if (empty($password_1)) {echo "<script>window.location.href='register.php?result=noPW'</script>";}
  if ($password_1 != $password_2) {echo "<script>window.location.href='register.php?result=noMatch'</script>";}

  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      echo "<script>window.location.href='register.php?result=alUser'</script>";
    }

    if ($user['email'] === $email) {
      echo "<script>window.location.href='register.php?result=alEmail'</script>";
    }
  }

  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
  } else {
    echo "<script>window.location.href='register.php?result=invEmail'</script>";
  }

  if (count($errors) == 0) {
    $uppercase = preg_match('@[A-Z]@', $password_1);
    $lowercase = preg_match('@[a-z]@', $password_1);
    $number    = preg_match('@[0-9]@', $password_1);
    if (!$uppercase || !$lowercase || !$number || strlen($password_1) < 8) {
      echo "<script>window.location.href='register.php?result=weakPW'</script>";
    }
    else
    {
      $password = md5($password_1);

      $query = "INSERT INTO `users` (`id`, `username`, `email`, `password`, `Fullname`, `PhoneNo`, `profilepic`, `role_id`) VALUES (NULL, '$username', '$email', '$password', '$fullname', '$phoneNumber', NULL, '2')";
      $addressQuery = "INSERT INTO `addresses` (`id`, `shipping_address`, `billing_address`, `username`) VALUES (NULL, '$shppingAddr', '$billingAddr', '$username');";
      mysqli_query($db, $query);
      mysqli_query($db, $addressQuery);
      $_SESSION['username'] = $username;
      mkdir('images/profiles/'.$username, 0777, true);
      header('location: index.php');
    }
  	
  }
}

if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
    echo "<script>window.location.href='register.php?result=noUser'</script>";
  }
  if (empty($password)) {
    echo "<script>window.location.href='register.php?result=noPW'</script>";
  }

  if (count($errors) == 0) {
    $password = md5($password);
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
      $_SESSION['username'] = $username;
      header('location: index.php');
    }else {
      echo "<script>window.location.href='register.php?result=wrongPW'</script>";
    }
  }
}

?>