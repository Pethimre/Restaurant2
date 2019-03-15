<?php 
  session_start();

  require_once "db.php";
  
  if (($_SESSION["username"])) 
  {
    $db = db::get();

    $routingQuery = "SELECT role_id FROM users WHERE username ='".$_SESSION["username"]."'";
    $routing = $db->query($routingQuery);
    foreach($routing as $routmp){$roles=$routmp;}
    $role = $roles["role_id"];
    $role = (int)$role;

    switch ($role) {
        case 1:
        header("location: admin.php"); //admin role
         break;

      case 2:
        header("location: ../index.php"); //user role
        break;

      case 3:
        header("location: worker.php"); //receotionist role
        break;

      case 4:
        header("location: worker2.php"); //courier role
        break;

      case 5:
        header("location: worker3.php"); //waiter role
        break;
      
      default:
        header("location: ../index.php");
        break;
    }
  }
  else
  {
    header("location: ../index.php");
  }

 ?>