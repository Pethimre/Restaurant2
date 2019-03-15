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
        array_push($error, "Every gap must be filled.");
        header("location: admin.php");
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
                echo "File is an image - " . $check["mime"] . ".(it exists maybe)";
                $uploadOk = 1;
                //header("location: addf.php");
            } 
            else 
            {
                array_push($error, "File is not an image.");
                $uploadOk = 0;echo "Hiba 2";
            }
        }
    // Check if file already exists
        if (file_exists($target_file)) 
        {
            array_push($error, "Sorry, file already exists.");
            $uploadOk = 0;
        }
    // Check file size
        if ($_FILES["fileToUpload"]["size"] > 5000000) 
        {
            array_push($error, "Sorry, your file is too large.");echo "Hiba 3";
            $uploadOk = 0;
        }
    // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "bmp") 
        {
            array_push($error, "Sorry, only JPG, JPEG, BMP, PNG & GIF files are allowed.");echo "Hiba 4";
            $uploadOk = 0;
        }
    // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) 
        {
            array_push($error, "Sorry, your file was not uploaded.");echo "Hiba 5";
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
                array_push($error, "Success");var_dump($insertQuery);
                header("location: admin.php");
            } 
            else 
            {
                array_push($error, "Sorry, there was an error uploading your file.");echo "Hiba 6";
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
        header("location: admin.php");
    }
    else
    {
        echo "Something unexpected happened. Check if you filled the form correctly and navigate <a href='admin.php'> back</a>";
    }
}


?>