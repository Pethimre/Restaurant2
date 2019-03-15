 <?php  
 $connect = mysqli_connect("localhost", "root", "", "restaurant");  
 if(!empty($_POST))  
 {  
      $forWho = mysqli_real_escape_string($connect, $_POST["forwho"]);  
      $reservedate = mysqli_real_escape_string($connect, $_POST["reservedate"]);  
      $pepoleNo = mysqli_real_escape_string($connect, $_POST["pepoleNo"]);  
      $message = mysqli_real_escape_string($connect, $_POST["message"]);  
      $progress = mysqli_real_escape_string($connect, $_POST["progress"]);  

      $query = "UPDATE `reservations` SET `reserve_date` = '$reservedate', `pepoleNo` = '$pepoleNo', `message` = '$message', `progress` = '$progress' WHERE `reservations`.`id` =".$_POST["resid"]."'";
      $qex = mysqli_query($connect, $query);
 }  
 ?>