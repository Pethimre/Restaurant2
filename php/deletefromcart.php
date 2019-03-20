<?php 
session_start();

if (isset($_GET["item"])) {

	require_once "db.php";

	$db = db::get();
	$id = $db->escape($_GET["item"]);
	$getUseridQuery = "SELECT id FROM users WHERE username ='".$_SESSION["username"]."'";
	$getUserid = $db->getArray($getUseridQuery);

	foreach ($getUserid as $user) {
		$userid = $user["id"];
	}

	$deleteFromCartQuery = "DELETE FROM cart WHERE user_id =".$userid." AND id=".$id;
	$delete = $db->query($deleteFromCartQuery);
	header('Location: ' . $_SERVER['HTTP_REFERER']);

}
else
{
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>