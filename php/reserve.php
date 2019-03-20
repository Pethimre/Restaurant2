<?php 
	session_start();

if (isset($_POST["submit"])) {

	$conn = mysqli_connect("localhost", "root", "", "restaurant");

	$reservedate = new DateTime($_POST["reserve_date"]);
	$reservedate->format('Y-m-d H:i:s');

	$endReserve = (new DateTime($_POST["reserve_date"]))->modify('+2 hour')->format('Y-m-d H:i:s');

	$forwho = mysqli_real_escape_string($conn, $_POST["forwho"]);
	$phone = mysqli_real_escape_string($conn, $_POST["phone"]);
	$email = mysqli_real_escape_string($conn, $_POST["email"]);
	$pepolenumber = mysqli_real_escape_string($conn, $_POST["numberofpepole"]);
	$pepolenumber = (int)$pepolenumber;
	$message = mysqli_real_escape_string($conn, $_POST["message"]);
	$bookedat = date("Y-m-d");
	$now = date('Y-m-d H:i:s');
	$tableNumber = mysqli_real_escape_string($conn, $_POST["tableNumber"]);

	if (empty($reservedate) || empty($phone) || empty($email) || empty($reservedate) || empty($forwho) || empty($pepolenumber)) 
	{
		echo "<script>alert('You need to fill everything, except message!');</script>";
	}
	elseif ($pepolenumber > 20) {
		echo "Our biggest table can hosts 20 people. If you need more space, contact us and ask for event booking.";
	}
	else
	{	
		if(empty($message)){$message = "No message  given.";}

			$userid = 9; //basically, you are booking as a quest if you not logged in

			if (isset($_SESSION["username"])) 
			{

				$user = $_SESSION["username"];
				$selectString = "SELECT id FROM users WHERE username = '".$user."'";
				$selectQuery = mysqli_query($conn, $selectString);
				$userstuff = mysqli_fetch_assoc($selectQuery);
				$userid = $userstuff["id"];
			}

			if ($now < $reservedate) {echo "<script>alert('Your date has already been passed.');</script>";}

			else
			{
				$insertString = "INSERT INTO `reservations` (`id`, `forWho`, `reserve_date`, `reserve_date_end`, `tableNo`, `pepoleNo`, `message`, `progress`, `user_id`, `bookedat`, `table_id`) VALUES (NULL, '$forwho', '".date_format($reservedate, 'Y-m-d H:i:s')."', '".date_format($endReserve, 'Y-m-d H:i:s')."', '$tableNumber', '$pepolenumber', '$message', 'open', '$userid', '$bookedat', '$tableNumber')";
				mysqli_query($conn, $insertString);
				header("location: ../index.php");
			}

		}

	}
	
 ?>