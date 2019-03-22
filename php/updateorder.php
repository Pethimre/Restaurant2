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

	if (isset($_GET["order"])) {
		require_once "db.php";
		$db = db::get();
		$order = $db->escape($_GET["order"]);

		$status = $db->escape($_POST["statusUpdate"]);
		$updateOrderQuery = "UPDATE `orders` SET `progress` = '$status' WHERE `orders`.`id` = ".$order;
		$update = $db->query($updateOrderQuery);
		echo "<script>window.location.href='admin.php?success=done'</script>";
	}

 ?>