<html>
<head>
	<meta charset="UTF-8">
	<title>Insertkek</title>
</head>
<body bgcolor="stevenseagal">
	<form action="" method="POST">
		<button name="startkek">start keking</button>
		<button name="debug">debug</button>
		<input type="number" name="numberofkeks">
	</form>
</body>
</html>
<?php 
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