<?php 
require_once "db.php";
$db = db::get();

if (isset($_GET["worker"])) {
	$username = $db->escape($_GET["worker"]);
	$newpw = md5($username);

	$updateQuery = "UPDATE `users` SET `password` = '$newpw' WHERE `users`.`username` ='$username'";
	$db->query($updateQuery);

	echo "<script>window.location.href='admin.php?success=done';</script>";
}
?>