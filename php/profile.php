<?php 

	session_start();

    require_once "insert_profile.php";
    $usertmp = $_SESSION["username"];
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    $selectUserData = "SELECT * FROM users WHERE username='$usertmp' LIMIT 1";
    $selectUserDataQuery = mysqli_query($conn, $selectUserData);
    $user = mysqli_fetch_assoc($selectUserDataQuery);
    $passconf = $user["password"];

 ?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $_SESSION["username"] ."'s profile"; ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	 <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">
	 <link rel="stylesheet" href="../css/bootstrap.min.css">
	 <link rel="stylesheet" href="../css/main.css">
	 <script src="../js/jquery-1.11.2.min.js"></script>
     <script type="text/javascript" src="../js/jquery.flexslider.min.js"></script>
     <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon"/>
     <link rel="stylesheet" type="text/css" href="../css/dragndrop.css">
     <script type="text/javascript" src="../js/script.js"></script>
     <script type="text/javascript">
        $(window).load(function() {
        $('.flexslider').flexslider({
            animation: "slide",
            controlsContainer: ".flexslider-container"
            });
        });
     </script>
	 <style>
		.bg 
		{ 
			  background-image: url("../images/steak.jpg");
			  background-repeat: no-repeat;
			  background-size: cover;
		}
        .registry
        {
            background-color: rgba(255,255,255,.4);
            border-color: rgba(255,255,255,0.3);
            height: 30px;
        }

        input::placeholder {
            color: white!important;
            text-align: center;
        }
	</style>
</head>
<body class="bg" data-spy="scroll" data-target="#template-navbar">
	<nav id="template-navbar" class="navbar navbar-default custom-navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#Food-fair-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">
                        <img id="logo" src="../images/Logo_main.png" class="logo img-responsive">
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="Food-fair-toggle">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="../index.php">Main Page</a></li>
                        <li><a href="">Review Orders</a></li>
                        <li><a href="" onclick="modify()" id="modify">Modify Profile</a></li>
                        <li><a href="">Contact Us</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.row -->
        </nav>

		<div class="container" style="margin-top: 5%">
			<div class="jumbotron text-center" style="background-color: rgba(255,255,255,.5);">
				<h2>Welcome, <?php echo $_SESSION["username"]; ?>!</h2>
				<small>We hope you have a great day! <br> <?php if(!(empty($errors))){foreach($errors as $kek){echo "<br>".$kek ;}} if(isset($_SESSION["success"])){echo $_SESSION["success"];}?></small>
			</div>

            <form method="POST" action="insert_profile.php" enctype="multipart/form-data" id="modifyForm">
              <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control registry" placeholder="Username" name="username" onfocus="this.style.color='white'" value="<?php echo $_SESSION['username']; ?>">
                    <input type="text" class="form-control registry" placeholder="Full Name" name="fullName" onfocus="this.style.color='white'" value="<?php if(!empty($user['Fullname'])){echo $user['Fullname'];} ?>">
                    <input type="text" class="form-control registry" placeholder="Shipping Address" name="ShippingAddr" onfocus="this.style.color='white'" value="<?php if(!empty($user['Shipping_addr'])){echo $user['Shipping_addr'];} ?>">
                    <input type="text" class="form-control registry" placeholder="Billing Address" name="BillingAddr" onfocus="this.style.color='white'" value="<?php if(!empty($user['Billing_addr'])){echo $user['Billing_addr'];} ?>">
                    <input type="tel" class="form-control registry" placeholder="Phone Number" name="phoneNo" onfocus="this.style.color='white'" value="<?php if(!empty($user['PhoneNo'])){echo $user['PhoneNo'];} ?>">
                    <input type="email" class="form-control registry" placeholder="Email Address" name="email" onfocus="this.style.color='white'" value="<?php if(!empty($user['email'])){echo $user['email'];} ?>">
                    <input type="password" class="form-control registry" placeholder="Confirm With Your Password" name="password" onfocus="this.style.color='white'" required>
                    <input type="submit" class="btn btn-success form-control" style="background: rgba(60,118,61, .42); color: white;" value="Update Profile" name="submit" onfocus="this.style.color='white'">
                    <h3 class="text-center" style="color: white;">Profile Picture is Optional</h3>
                    <p>
                        <label for="myDragElement" class="dragAndUpload" data-post-string="?todo=test">
                            <span class="dragAndUploadIcon">
                                <i class="dragAndUploadIconNeutral fas fa-arrow-up"></i>
                                <i class="dragAndUploadIconUploading fas fa-cog fa-spin"></i>
                                <i class="dragAndUploadIconSuccess fas fa-thumbs-up"></i>
                                <i class="dragAndUploadIconFailure fas fa-thumbs-down"></i>
                            </span>
                            <b class="dragAndUploadText"><span class="dragAndUploadTextLarge">Drag and drop</span> <span class="dragAndUploadTextSmall">or click to upload</span></b>
                            <i class="dragAndUploadCounter">0%</i>
                            <input type="file" multiple="multiple" class="dragAndUploadManual" name="fileToUpload" id="myDragElement" />
                        </label>
                    </p>
              </div>
          </div>
      </form>
		</div>
	</div>

        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/owl.carousel.min.js"></script>
        <script type="text/javascript" src="../js/jquery.mixitup.min.js" ></script>
        <script src="../js/wow.min.js"></script>
        <script src="../js/jquery.validate.js"></script>
        <script type="text/javascript" src="../js/jquery.hoverdir.js"></script>
        <script type="text/javascript" src="../js/jQuery.scrollSpeed.js"></script>
        <script src="../js/script.js"></script>

        <script>
            $("#modifyForm").hide();

            $("#modify").click(function(e) {
                e.preventDefault();
                $("#modifyForm").toggle();
            });
        </script>

</body>
</html>