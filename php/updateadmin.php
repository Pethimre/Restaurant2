<?php 
	session_start();

	if ($_SESSION["username"] == "admin") {
		if (isset($_POST["setNewPassword"])) {
			require_once "db.php";
			$db = db::get();

			$currentPasword = $db->escape($_POST["currentPasword"]);
			$newPassword = $db->escape($_POST["newPassword"]);
			$newPassword2 = $db->escape($_POST["newPassword2"]);

			$validateAdminDataQuery = "SELECT password FROM users WHERE username = 'admin'";
			$validateAdminData = $db->getArray($validateAdminDataQuery);

			foreach ($validateAdminData as $admin) {
				$confirmPassword = $admin["password"];
			}

			if ($confirmPassword == md5($currentPasword)) {
				if($newPassword == $newPassword2)
				{
					$newPassword = md5($newPassword2);
					$updatePasswordQuery = "UPDATE `users` SET `password` = '$newPassword' WHERE `users`.username = 'admin'";
					$update = $db->query($updatePasswordQuery);

					echo "<script>window.location.href='admin.php?success=done'</script>";
				}
				else
				{
					echo "<script>window.location.href='admin.php?error=noMatch'</script>";
				}
			}
			else
			{
				echo "<script>window.location.href='admin.php?error=wrongPW'</script>";
			}
		}	
	}

 ?>