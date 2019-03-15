<?php 
	require_once "db.php";

	if (isset($_POST["addrev"])) {
	
	$db = db::get();

	$url = $_POST["revurl"];
	$title = $db->escape($_POST["revtitle"]);
	$author = $db->escape($_POST["revauthor"]);
	$website = $_POST["revwebsite"];
	$message = $db->escape($_POST["revmessage"]);

		if (!empty($url) || !empty($title) || !empty($author) || !empty($website) || !empty($message)) {
			
			$insertQuery = "INSERT INTO `reviews` (`id`, `title`, `message`, `author`, `website`, `url`) VALUES (NULL, '$title', '$message', '$author', '$website', '$url')";
			$query = $db->query($insertQuery);
			header("admin.php");
		}
		else
		{
			echo "Something unexpected happened. Check if you filled the form correctly and navigate <a href='admin.php'> back</a>";
		}
	}
	
 ?>