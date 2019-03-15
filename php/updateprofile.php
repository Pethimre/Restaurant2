<?php 
      require_once "db.php";
      session_start();
      $db = db::get();

      if (isset($_POST["submit"])) {

        $selectUserPw = "SELECT password FROM users WHERE users.username ='".$_SESSION["username"]."'";
        $result = $db->getArray($selectUserPw);

        foreach($result as $resultTmp){$user["password"] = $resultTmp;}

        $email = $db->escape($_POST["email"]);
        $fullname = $db->escape($_POST["fullName"]);
        $billingaddr = $db->escape($_POST["BillingAddr"]);
        $shippingaddr = $db->escape($_POST["ShippingAddr"]);
       
        $newPw = $db->escape($_POST["newPassword"]);
        $confNewPw = $db->escape($_POST["confirmNewPassword"]);
        $phone = $db->escape($_POST["phoneNo"]);
        $passwordEntered = $db->escape($_POST["password"]);
        $passwordConf = $user["password"]; //hashed value already
        $inCaseOfOk = "done";

        $value = array_shift($passwordConf);

        if (md5($passwordEntered) == $value) {

          if (!empty($newPw) || !empty($confNewPw)) {
            if (empty($newPw)) {
              echo "<script>window.location.href='profile.php?error=newPw';</script>";
            }
            elseif (empty($confNewPw)) {
              echo "<script>window.location.href='profile.php?error=confNewPw';</script>";
            }

            else
            {
              if ($newPw == $confNewPw) {
                $newPw = md5($newPw);
                $updatePwQuery = "UPDATE `users` SET `password` = '$newPw' WHERE `users`.`username` = '".$_SESSION["username"]."'";
                $updatePW = $db->query($updatePwQuery);
                $inCaseOfOk .= "Pw";
                echo "<script>window.location.href='profile.php?success=".$inCaseOfOk."';</script>";
              }
              else
              {
                echo "<script>window.location.href='profile.php?error=noMatch';</script>";
              }
            }

          }

          if (!empty($email) && !empty($phone) && !empty($passwordEntered)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
              $userUpdateQuery = "UPDATE `users` SET `email` = '$email', `Fullname` = '$fullname', `PhoneNo` = '$phone' WHERE `users`.`username` = '".$_SESSION["username"]."'";
              $addressUpdateQuery = "UPDATE `addresses` SET `shipping_address` = '$shippingaddr', `billing_address` = '$billingaddr' WHERE `addresses`.`username` = '$username'";
            $updateUser = $db->query($userUpdateQuery);
            $updateAddr = $db->query($addressUpdateQuery);
            echo "<script>window.location.href='profile.php?success=".$inCaseOfOk."';</script>";
            } else {
              echo "<script>window.location.href='profile.php?error=wrongEmail';</script>";
            }
            
          }
          else
          {
            echo "<script>window.location.href='profile.php?error=empty';</script>";
          }
        }
        else
        {
          echo "<script>window.location.href='profile.php?error=wrongPw';</script>";
        }
      }
     ?>