<?php 
	session_start();

if (isset($_POST["submit"])) {

	$conn = mysqli_connect("localhost", "root", "", "restaurant");

	$reservedate = $_POST["reserve_date"];
	$endReserve = date('Y-m-d H:i:s',strtotime('+2 hours',strtotime($reservedate)));
	$forwho = mysqli_real_escape_string($conn, $_POST["forwho"]);
	$phone = mysqli_real_escape_string($conn, $_POST["phone"]);
	$email = mysqli_real_escape_string($conn, $_POST["email"]);
	$pepolenumber = mysqli_real_escape_string($conn, $_POST["numberofpepole"]);
	$pepolenumber = (int)$pepolenumber;
	$tableNumber = mysqli_real_escape_string($conn, $_POST["tableNumber"]);
	$tableNumber = (int)$tableNumber;
	$message = mysqli_real_escape_string($conn, $_POST["message"]);
	$bookedat = date("Y.m.d");

	if (empty($reservedate) || empty($phone) || empty($email) || empty($reservedate) || empty($forwho) || empty($pepolenumber)) 
	{
		echo "<script>alert('You need to fill everything, except message!');</script>";
	}
	else
	{		
			if(empty($message)){$message = "No message  given.";}

			$userid = 9;

			if (isset($_SESSION["username"])) 
			{

				$user = $_SESSION["username"];
				$selectString = "SELECT id FROM users WHERE username = '".$user."'";
				$selectQuery = mysqli_query($conn, $selectString);
				$userstuff = mysqli_fetch_assoc($selectQuery);
				$userid = $userstuff["id"];
			}

			$insertString = "INSERT INTO `reservations` (`id`, `forWho`, `reserve_date`, `reserve_date_end`, `pepoleNo`, `message`, `progress`, `user_id`, `bookedat`, `table_id`) 
			VALUES (NULL, 
				'".$forwho."',
				'".$reservedate."',
				'".$endReserve."', 
				'".$pepolenumber."', 
				'".$message."', 
				'open', 
				'".$userid."',
				'".$bookedat."',
				'".$tableNumber."')";
			mysqli_query($conn, $insertString);

			echo "<script>swalert();</script>";

			header("location: ../index.php");

		
		/*else
		{
			echo "<script>alert('Invalid date entered!');</script>";var_dump($reservedate);
		}*/
	}

}
	
 ?>