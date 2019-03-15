<?php 
      require_once "db.php";
      error_reporting(E_ALL & ~E_ALL);
      session_start(); //i know that its started multiple times, but its only working this way
      $db = db::get();

      if (isset($_POST["updateWorker"])) {

        $selectUserPw = "SELECT password, role_id FROM users WHERE username ='".$_SESSION["username"]."'";
        $result = $db->getArray($selectUserPw);

        $password = "";
        $role = "";
        $routing = "";

        foreach ($result as $element) {
          $password = $element["password"];
          $role = $element["role_id"];
        }

        switch ($role) {
          case '4':
            $routing = "2";
            break;

          case '5':
            $routing = "3";
            break;
          
          default:
            # code...
            break;
        }

        $email = $db->escape($_POST["email"]);
        $newPw = $db->escape($_POST["newPassword"]);
        $confNewPw = $db->escape($_POST["confirmNewPassword"]);
        $phone = $db->escape($_POST["phoneNo"]);
        $passwordEntered = $db->escape($_POST["password"]);
        $passwordConf = $user["password"]; //hashed value already
        $inCaseOfOk = "done";

        if (md5($passwordEntered) == $password) {

          if (!empty($newPw) || !empty($confNewPw)) {
            if (empty($newPw)) {
              echo "<script>window.location.href='worker".$routing.".php?error=newPw';</script>";
            }
            elseif (empty($confNewPw)) {
              echo "<script>window.location.href='worker".$routing.".php?error=confNewPw';</script>";
            }

            else
            {
              if ($newPw == $confNewPw) {
                $newPw = md5($newPw);
                $updatePwQuery = "UPDATE `users` SET `password` = '$newPw' WHERE `users`.`username` = '".$_SESSION["username"]."'";
                $updatePW = $db->query($updatePwQuery);
                $inCaseOfOk .= "Pw";
              }
              else
              {
                echo "<script>window.location.href='worker".$routing.".php?error=noMatch';</script>";
              }
            }

          }

          if (!empty($email) && !empty($phone) && !empty($passwordEntered)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
              $updateQuery = "UPDATE `users` SET `email` = '$email', `PhoneNo` = '$phone ' WHERE `users`.`username` = '".$_SESSION["username"]."'";
              $update = $db->query($updateQuery);
               echo "<script>window.location.href='worker".$routing.".php?success=".$inCaseOfOk."';</script>";
            } else {
              echo "<script>window.location.href='worker".$routing.".php?error=wrongEmail';</script>";
            }
            
          }
          else
          {
            echo "<script>window.location.href='worker".$routing.".php?error=empty';</script>";
          }
        }
        else
        {
          echo "<script>window.location.href='worker".$routing.".php?error=wrongPw';</script>";
        }
      }
     ?>