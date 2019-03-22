<?php
    if(isset($_GET["foodid"]))
    {
        require_once "db.php";
        $db = db::get();
        $id = $db->escape($_GET["foodid"]);
        $id = (int)$id;

        $conn = mysqli_connect("localhost", "root", "", "restaurant");

        $sql = "SELECT imgpath FROM foods WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        $name = "";

        if (mysqli_num_rows($result) > 0) 
        {
            while($row = mysqli_fetch_assoc($result)) {
               $name = $row["imgpath"];
            }
        }
        $deleteString = "DELETE FROM foods WHERE id ='" .$id ."'";
        $deleteNutrients = "DELETE FROM `nutrients` WHERE `nutrients`.`food_id` ='" .$id ."'";
        $db->query($deleteNutrients); 
        $db->query($deleteString);
        
        $path = "../images/featured/".$name;

        chown($path,0777);

        unlink($path);
        mysqli_close($conn);
        header("Location: ../index.php");
    }

        if(isset($_GET["workerid"]))
    {
        require_once "db.php";
        $db = db::get();
        $id = $db->escape($_GET["workerid"]);
        $id = (int)$id;

        $deleteString = "DELETE FROM users WHERE id ='" .$id ."'";
       
        $db->query($deleteString);

        mysqli_close($conn);
        echo "<script>window.location.href='admin.php?success=done';</script>";
    }

?>