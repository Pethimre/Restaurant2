<?php 
	/* Prevent Caching */
	  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	  header("Cache-Control: post-check=0, pre-check=0", false);
	  header("Pragma: no-cache");

	$userid = $_COOKIE["userid"];
    $conn = mysqli_connect("localhost", "root", "", "restaurant");

    $selectUsernameQuery = "SELECT username FROM users WHERE id='".$userid."'";
    $query = mysqli_query($conn, $selectUsernameQuery);
    $result = mysqli_fetch_assoc($query);
    
 ?>
 <html>
 <head>
 	<meta charset="UTF-8">
 	<title>userid</title>
 </head>
 <body>
 	<?php echo $result["username"]; ?>
 </body>
 </html>