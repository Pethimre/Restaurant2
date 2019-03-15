<?php 

	require_once "../php/db.php";
	
	$db = db::get();

	$query = "SELECT password, role_id FROM users WHERE username = 'waiter' ";
	$exe = $db->getArray($query);
	#echo "Step 1: ".var_dump($exe)."<br>";
	
	$password = "";
	$role = "";

	foreach ($exe as $element) {
		$password = $element["password"];
		$role = $element["role_id"];
	}

	echo "Step 2: ".var_dump($role);
	echo "Step 3: ".var_dump($password);
	echo $password ."<br>";
	echo $role;

	if ($password == md5("12345")) {
		echo "string";
	}


 ?>