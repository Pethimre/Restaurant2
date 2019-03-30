<?php 
        require_once "db.php";
        $db = db::get();

        $id = $db->escape($_COOKIE["id"]);
        $forwho = $db->escape($_COOKIE["forwho"]);
        $resdate = $db->escape($_COOKIE["reservedate"]);
        $expire = $db->escape($_COOKIE["expire"]);
        $pepoleNumber = $db->escape($_COOKIE["pepoleno"]);
        $message = $db->escape($_COOKIE["message"]);
        $progress = $db->escape($_COOKIE["progress"]);

        if ($expire == "") {
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
                $updateQuery = "UPDATE `reservations` SET `reserve_date` = '$resdate', `reserve_date_end` = '$expire', `pepoleNo` = '$pepoleNumber', `message` = '$message', `progress` = '$progress' WHERE `reservations`.`id` ='".(int)$id."'";
                $db->query($updateQuery);
       }

        unset($_COOKIE['id']);
        setcookie('id', '', time() - 3600, '/'); // empty value and old timestamp
        unset($_COOKIE['forwho']);
        setcookie('forwho', '', time() - 3600, '/');
        unset($_COOKIE['expire']);
        setcookie('expire', '', time() - 3600, '/');
        unset($_COOKIE['reservedate']);
        setcookie('reservedate', '', time() - 3600, '/');
        unset($_COOKIE['pepoleno']);
        setcookie('pepoleno', '', time() - 3600, '/');
        unset($_COOKIE['message']);
        setcookie('message', '', time() - 3600, '/');
        unset($_COOKIE['progress']);
        setcookie('progress', '', time() - 3600, '/');
 ?>