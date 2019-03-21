<html>
<head>
	<meta charset="UTF-8">
	<title>Insertkek</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">
	<script src="js/jquery-1.11.2.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>
<body bgcolor="stevenseagal" class="container" style="margin-top: 7%;">
	<form action="" method="POST">
		<button name="startkek">start keking</button>
		<button name="debug">debug</button>
		<input type="number" name="numberofkeks">
	</form>
	<form action="" method="post">
		
		<input type="datetime-local" datetime-format="Y-m-d h-i-s" name="datetimepick">
		<button name="test">test datetime</button>
	</form>
	
</body>
</html>
<?php 
	
	if (isset($_POST["test"])) {
		$var = (new DateTime($_POST["datetimepick"]))->modify('+1 hour')->format('Y-m-d H:i:s');
		echo $var;
	}

if (isset($_POST["startkek"])) {

	$conn = mysqli_connect("localhost", "root", "", "restaurant");
	$numkek = mysqli_real_escape_string($conn, $_POST["numberofkeks"]) + 1;

	for ($i=1; $i < $numkek; $i++) { 
		$name = "webshopitem".$i;
		$insertQuery = "INSERT INTO `kek` (`id`, `name`) VALUES (NULL, '$name')";
		$query = mysqli_query($conn,$insertQuery);
	}
	echo "Done!";

}

if (isset($_POST["debug"])) {
	require_once "php/db.php";
	$db = db::get();

    $selectNumPages = "SELECT COUNT(id) FROM kek";
    $dump = $db->query($selectNumPages);

	$kek = var_dump($dump);	
	echo $kek;
}
 ?>