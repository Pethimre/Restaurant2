<?php 
        require_once "db.php";
        $db = db::get();

        $id = $db->escape($_POST["workid"]);
        $role_id = $db->escape($_POST["selectrole"]);

        $updateQuery = "UPDATE `users` SET `role_id` = ".$role_id." WHERE `users`.`id` =".(int)$id;
        $db->query($updateQuery);

        echo "<script>window.location.href='admin.php';</script>";
?>