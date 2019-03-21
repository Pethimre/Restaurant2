<?php 
	if (isset($_GET["item"])) {
		require_once "db.php";
		$db = db::get();
		$item = $db->escape($_GET["item"]);

		$status = $db->escape($_POST["statusUpdate"]);
		$updateOrderQuery = "UPDATE `orders` SET `progress` = '$status' WHERE `orders`.`id` = ".$item;
		$update = $db->query($updateOrderQuery);
		echo "<script>window.location.href='worker2.php?success=done'</script>";
	}
	else
	{
		echo "<script>window.location.href='worker2.php?error=error'</script>";
	}
 ?>