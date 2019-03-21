<?php 
    session_start();
    error_reporting(E_ALL & ~E_NOTICE); //Hide php notifications on the page
    /* Prevent Caching */
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    if(isset($_GET["foodid"])){
        require_once "db.php";
        require_once "addtocart.php";
        $db = db::get();
        $id = $db->escape($_GET["foodid"]);
        $_SESSION["id"] = $id;

        $selectString = "SELECT * FROM foods WHERE id='$id'";
        $allfood = $db->getArray($selectString);
    }else{
        header("Location: ../index.php");
    }

    $selectusername = "SELECT `role_id`, `id` FROM `users` WHERE username ='".$_SESSION["username"]."'";
    $getuserdata = $db->getArray($selectusername);

    if (count($getuserdata) > 0)
    {
        foreach ($getuserdata as $user) 
        {
            $roleid = (int)$user["role_id"];
            $userid = (int)$user["id"];
        }

        if ($roleid == 2) {
            $selectCartForUserQuery = "SELECT * FROM cart WHERE status = 'cart' AND user_id = ".$userid;
            $cart = $db->getArray($selectCartForUserQuery);
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Eatwell</title>

        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/owl.carousel.css">
        <link rel="stylesheet" href="../css/owl.theme.css">
        <link rel="stylesheet" href="../css/animate.css">
        <link rel="stylesheet" href="../css/flexslider.css">
        <link rel="stylesheet" href="../css/pricing.css">
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="../css/foodform.css">
        <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">
        <script src="../js/jquery-1.11.2.min.js"></script>
        <script type="text/javascript" src="../js/jquery.flexslider.min.js"></script>
        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon"/>

        <style>
        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #ddd;
        }

        ::-webkit-scrollbar-thumb {
            background: #666;
        }

  </style>

    </head>
    <body data-spy="scroll" data-target="#template-navbar">
        <!--== 4. Navigation ==-->
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
                        <img id="logo" src="../images/Logo_main.png" class="logo img-responsive">
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="Food-fair-toggle">
                    <ul class="nav navbar-nav navbar-right">
                        <li title="Back to the main page"><a href="../index.php"><i class="fas fa-long-arrow-alt-left"></i> back</a></li>
                        <?php     if (!isset($_SESSION["username"])) { echo "<li><a href='../register.php'>LOG IN/SIGNUP</a></li>"; } ?>
                        <?php     if (isset($_SESSION["username"]) && !($_SESSION["username"] == "admin")) { echo "<li><a href='profile.php' >PROFILE</a></li>"; } ?>
                        <?php if(isset($_SESSION["username"]) && count($cart) > 0): ?>
                            <li style="color: white;"><a href="cart.php"><i class="far fa-shopping-cart"></i><?php echo count($cart); ?></a></li>
                        <?php endif; ?>
                        <?php     if (isset($_SESSION["username"])) { echo "<li><a href='logout.php'>Log out</a></li>"; 
                                    if($_SESSION["username"] == "admin"){echo "<li><a href='admin.php'>Admin Page</a></li>";}} ?>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.row -->
        </nav>

<!--== 6. About this food ==-->
        <section id="about" class="about">
            <?php   if(count($allfood) > 0): 
                foreach($allfood as $food): 
            ?>

           <div class="container">
            <div class="row pt-5 m-auto text-center" style="margin-top: 10%;">

                <!-- Copy the content below until next comment -->
                <div class="card card-custom bg-white border-white border-0" style="height: 80vh;  border-radius: 15px;">
                  <div class="card-custom-img" style="background-image: url('../images/background.jpg');">
                    <img class="img-fluid" src="<?php echo '../images/featured/' .$food['imgpath']; ?>" />
                  </div>
                  <div class="card-custom-avatar">
                    
                  </div>
                  <div class="card-body" style="overflow-y: auto; display: block;">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-8"><h3 class="card-title text-center"><?php echo $food["name"]; ?></h3></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                
                                <p class="card-text"><?php echo $food["food_desc"]; ?></p>
                                <?php if($_SESSION["username"] == "admin"): ?>
                                    <input type="button" class="btn btn-danger" onclick="window.location.href='delete.php?foodid=<?php echo $food['id'];?>'" value="Remove">
                                <?php endif; ?>

                                <?php if(isset($_SESSION["username"]) && $roleid == 2 && $food["class"] == "webshop") : ?>
                                    <form action="addtocart.php?item=<?php echo $food["id"]; ?>" method="post">
                                        <input type="submit" class="btn btn-success" value="Add to Cart">
                                        <input type="number" min="1" max="99" name="foodQuantity" value="1">
                                    </form>
                                <?php endif; ?>

                                <?php if(!(isset($_SESSION["username"])) && $food["class"] == "webshop"): ?>
                                    <input type="button" class="btn btn-primary" onclick="window.location.href='register.php'" value="Login for Shopping">
                                <?php endif; ?>
                            </div>
                            <div class="col-sm-6">
                                <iframe src="table.php" style="border: none;" height="310vh" width="350px"></iframe>
                            </div>                                
                          </div>
                        </div>
                    </div>
                    
                    
                    
                  </div>
                  <div class="card-footer" style="background: inherit; border-color: inherit;">
                    
                </div>
                <!-- Copy until here -->
            <?php 
                endforeach;
                endif;            
            ?>
        </section> <!-- /#about -->
<br>
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="copyright text-center">
                            <p onclick="terms()">
                                &copy; Copyright, <?php echo date("Y"); ?> All rights reserved. Terms of use <i class="fal fa-book"></i>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <script src="../js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../js/jquery.mixitup.min.js" ></script>
        <script type="text/javascript" src="../js/jquery.hoverdir.js"></script>
        <script type="text/javascript" src="../js/jQuery.scrollSpeed.js"></script>
        <script src="../js/jquery.validate.js"></script>
        <script src="../js/wow.min.js"></script>
        <script src="../js/owl.carousel.min.js"></script>
        <script src="../js/script.js"></script>

        <script>
            $(document).ready(function() {
                $(window).scroll(function() {
                    if ($(document).scrollTop() > 50) {
                        $('nav').addClass('shrink');
                    } 
                    else {
                        $('nav').removeClass('shrink');
                    }
                });
            });


            $(document).ready(function(){
                $(window).scroll(function() {
                    if ($(document).scrollTop() > 50) {
                        $("#logo").attr("src", "../images/eatwell.png")
                    }
                    else {
                       $("#logo").attr("src", "../images/Logo_main.png")
                   }
               });
            });

            $(window).load(function() {
                $('.flexslider').flexslider({
                   animation: "slide",
                   controlsContainer: ".flexslider-container"
               });
            });

            function terms()
            {
              Swal.fire({
                title: 'Terms of Usage',
                type: 'info',
                html:
                '<b>This website is a template and purely serves no commercial purpose.<br> Our site uses cookies and we dont share any personal data to a third party, and we dont cooperate with any statistic or advertisement campagin. <br> We dont have any of the used pictures and multimedia entites, and we credit them in our readme at our <a href="https://github.com/Pethimre/Restaurant">Github repository</a>.<br> If you want us to remove your personal data you entered in our forms, give us a ticket and we will remove it in the next week.</b> ',
                showCloseButton: false,
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonText:
                'Understood!',
                confirmButtonAriaLabel: '',
            })
          }
      </script>
    </body>
</html>