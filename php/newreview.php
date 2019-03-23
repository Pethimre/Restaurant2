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
			echo "<script>window.location.href='admin.php?success=done'</script>";
		}
		else
		{
			echo "<script>window.location.href='admin.php?error=unexpected'</script>";
		}
	}
	
 ?>