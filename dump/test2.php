<html>
<head>
	<meta charset="UTF-8">
	<title>test2</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	<?php 
		include_once "php/db.php";
		include_once "paginator.php";
		$db = db::get();
		$currentPage = 1;
		$selectQuery = "SELECT * FROM kek";
		$numberOfRows = $db->numrows($selectQuery);

		$pg = new Paginator($numberOfRows, $currentPage);

		echo $pg->getPaginator();
	 ?>
</body>
</html>