<?php 
	session_start();
	error_reporting(E_ALL & ~E_ALL); //Hide php notifications on the page
	require_once "db.php";

	$db = db::get();

if (isset($_POST["submit"])) {

	$hour = 7;
    $minute = 0;
    $testDate = date("H:i:s", strtotime("$hour:$minute"));

    $hour2 = 21;
    $minute2 = 0;
    $testDate2 = date("H:i:s", strtotime("$hour2:$minute2"));

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

	if (empty($reservedate) || empty($phone) || empty($email) || empty($forwho) || empty($pepolenumber)) 
	{
		echo "<script>window.location.href='../index.php?error=empty';</script>";
	}
	elseif ($pepolenumber > 20) {
		echo "<script>window.location.href='../index.php?error=big';</script>";
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

			if ($now > date_format($reservedate, "Y-m-d H:i:s")) {echo "<script>window.location.href='../index.php?error=wrongDate';</script>";}

			else
			{
				if ($testDate2 > date_format($reservedate, 'H:i:s') && $testDate < date_format($reservedate, 'H:i:s')) {
					$selectReservedTablesThenQuery = "SELECT reservations.table_id FROM reservations WHERE reservations.reserve_date <= '".date_format($reservedate, 'Y-m-d H:i:s')."' AND reserve_date_end >= '".date_format($endReserve, 'Y-m-d H:i:s')."'";
					$reservedTablesThen = $db->getArray($selectReservedTablesThenQuery);
					$reservedThen = array();

					foreach ($reservedTablesThen as $tables) {
						array_push($reservedThen, intval($tables["table_id"]));
					}

					if (!(in_array($tableNumber, $reservedThen))) {
						require_once "db.php";
						$db = db::get();

						$selectNumberOfPepoleQuery = "SELECT space FROM tables WHERE id =".$tableNumber;
						$NumberOfHostedPepole = $db->getArray($selectNumberOfPepoleQuery);

						foreach ($NumberOfHostedPepole as $hosted) {
							$space = intval($hosted["space"]);
						}

						if($space >= $pepolenumber)
						{
							$insertString = "INSERT INTO `reservations` (`id`, `forWho`, `reserve_date`, `reserve_date_end`, `pepoleNo`, `message`, `progress`, `user_id`, `bookedat`, `table_id`) VALUES (NULL, '$forwho', '".date_format($reservedate, 'Y-m-d H:i:s')."', '".$endReserve."', '$pepolenumber', '$message', 'open', '$userid', '$bookedat', '$tableNumber')";
							mysqli_query($conn, $insertString);
							header("location: ../index.php?success=thankyou");
						}
						else
						{
							echo "<script>window.location.href='../index.php?error=big';</script>";
						}
						
					}
					else
					{
						echo "<script>window.location.href='../index.php?error=reserved';</script>";
					}
				}

				else
				{
					echo "<script>window.location.href='../index.php?error=closed';</script>";
				}
			}

		}

	}
	
 ?>