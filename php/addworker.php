<?php 

	require_once "db.php";
	include_once "admin.php";

	$db = db::get();

	if (isset($_POST["addworker"])) {
		$email = $db->escape($_POST["email"]);
		$phone = $db->escape($_POST["phone"]);
		$fullName = $db->escape($_POST["fullName"]);
		$roleid = $_POST["selectrole"];
		$username = $db->escape($_POST["username"]);
		$beginnerpassword = md5($username);

		if (!empty($email) || !empty($fullName) || !empty($role) || !empty($roleid) || !empty($username))
		{
			$selectInsertQuery = "INSERT INTO `users` (`id`, `username`, `email`, `password`, `Fullname`, `PhoneNo`, `profilepic`, `role_id`) VALUES (NULL, '".$username."', '".$email."', '".$beginnerpassword."', '".$fullName."', '$phone',NULL, '".$roleid."')";
			$query = $db->query($selectInsertQuery);
			echo "<script>window.location.href='admin.php';</script>";
		}
	}
 ?>