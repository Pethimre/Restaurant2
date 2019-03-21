<?php 

	session_start();

	require_once "db.php";

	$db = db::get();

	if (isset($_GET["item"])) {
		
		$itemId = $db->escape($_GET["item"]);

		$selectItemProps = "SELECT name,price FROM foods WHERE id =".$itemId;
		
		$selectUserIdQuery = "SELECT id FROM users WHERE username = '".$_SESSION["username"]."'";
		$userObject = $db->getArray($selectUserIdQuery);
		$user;
		
		foreach ($userObject as $user) {
			$user = $user["id"];
		}

		$foodObject = $db->getArray($selectItemProps);
		$quantity = $db->escape($_POST["foodQuantity"]);
		$foodPrice;
		$foodName;
		$subTotal = 0;

		foreach ($foodObject as $food) {
			$foodName = $food["name"];
		 	$foodPrice = intval($food["price"]);
		 }

		$subTotal = $foodPrice * $quantity;

		$addToChartQuery = "INSERT INTO `cart` (`id`, `food_id`, `user_id`, `quantity`, `subtotal`, `status`) VALUES (NULL, '".$itemId."', '".$user."', '".$quantity."', '".$subTotal."', 'cart')";
		$db->query($addToChartQuery);
		#echo "<script>window.location.href='../index.php'</script>";
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

 ?>