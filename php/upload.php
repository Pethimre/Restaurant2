<?php

if (isset($_POST["submit"])) 
{
    # code...
    $db = mysqli_connect('localhost', 'root', '', 'restaurant');
    $error;

    $name = mysqli_real_escape_string($db, $_POST["name"]);
    $class = mysqli_real_escape_string($db, $_POST["class"]);
    $price = mysqli_real_escape_string($db, $_POST["price"]);
    $type = mysqli_real_escape_string($db, $_POST["type"]);
    $attr = mysqli_real_escape_string($db, $_POST["attr"]);
    $foodtext = mysqli_real_escape_string($db, $_POST["food_desc"]);
    $protein = mysqli_real_escape_string($db, $_POST["protein"]);
    $cholesterol = mysqli_real_escape_string($db, $_POST["cholesterol"]);
    $carb = mysqli_real_escape_string($db, $_POST["carb"]);
    $sodium = mysqli_real_escape_string($db, $_POST["sodium"]);
    $fiber = mysqli_real_escape_string($db, $_POST["fiber"]);
    $fat = mysqli_real_escape_string($db, $_POST["fat"]);
    $protein = mysqli_real_escape_string($db, $_POST["sat_fat"]);
    $sat_fat = mysqli_real_escape_string($db, $_POST["protein"]);
    $sugar = mysqli_real_escape_string($db, $_POST["sugar"]);

    if (empty($name) || empty($price) || empty($type) || empty($attr) || empty($foodtext)) 
    { 
        echo "<script>window.location.href='admin.php?error=empty'</script>";
    }
    else
    {
        $target_dir = "../images/featured/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $imgname = basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) 
        {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) 
            {
                $uploadOk = 1;
                //header("location: addf.php");
            } 
            else 
            {
                echo "<script>window.location.href='admin.php?error=notImage'</script>";
                $uploadOk = 0;echo "Hiba 2";
            }
        }
    // Check if file already exists
        if (file_exists($target_file)) 
        {
            echo "<script>window.location.href='admin.php?error=imageExists'</script>";
            $uploadOk = 0;
        }
    // Check file size
        if ($_FILES["fileToUpload"]["size"] > 5000000) 
        {
            echo "<script>window.location.href='admin.php?error=largeImage'</script>";
            $uploadOk = 0;
        }
    // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "bmp") 
        {
            echo "<script>window.location.href='admin.php?error=wrongFileFormat'</script>";
            $uploadOk = 0;
        }
    // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) 
        {
            echo "<script>window.location.href='admin.php?error=noUpload'</script>";
    // if everything is ok, try to upload file
        } 
        if ($uploadOk == 1) 
        {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
            {
                $insertQuery = "INSERT INTO `foods` (`id`, `name`, `price`, `type`, `attr`, `imgpath`, `food_desc`, `class`) VALUES (NULL, '$name', '$price', '$type', '$attr','$imgname', '$foodtext', '$class')";
                mysqli_query($db, $insertQuery);
                $foodId = mysqli_insert_id($db);
                $foodId = (int)$foodId;
                $insertNutrients = "INSERT INTO `nutrients` (`nutrient_id`, `food_id`, `protein`, `carb`, `sodium`, `fiber`, `fat`, `sat_fat`, `sugar`, `cholesterol`) VALUES (NULL, '$foodId', '$protein', '$carb', '$sodium', '$fiber', '$fat', '$sat_fat', '$sugar', '$cholesterol')";
                mysqli_query($db, $insertNutrients);
                echo "<script>window.location.href='admin.php?success=done'</script>";
            } 
            else 
            {
                echo "<script>window.location.href='admin.php?error=noUpload'</script>";
            }
        }
    }
}

if (isset($_POST["addrev"])) {

    require_once "db.php";

    $db = db::get();

    $url = $_POST["revurl"];
    $title = $db->escape($_POST["revtitle"]);
    $author = $db->escape($_POST["revauthor"]);
    $website = $_POST["revwebsite"];
    $message = $db->escape($_POST["revmessage"]);

    if (!empty($url) || !empty($title) || !empty($author) || !empty($website) || !empty($message)) {

        $insertQuery = "INSERT INTO `reviews` (`id`, `title`, `message`, `author`, `website`, `url`) VALUES (NULL, '$title', '$message', '$author', '$website', '$url')";
        $query = $db->query($insertQuery);
        echo "<script>window.location.href='admin.php?success=done'</script>";
    }
    else
    {
        echo "<script>window.location.href='admin.php?error=unexpected'</script>";
    }
}


?>