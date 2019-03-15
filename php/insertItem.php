<?php 
session_start();
require_once "db.php";

$db = db::get();

	if (isset($_POST["addInvItem"])) {
		$wname = $db->escape($_POST["wrname"]);
		$wrquantity = $db->escape($_POST["wrquantity"]);
		$uat = date("Y-m-d\TH:i:sP");
		$luby = $db->escape($_SESSION["username"]);

		$insert = "INSERT INTO `wrappers` (`id`, `wrappername`, `quantity`, `updated_at`, `last_update_by`) VALUES (NULL, '$wname', '$wrquantity', '$uat', '$luby')";
		$insertinvitem = $db->query($insert);
		
		header("location: admin.php");
	}
?>