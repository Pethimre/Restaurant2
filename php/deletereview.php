<?php
    if(isset($_GET["delete"]))
    {
        require_once "db.php";
        $db = db::get();
        $id = $db->escape($_GET["delete"]);
        $id = (int)$id;

        $conn = mysqli_connect("localhost", "root", "", "restaurant");

        $deleteRev = "DELETE FROM `reviews` WHERE `reviews`.`id` ='" .$id ."'";
        $db->query($deleteRev); 

        mysqli_close($conn);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    else
    {
            echo "Unexpected..";
    }
?>