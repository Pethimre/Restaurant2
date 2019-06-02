<?php 
    if (isset($_REQUEST)) {
        
        require_once "db.php";
        $db = db::get();

        $id = $db->escape($_POST["id"]);
        $expire = $db->escape($_POST["expire"]);
        $pepoleNumber = $db->escape($_POST["pepoleno"]);
        $message = $db->escape($_POST["message"]);
        $progress = $db->escape($_POST["progress"]);

        /*if ($expire == "") {
                $keepExpireQuery = "SELECT reserve_date_end FROM reservations WHERE id =".$id;
                $keepExpire = $db->getArray($keepExpireQuery);
                foreach($keepExpire as $kExpire){$expire = $kExpire["reserve_date_end"];}
        }

        if ($resdate == "") {
                $keepResdateQuery = "SELECT reserve_date FROM reservations WHERE id =".$id;
                $keepResdate = $db->getArray($keepResdateQuery);
                foreach($keepResdate as $kResdate){$resdate = $kResdate["reserve_date"];}
        }

       if (!empty($expire) && !empty($resdate)) {
                $updateQuery = "UPDATE `reservations` SET `reserve_date` = '$resdate', `reserve_date_end` = '$expire', `pepoleNo` = '$pepoleNumber', `message` = '$message', `progress` = '$progress' WHERE `reservations`.`id` ='".(int)$id."'"; echo "<script>alert(".$updateQuery.");</script>";
                $db->query($updateQuery);
       }*/
    }
 ?>