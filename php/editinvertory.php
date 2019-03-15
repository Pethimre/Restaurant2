<?php 
session_start(); //i know that its started multiple times, but its only working this way
error_reporting(E_ALL & ~E_ALL);
require_once "db.php";
$db = db::get();

if (isset($_POST["updateINvItem"])) {
	if (isset($_COOKIE["wrapperid"])) {
		$id = $db->escape($_COOKIE["wrapperid"]);
		$wrapperid = $db->escape($_COOKIE["wrapperid"]);
		$wrapperName = $db->escape($_COOKIE["wrapperName"]);
		$wrapperQuantity = $db->escape($_COOKIE["wrapperQuantity"]);
		$InvUpdatedBy = $db->escape($_SESSION["username"]);
		$InvUpdated_at = date("Y-m-d");

		$updateQuery = "UPDATE `wrappers` SET `wrappername` = '$wrapperName ', `quantity` = '$wrapperQuantity ', `updated_at` = '$InvUpdated_at', `last_update_by` = '$InvUpdatedBy' WHERE `wrappers`.`id` =".(int)$id;
		$db->query($updateQuery);

		$selectUserPw = "SELECT role_id FROM users WHERE username ='".$_SESSION["username"]."'";
        $result = $db->getArray($selectUserPw);

        $role = "";
        $routing = "";

        foreach ($result as $element) {
          $role = $element["role_id"];
        }

        switch ($role) {
          case '1':
            header("location: admin.php");
            break;

          case '5':
            header("location: worker3.php");
            break;
          
          default:
            # code...
            break;
        }
	}
}




?>