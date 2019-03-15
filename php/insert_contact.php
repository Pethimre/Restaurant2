<?php 
	session_start();
	
	require_once "db.php";

	if (isset($_POST["submitContact"])) {
			
		$db = db::get();

		$errors = array();
		$isok = "";
		$name = $db->escape($_POST["contactor"]);
		$email = $db->escape($_POST["concactEmail"]);
		$subject = $db->escape($_POST["subject"]);
		$message = $db->escape($_POST["concactMessage"]);
		$submittedAt = date("Y-m-d");

		if (empty($name) || empty($email) || empty($subject) || empty($message)) {
			array_push($errors, "You must fill all the gaps!");
			//header("location: ../index.php");
		}
		else
		{
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
			{
				array_push($errors, "Invalid email format");
			}

			else
			{
				$insertContactQuery = "INSERT INTO `contacts` (`id`, `name`, `email`, `subject`, `message`, `submitted_at`) VALUES (NULL, '$name', '$email', '$subject', '$message', '$submittedAt')";
				$insertQuery = $db->query($insertContactQuery);
				unset($errors);
				$errors = array();
				$isok = "Ok";
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			}
		}

	}


 ?>