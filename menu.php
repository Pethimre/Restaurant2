<?php 

	session_start();
    require_once "php/db.php";
    require_once "php/delete.php";

    $db = db::get();
    $selectString = "SELECT * FROM foods";
    $allfeatured = $db->getArray($selectString);
    //$conn = mysqli_connect('localhost', 'root', '', 'restaurant') ;

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
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Menu</title>

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/owl.carousel.css">
        <link rel="stylesheet" href="css/owl.theme.css">
        <link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="css/flexslider.css">
        <link rel="stylesheet" href="css/pricing.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">
        <script src="js/jquery-1.11.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.flexslider.min.js"></script>
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
        <script type="text/javascript">
            $(window).load(function() {
                $('.flexslider').flexslider({
                 animation: "slide",
                 controlsContainer: ".flexslider-container"
                });
            });
        </script>
        
</head>
<body class="bg" data-spy="scroll" data-target="#template-navbar">
	<nav id="template-navbar" class="navbar navbar-default custom-navbar-default navbar-fixed-top">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#Food-fair-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">
                        <img id="logo" src="images/Logo_main.png" class="logo img-responsive">
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="Food-fair-toggle">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#about">about</a></li>
                        <li><a href="#pricing">pricing</a></li>
                        <li><a href="#great-place-to-enjoy">beer</a></li>
                        <li><a href="#breakfast">bread</a></li>
                        <li><a href="#featured-dish">featured</a></li>
                        <?php     if (!isset($_SESSION["username"])) { echo "<li><a class='color_animation' href='register.php'>LOG IN/SIGNUP</a></li>"; } ?>
                        <?php     if (isset($_SESSION["username"]) && !($_SESSION["username"] == "admin")) { echo "<li><a class='color_animation' href='php/profile.php' >PROFILE</a></li>"; } ?>
                        <?php     if (isset($_SESSION["username"])) { echo "<li><a class='color_animation' href='php/logout.php'>Log out</a></li>"; 
                                    if($_SESSION["username"] == "admin"){echo "<li><a class='color_animation' href='php/admin.php'>Admin Page</a></li>";}} ?>
                        <li><a href="#reserve">reservation</a></li>
                        <li><a href="#contact">contact</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.row -->
        </nav>
                    <!--==  7. Afordable Pricing  ==-->
        <section id="pricing" class="pricing">
            <div id="w">
                <div class="pricing-filter">
                    <div class="pricing-filter-wrapper">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="section-header">
                                        <h2 class="pricing-title">Affordable Pricing</h2>
                                        <ul id="filter-list" class="clearfix">
                                            <li class="filter" data-filter="all">All</li>
                                            <li class="filter" data-filter=".breakfast">Breakfast</li>
                                            <li class="filter" data-filter=".special">Special</li>
                                            <li class="filter" data-filter=".desert">Desert</li>
                                            <li class="filter" data-filter=".dinner">Dinner</li>
                                            <li class="filter" data-filter=".kek">kek</li>
                                        </ul><!-- @end #filter-list -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">  
                        <div class="col-md-10 col-md-offset-1">
                            <form action="" method="POST">
                                <ul id="menu-pricing" class="menu-price">
                                <?php   if(count($allfeatured) > 0): 
                                        foreach($allfeatured as $featured): 
                                ?>
                                <li class="item <?php echo $featured['type'] .' ' .$featured['attr']; ?>">

                                    <a href="#">
                                        <img src="images/featured/<?php echo $featured['imgpath']; ?>" class="img-responsive" alt="Food" >
                                        <div class="menu-desc text-center">
                                            <span>
                                                <h3><?php echo $featured['name']; ?></h3>
                                                <?php echo $featured['food_desc'] ."<br>"; ?>
                                                <input type="button" class="btn btn-danger" onclick="window.location.href='php/delete.php?foodid=<?php echo $featured['id'];?>'" value="Remove">
                                            </span>
                                        </div>
                                    </a>
                                        
                                    <h2 class="white"><?php echo $featured['price']; ?></h2>
                                </li>
                                <?php 
                                        endforeach;
                                        endif;            
                                ?>
                            </ul>
                            </form>
                            
                            <!-- <div class="text-center">
                                    <a id="loadPricingContent" class="btn btn-middle hidden-sm hidden-xs">Load More <span class="caret"></span></a>
                            </div> -->

                        </div>   
                    </div>
                </div>

            </div> 
        </section>

        <script src="js/bootstrap.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script type="text/javascript" src="js/jquery.mixitup.min.js" ></script>
        <script src="js/wow.min.js"></script>
        <script src="js/jquery.validate.js"></script>
        <script type="text/javascript" src="js/jquery.hoverdir.js"></script>
        <script type="text/javascript" src="js/jQuery.scrollSpeed.js"></script>
        <script src="js/script.js"></script>

	</div>
</body>
</html>