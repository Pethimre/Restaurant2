<?php
    if(isset($_GET["item"]))
    {
        require_once "db.php";
        $db = db::get();
        $id = $db->escape($_GET["item"]);
        $id = (int)$id;

        $conn = mysqli_connect("localhost", "root", "", "restaurant");

        $deleteRev = "DELETE FROM `wrappers` WHERE `wrappers`.`id` ='" .$id ."'";
        $db->query($deleteRev); 

        mysqli_close($conn);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    else
    {
            echo "Unexpected..";
    }
?>