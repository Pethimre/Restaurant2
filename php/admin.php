<?php 

	session_start();
	require_once "upload.php";

	if (isset($_SESSION["username"])) 
	{
		if (!($_SESSION["username"] == "admin")) 
		{
			header("location: ../index.php");
		}
	}

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin page</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	 <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">
	 <link rel="stylesheet" href="../css/bootstrap.min.css">
	 <link rel="stylesheet" href="../css/main.css">
	 <script src="../js/jquery-1.11.2.min.js"></script>
     <script type="text/javascript" src="../js/jquery.flexslider.min.js"></script>
     <link rel="stylesheet" type="text/css" href="../css/dragndrop.css">
     <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon"/>
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
        textarea::placeholder {
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
                        <li><a href="" id="addfbutton">Add new Featured</a></li>
                        <li><a href="">Modify Order</a></li>
                        <li><a href="">Add new Dish</a></li>
                        <li><a href="logout.php">Logout</a></li>
                        <li><a href="#reserve">Modify Reservation</a></li>
                        <li><a href="#contact">Review Contacts</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.row -->
        </nav>

		<div class="container" style="margin-top: 5%">
			<div class="jumbotron text-center" style="background-color: rgba(255,255,255,.5);">
				<h2>Admin Page</h2>
				<small>Welcome back!</small>
			</div>

			<form method="POST" action="upload.php" enctype="multipart/form-data" id="addfeaturedForm">
              <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control registry" placeholder="Food Name" name="name" onfocus="this.style.color='white'">
                    <input type="text" class="form-control registry" placeholder="Price" name="price" onfocus="this.style.color='white'">
                    <input type="text" class="form-control registry" placeholder="Type" name="type" onfocus="this.style.color='white'">
                    <input type="text" class="form-control registry" placeholder="Attribute(s)" name="attr" onfocus="this.style.color='white'">
                    <textarea class="registry form-control" rows="3" placeholder="Description for the food" name="food_desc" onfocus="this.style.color='white'"></textarea>
                    <input type="submit" class="btn btn-success form-control" style="background: rgba(60,118,61, .42); color: white;" value="Upload new dish" name="submit" onfocus="this.style.color='white'">
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
		
		 $("#addfeaturedForm").hide();

            $("#addfbutton").click(function(e) {
                e.preventDefault();
                $("#addfeaturedForm").toggle();
            });
	</script>
	
</body>
</html>