<?php 
    session_start();
    error_reporting(E_ALL & ~E_NOTICE); //Hide php notifications on the page
    /* Prevent Caching */
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    require_once "php/db.php";
    require_once "php/delete.php";
    require_once "php/reserve.php";
    require_once "php/insert_contact.php";

    $db = db::get();
    $selectString = "SELECT * FROM foods WHERE class = 'restaurant' OR class = 'both'";
    $allfeatured = $db->getArray($selectString);

    if(isset($_SESSION["username"]))
    {
        $selectusername = "SELECT `email`, `PhoneNo`, `Fullname`, `role_id`, `id` FROM `users` WHERE username ='".$_SESSION["username"]."'";
        $getuserdata = $db->getArray($selectusername);

                    if (count($getuserdata) > 0)  //it doesnt make sense, but at least it works this way xd
                    {
                        foreach ($getuserdata as $user) {
                            $email = $user["email"];
                            $phone = $user["PhoneNo"];
                            $fullname = $user["Fullname"] ;
                            $roleid = (int)$user["role_id"];
                            $userid = (int)$user["id"];
                        }
                    }
        $selectCartForUserQuery = "SELECT * FROM cart WHERE status = 'cart' AND user_id = ".$userid;
        $cart = $db->getArray($selectCartForUserQuery);

        if (isset($_GET["success"])) {
            $success = $db->escape($_GET["success"]);
        }

        if (isset($_GET["error"])) {
            $error = $db->escape($_GET["error"]);
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Eatwell</title>

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/owl.carousel.css">
        <link rel="stylesheet" href="css/owl.theme.css">
        <link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="css/flexslider.css">
        <link rel="stylesheet" href="css/pricing.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">
        <link rel="stylesheet" href="css/sweetalert2.min.css">
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="js/jquery-1.11.2.min.js"></script>
        <script src="js/jquery.flexslider.min.js"></script>
        <script type="text/javascript" src="js/sweetalert2.all.min.js"></script>
        <script type="text/javascript">
            $(window).load(function() {
                $('.flexslider').flexslider({
                 animation: "slide",
                 controlsContainer: ".flexslider-container"
                });
            });
        </script>
        <style>
            ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #ddd;
        }

        ::-webkit-scrollbar-thumb {
            background: #666;
        }
        input[type="datetime-local"] {
            background:#fff url(https://cdn1.iconfinder.com/data/icons/cc_mono_icon_set/blacks/16x16/calendar_2.png)  95% 50% no-repeat ;
        }
        input[type="datetime-local"]::-webkit-inner-spin-button {
          display: none;
      }
      input[type="datetime-local"]::-webkit-calendar-picker-indicator {
          opacity: 0;
      }
      textarea {
        resize: none;
        overflow: auto;
      }

      .navul
      {
        text-decoration: none!important; 
        list-style: none;
      }
      .navul a:hover
      {
        text-decoration: none;
        border: none;
      }

      .webshop h3
      {
        color: white;
      }

      .webshop h3:hover
      {
        color: blue;
      }
        
        .quantity
        {
            width: 50px!important; 
            background-color: rgba(255,255,255,.5); 
            text-decoration:none;
            border: none;
        }
        </style>
        <script>
            function errormsg(errortext)
            {
              Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: errortext + "!",
                footer: "If you need help, contact us <a href='../index.php' style='color:black;text-decoration:none;'> <i class='fas fa-arrow-right'></i></a>."
            })
          }
          function okmsg(oktext)
          {
              Swal.fire(
                'Ok!',
                 oktext + '!',
                'success'
                )
          }
      </script>
    </head>
    <body data-spy="scroll" data-target="#template-navbar">
        <?php 

            switch ($error) {
                case 'empty':
                    echo "<script>oktext = 'All gaps must be filled.'; errormsg(oktext);</script>";
                    break;

                case 'big':
                    echo "<script>oktext = 'Our biggest table can hosts 20 people. If you need more space, contact us and ask for event booking.'; errormsg(oktext);</script>";
                    break;

                case 'wrongDate':
                    echo "<script>oktext = 'Invalid date entered.'; errormsg(oktext);</script>";
                    break;

                case 'reserved':
                    echo "<script>oktext = 'Sorry,but this table has already been reserved to this interval.'; errormsg(oktext);</script>";
                    break;

                case 'closed':
                    echo "<script>oktext = 'Sorry,but we are not opened on that interval.'; errormsg(oktext);</script>";
                    break;

                case 'error':
                    echo "<script>oktext = 'WoW! Something unexpected happened.'; errormsg(oktext);</script>";
                    break;

                default:
                    # code...
                    break;
            }
            if ($success == "thankyou") {
                echo "<script>oktext = 'Thank you for choosing us'; okmsg(oktext);</script>";
            }

         ?>
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
                        <img id="logo" src="images/Logo_main.png" class="logo img-responsive">
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="Food-fair-toggle">
                    <ul class="navbar-nav navbar-right navul">
                        <li><a href="#about">about</a></li>
                        <li><a href="#pricing">pricing</a></li>
                        <li><a href="#great-place-to-enjoy">Outdoor</a></li>
                        <li><a href="#Reviews">Reviews</a></li>
                        <li><a href="#webshop">Webshop</a></li>
                        <li><a href="#reserve">reservation</a></li>
                        <li><a href="#contact">contact</a></li>
                        <?php     if (!isset($_SESSION["username"])) { echo "<li><a href='register.php'>LOG IN/SIGNUP</a></li>"; } ?>
                        <?php     if (isset($_SESSION["username"]) && !($_SESSION["username"] == "admin")) { if($roleid != 2){echo "<li><a href='php/router.php' >Dashboard</a></li>";} if($roleid == 2){echo "<li><a href='php/profile.php' >Profile</a></li>";} } ?>
                        <?php     if (isset($_SESSION["username"])) { if($_SESSION["username"] == "admin"){echo "<li><a href='php/admin.php'>Admin Page</a></li>";}
                        echo "<li><a href='php/logout.php'><i class='fal fa-sign-out-alt' title='Log Out'></i></a></li>";} ?>
                        <?php if(isset($_SESSION["username"]) && count($cart) > 0): ?>
                            <li style="color: white;"><a href="php/cart.php"><i class="far fa-shopping-cart"></i><?php echo count($cart); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.row -->
        </nav>


        <!--== 5. Header ==-->
        <section id="header-slider" class="owl-carousel">
            <div class="item">
                <div class="container">
                    <div class="header-content">
                        <h1 class="header-title">BEST FOOD</h1>
                        <p class="header-sub-title">Doubt it? Try it!</p>
                    </div> <!-- /.header-content -->
                </div>
            </div>
            <div class="item">
                <div class="container">
                    <div class="header-content">
                        <h1 class="header-title">BEST SNACKS</h1>
                        <p class="header-sub-title">Diet? You won't feel guilty when you taste it!</p>
                    </div> <!-- /.header-content -->
                </div>
            </div>
            <div class="item">
                <div class="container">
                    <div class="header-content text-right pull-right">
                        <h1 class="header-title">BEST DRINKS</h1>
                        <p class="header-sub-title">Even if you don't thirsty!</p>
                    </div> <!-- /.header-content -->
                </div>
            </div>
        </section>



        <!--== 6. About us ==-->
        <section id="about" class="about">
            <img src="images/icons/about_color.png" class="img-responsive section-icon hidden-sm hidden-xs">
            <div class="wrapper">
                <div class="container-fluid">
                    <div class="row dis-table">
                        <div class="hidden-xs col-sm-6 section-bg about-bg dis-table-cell">

                        </div>
                        <div class="col-xs-12 col-sm-6 dis-table-cell">
                            <div class="section-content">
                                <h2 class="section-content-title">About us</h2>
                                <p class="section-content-para">
                                    <div align="center"><h4>Welcome to Eatwell!</h4></div> <br> 
                                    We offer you wide variety of foods and drinks with the highest quality of service. We have several traditional recipes and most of them available in special form. (sugar or gluten free, diabetic, and so on) If you have any special request, please inform us in advance and we can solve it.
                                </p>
                                <p class="section-content-para">
                                    We often take place for wedding, birthday and even new years eve. If you would like to reserve our celebration room, contact us! (See the contacts below).
                                </p>
                            </div> <!-- /.section-content -->
                        </div>
                    </div> <!-- /.row -->
                </div> <!-- /.container-fluid -->
            </div> <!-- /.wrapper -->
        </section> <!-- /#about -->


        <!--==  7. Afordable Pricing  ==-->
        <section id="pricing" class="pricing">
            <div id="w">
                <div class="pricing-filter">
                    <div class="pricing-filter-wrapper">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="section-header">
                                        <h2 class="pricing-title">Restaurant menu Pricing</h2>
                                        <ul id="filter-list" class="clearfix">
                                            <li class="filter" data-filter="all">All</li>
                                            <li class="filter" data-filter=".starter">Starter</li>
                                            <li class="filter" data-filter=".maincourse">Main Course</li>
                                            <li class="filter" data-filter=".dessert">Dessert</li>
                                            <li class="filter" data-filter=".special">Special</li>
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
                            <ul id="menu-pricing" class="menu-price">
                                <?php   if(count($allfeatured) > 0): 
                                        foreach($allfeatured as $featured): 
                                ?>
                                <li class="item <?php echo $featured['type'] .' '.$featured['attr']; ?>" style="border-radius: 15px;">

                                    <a href="#" style="border-radius: 15px;">
                                        <img src="images/featured/<?php echo $featured['imgpath']; ?>" class="img-responsive" style="height: 175.6px!important; width: 300px!important; border-radius: 15px;" alt="Food">
                                        <div class="menu-desc text-center" style="border-radius: 15px;">
                                            <span style="border-radius: 15px;">
                                                <h3 onclick="window.location.href='php/foodform.php?foodid=<?php echo $featured["id"]; ?>'"><?php echo $featured['name']; ?></h3>
                                                <?php if($_SESSION["username"] == "admin"): ?>
                                                    <input type="button" class="btn btn-danger" onclick="window.location.href='php/delete.php?foodid=<?php echo $featured['id'];?>'" value="Remove"><br>
                                                <?php endif; ?>
                                                <?php echo substr($featured["food_desc"], 0,15); if(strlen($featured["food_desc"])>15){echo "...";} ?>
                                            </span>
                                        </div>
                                    </a>
                                        
                                    <h2 class="white"><?php echo $featured['price']." HUF"; ?></h2>
                                </li>
                                <?php 
                                        endforeach;
                                        endif;            
                                ?>
                            </ul>
                        </div>   
                    </div>
                </div>

            </div> 
        </section>


        <!--== 8. View ==-->
        <section id="great-place-to-enjoy" class="great-place-to-enjoy">
            <div class="wrapper">
                <div class="container-fluid">
                    <div class="row dis-table">
                        <div class="col-xs-6 col-sm-6 dis-table-cell color-bg">
                            <h2 class="section-title"><i onclick="weather()" class="fal fa-sun" title="Check out weather!"></i>Love the view? Enjoy!</h2>
                        </div>
                        <div class="col-xs-6 col-sm-6 dis-table-cell section-bg">
                            
                        </div>
                    </div> <!-- /.dis-table -->
                </div> <!-- /.row -->
            </div> <!-- /.wrapper -->
        </section> <!-- /View -->



        <!--==  9. Outdoor  ==-->
        <section id="beer" class="outdoor">
            <div class="container-fluid">
                <div class="row dis-table">
                    <div class="hidden-xs col-sm-6 dis-table-cell section-bg">

                    </div>

                    <div class="col-xs-12 col-sm-6 dis-table-cell" style="background-color:  #8bc34a; color: white;">
                        <div class="section-content">
                            <h2 class="section-content-title">Outdoor Tables</h2>
                            <div class="section-description">
                                <p class="section-content-para">
                                    We have many outdoor seats for our guests. They suitable for a bigger ceremonies or several smaller events at the same time as well.
                                </p>
                                <p class="section-content-para">
                                    If the weather conditions are acceptable, our terrace and outdoor wing is open for the quests. There is a bigger VIP section at the center of the upper level with the best possible view to the city over the bay. This magnificent surroundings are the most romantic at night with the thousands of lights from the city, and above the millions of stars. Because of this, we recommend everyone visit it at night, especially after a hard day when you cant wait to have dinner with your loved one, or if you just here to see the city and you are curious for the city's night life. 
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php 
            $selectRevs = "SELECT * FROM reviews ORDER BY id ASC";
            $allrevs = $db->getArray($selectRevs);
         ?>

        <!--== 11.Reviews ==-->
        <?php if (count($allrevs) > 0) : ?>
        <section id="Reviews" class="Reviews" style="background-image: url('images/review.jpg');">
            
            <div class="container-fluid">
                
                <div class="row dis-table">
                    <div class="col-xs-12 col-sm-6 dis-table-cell">
                        <div class="section-content">
                            <h2 class="section-content-title" style="color: white; text-shadow: 2px 2px gray;">
                                What the experts said about us
                            </h2>
                            <div class="section-description">
                                <p class="section-content-para">

                                    <div class="container content">
                                        <div class="bd-example">
                                            <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                                                <!-- Indicators -->
                                                <ol class="carousel-indicators">
                                                    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                                                    <?php $i = 1; while ($i < count($allrevs)) : ?>
                                                    <li data-target="#carouselExampleCaptions" data-slide-to="<?php echo $i; ?>"></li>
                                                    <?php $i++; ?>
                                                <?php endwhile; ?>
                                            </ol>
                                            <!-- Wrapper for slides -->
                                            <div class="carousel-inner">
                                                <?php $j = 0; foreach($allrevs as $revs): ?>
                                                <div class="item <?php if($j == 0): ?> active <?php endif; ?>">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <div class="thumbnail adjust1">
                                                                <div class="col-md-2 col-sm-2 col-xs-12"> <img class="media-object img-rounded img-responsive" src="<?php echo $revs["url"]; ?>"> </div>
                                                                <div class="col-md-10 col-sm-10 col-xs-12">
                                                                    <div class="caption">
                                                                        <p class="text-info lead adjust2"><b><?php echo $revs["title"]; ?></b></p>
                                                                        <p><?php echo $revs["message"]; ?></p>
                                                                        <blockquote class="adjust2">
                                                                            <p><?php echo $revs["author"]; ?></p> <small><cite title="Source Title"><?php echo $revs["website"]; $j++; ?></cite></small> </blockquote>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                                                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                  <span class="sr-only">Previous</span>
                                              </a>
                                              <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                                                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                  <span class="sr-only">Next</span>
                                              </a>
                                          </div>
                                      </div>
                                  </div>

                              </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    </div>
                </section>
            



        <!--== 12. Our Featured Dishes Menu ==-->
        <section id="featured-dish" class="featured-dish">
            <div class="wrapper">
                <div class="container-fluid">
                    <div class="row dis-table">
                        <div class="col-xs-6 col-sm-6 dis-table-cell color-bg">
                            <h2 class="section-title">Webshop Menu</h2>
                        </div>
                        <div class="col-xs-6 col-sm-6 dis-table-cell section-bg">
                            
                        </div>
                    </div> <!-- /.dis-table -->
                </div> <!-- /.row -->
            </div> <!-- /.wrapper -->
        </section> <!-- /#featured-dish -->




        <!--== 13. Webshop ==-->
        <section id="webshop" class="webshop">
            <div class="container" id="webshopItems">
                
            </div>
        </section>



        <!--== 14. dish look ==-->

        <section id="have-a-look" class="have-a-look hidden-xs">
            <div class="wrapper">
                <div class="container-fluid">
                    <div class="row">

                        <div class="menu-gallery" style="width: 50%; float:left;">
                            <div class="flexslider-container">
                                <div class="flexslider">
                                    <ul class="slides">
                                        <li>
                                            <img src="images/menu-gallery/menu1.png" />
                                        </li>
                                        <li>
                                            <img src="images/menu-gallery/menu2.jpg" />
                                        </li>
                                        <li>
                                            <img src="images/menu-gallery/menu3.png" />
                                        </li>
                                        <li>
                                            <img src="images/menu-gallery/menu4.jpg" />
                                        </li>
                                        <li>
                                            <img src="images/menu-gallery/menu5.jpg" />
                                        </li>
                                        <li>
                                            <img src="images/menu-gallery/menu6.jpg" />
                                        </li>
                                        <li>
                                            <img src="images/menu-gallery/menu7.jpg" />
                                        </li>
                                        <li>
                                            <img src="images/menu-gallery/menu8.jpg" />
                                        </li>
                                        <li>
                                            <img src="images/menu-gallery/menu9.jpg" />
                                        </li>
                                        <li>
                                            <img src="images/menu-gallery/menu10.jpg" />
                                        </li>
                                        <li>
                                            <img src="images/menu-gallery/menu11.jpg" />
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="gallery-heading hidden-xs color-bg" style="width: 50%; float:right;">
                            <h2 class="section-title">Have A Look To Our Dishes</h2>
                        </div>
                        

                    </div> <!-- /.row -->
                </div> <!-- /.container-fluid -->
            </div> <!-- /.wrapper -->
        </section>




        <!--== 15. Reserve A Table! ==-->
        <section id="reserve" class="reserve">
            <div class="wrapper">
                <div class="container-fluid">
                    <div class="row dis-table">
                        <div class="col-xs-6 col-sm-6 dis-table-cell color-bg">
                            <h2 class="section-title">Reserve A Table Now!</h2>
                        </div>
                        <div class="col-xs-6 col-sm-6 dis-table-cell section-bg">
                            
                        </div>
                    </div> <!-- /.dis-table -->
                </div> <!-- /.row -->
            </div> <!-- /.wrapper -->
        </section> <!-- /#reserve -->

        <?php $nowKek = date("Y-m-d H:i:s"); ?>

        <section class="reservation">
            <img class="img-responsive section-icon hidden-sm hidden-xs" src="images/icons/reserve_color.png">
            <div class="wrapper">
                <div class="container-fluid">
                    <div class=" section-content">
                        <div class="row">
                            <div class="col-md-5 col-sm-6">
                                <form class="reservation-form" method="post" action="php/reserve.php">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control reserve-form empty iconified" name="forwho" id="name" required="required" placeholder="  &#xf007;  Name" value="<?php if(!empty($fullname)){echo $fullname;} ?>" >
                                            </div>
                                            <div class="form-group">
                                                <input type="number" min="1" max="20" class="form-control reserve-form empty iconified" name="numberofpepole" id="name" required="required" placeholder=" &#xf0c0;  Number of Pepole">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <input type="tel" class="form-control reserve-form empty iconified" name="phone" id="phone" required="required" placeholder="  &#xf095;  Phone" value="<?php if(!empty($phone)){echo $phone;} ?>" >
                                            </div>
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control reserve-form empty iconified" id="email" required="required" placeholder="  &#xf1d8;  e-mail" value="<?php if(!empty($email)){echo $email;} ?>" >
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12">
                                            <textarea type="text" name="message" class="form-control reserve-form empty iconified" id="message" rows="3" placeholder="  &#xf086;  We're listening"></textarea>
                                        </div>

                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <input type="datetime-local" class="form-control reserve-form empty iconified" name="reserve_date" id="datepicker" required="required" placeholder="&#xf017;  Time" min="">
                                            </div>
                                        </div> 
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <input type="number" min="1" max="20" class="form-control reserve-form empty iconified" name="tableNumber" id="tableNumber" required="required" placeholder=" &#xf0c0;  Select Table">
                                            </div>
                                        </div> 

                                        <div class="col-md-12 col-sm-12">
                                            <button type="submit" id="submit" name="submit" class="btn btn-reservation">
                                                <span><i class="far fa-calendar-check"></i></span>
                                                Make a reservation
                                            </button>
                                        </div>
                                            
                                    </div>
                                </form>
                            </div>
                            
                            <div class="col-md-2 hidden-sm hidden-xs"></div>

                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="opening-time text-center">
                                    <h3 class="opening-time-title">Hours</h3>
                                    <p>Mon to Fri: 7:00 AM - 23:00 PM</p>
                                    <p>Sat & Sun: 7:00 AM - 23:00 PM</p>

                                    <div class="launch text-center">
                                        <h4>Lunch</h4>
                                        <p>Mon to Fri: 12:00 PM - 5:00 PM</p>
                                        <p>Sat to Sun: 12:00 PM - 5:00 PM</p>
                                    </div>

                                    <div class="dinner text-center">
                                        <h4>Dinner</h4>
                                        <p>Mon to Fri: 5:00 PM - 23:00 PM</p>
                                        <p>Sun to Sun: 5:00 PM - 23:00 PM</p>
                                    </div>
                                    <hr>
                                    <h4 class="text-center">Our Services:</h4>
                                    <hr>
                                    <ul style="text-decoration: none; list-style-type: none; text-align: left;">
                                        <li><i class="fal fa-wifi"></i> Free Wi-fi</li>
                                        <li><i class="fal fa-music"></i> Live music after 7:00 PM</li>
                                        <li><i class="fal fa-camera-alt"></i> Great View</li>
                                        <li><i class="fab fa-stripe-s"></i>pecial Foods</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>


        <section id="contact" class="contact">
            <div class="container-fluid color-bg">
                <div class="row dis-table">
                    <div class="hidden-xs col-sm-6 dis-table-cell">
                        <h2 class="section-title">Contact With us</h2>
                    </div>
                    <div class="col-xs-6 col-sm-6 dis-table-cell">
                        <div class="section-content">
                            <p><i class="far fa-map-marked-alt"></i> Hungary, Budapest, 1184 Hengersor u. 34.</p>
                            <p><i class="fal fa-phone"></i> +36 70 526 0239</p>
                            <p><i class="fab fa-telegram-plane"></i> info@eatwell.com </p>
                        </div>
                    </div>
                </div>
                <div class="social-media">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <ul class="center-block">
                                <li><a href="https://hu-hu.facebook.com/hengersor/" class="fb"></a></li>
                                <li><a href="#" class="twit"></a></li>
                                <li><a href="#" class="insta"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="container-fluid">
            <div class="row">
                <iframe width="100%" height="450" src="https://maps.google.com/maps?width=100%&amp;height=450&amp;hl=en&amp;q=hengersor%20street%2034+(Eat%20Well)&amp;ie=UTF8&amp;t=&amp;z=14&amp;iwloc=B&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"><a href="https://www.maps.ie/map-my-route/">Map a route</a></iframe>
            </div>
        </div>

        <section class="contact-form">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
                        <div class="row">
                             <form class="contact-form" method="post" action="php/insert_contact.php">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <input  name="contactor" type="text" class="form-control" id="name" required="required" <?php if(isset($_SESSION["username"]) && $_SESSION["username"] != "admin"){ echo "readonly='true'";} ?> value="<?php if(!empty($fullname)){echo $fullname;} ?>" placeholder="  Name">
                                    </div>
                                    <div class="form-group">
                                        <input name="concactEmail" type="email" class="form-control" id="email" required="required" <?php if(isset($_SESSION["username"]) && $_SESSION["username"] != "admin"){ echo "readonly='true'";} ?> value="<?php if(!empty($email)){echo $email;} ?>" placeholder="  Email">
                                    </div>
                                    <div class="form-group">
                                        <input name="subject" type="text" class="form-control" id="subject" required="required" placeholder="  Subject">
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6">
                                    <textarea name="concactMessage" type="text" class="form-control" id="message" rows="7" required="required" placeholder="  Message"></textarea>
                                </div>

                                <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                                    <div class="text-center">
                                        <button type="submit" id="submit" name="submitContact" class="btn btn-send"><i class="fab fa-telegram-plane"></i> Send </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>


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

         <script type="text/javascript">
               $('.flexslider').flexslider({
                 animation: "slide",
                 controlsContainer: ".flexslider-container"
                });

               function terms()
               {
                Swal.fire({
                      title: 'Terms of Usage',
                      type: 'info',
                      html:
                      '<b>This website is a template and purely serves no commercial purpose.<br> Our site uses cookies and we dont share any personal data to a third party, and we dont cooperate with any statistic or advertisement campagin. <br> We dont have any of the used pictures and multimedia entites, and we credit them in our readme at our <a href="https://github.com/Pethimre/Restaurant">Github repository</a>.<br> If you want us to remove your personal data you entered in our forms, give us a ticket and we will remove it in one week.</b> ',
                      showCloseButton: false,
                      showCancelButton: false,
                      focusConfirm: false,
                      confirmButtonText:
                      'Understood!',
                      confirmButtonAriaLabel: '',
                  })
                }

                $(document).ready(function() {

                  $("#clients").owlCarousel({

                      navigation : false, // Show next and prev buttons
                      autoplay :true,
                      slideSpeed : 300,
                      paginationSpeed : 400,
                      autoHeight : true,
                      itemsCustom : [
                      [0, 1],
                      [450, 2],
                      [600, 2],
                      [700, 2],
                      [1000, 4],
                      [1200, 5],
                      [1400, 5],
                      [1600, 5]
                      ],
                });

                $("#testimonial").owlCarousel({
                    navigation : false, // Show next and prev buttons
                    slideSpeed : 300,
                    paginationSpeed : 400,
                    singleItem:true
                });

              });

                function weather()
                {
                    !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
                    
                    Swal.fire({
                      title: 'Our Weather',
                      type: 'info',
                      html:
                      '<a class="weatherwidget-io" href="https://forecast7.com/en/47d5019d04/budapest/" data-label_1="BUDAPEST" data-label_2="Our weather" data-font="Open Sans" data-days="3" data-theme="weather_one" >BUDAPEST Our weather</a>',
                      showCloseButton: true,
                      showCancelButton: false,
                      focusConfirm: false,
                      confirmButtonText:
                      '<i class="fa fa-thumbs-up"></i> Great!',
                      confirmButtonAriaLabel: 'Thumbs up, great!',
                  })
                }

                var actualPage = 1;
                
                getPage(actualPage);

                function getPage(page)
                {
                    actualPage = page;
                    $.ajax({
                        url: 'getmeals.php?page='+actualPage,
                  })
                    .done(function(res) {
                        $("html").find("#webshopItems").html(res);
                  })
                }

                function next()
                {
                    page = actualPage + 1;
                    getPage(page);
                }


                function previous()
                {
                    if (actualPage > 1)
                    {
                       page = actualPage - 1;
                       getPage(page);
                    }
                    else
                    {
                        getPage(page);
                    }

               }

        </script>

        <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/jquery.mixitup.min.js" ></script>
        <script type="text/javascript" src="js/jquery.hoverdir.js"></script>
        <script type="text/javascript" src="js/jQuery.scrollSpeed.js"></script>
        <script src="js/jquery.validate.js"></script>
        <script src="js/wow.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/script.js"></script>

    </body>
</html>