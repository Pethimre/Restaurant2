<?php 
session_start();
    error_reporting(E_ALL & ~E_NOTICE); //Hide php notifications on the page
    /* Prevent Caching */
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    if (isset($_SESSION["username"])) {
        require_once "db.php";
        $db = db::get();
            $selectUserDataQuery = "SELECT profilepic, coverpic, id FROM users WHERE username ='".$_SESSION["username"]."'";
            $getUserData = $db->getArray($selectUserDataQuery);

            if (count($getUserData) > 0) {
                foreach ($getUserData as $user) {
                    $profilepic = $user["profilepic"];
                    $coverpic = $user["coverpic"];
                    $userid = $user["id"];
                }
                $countCartQuery = "SELECT * FROM cart WHERE user_id =".$userid." AND status = 'cart'";
                $countCart = $db->numrows($countCartQuery);

                if ($countCart == 0) {
                    echo "<script>window.location.href='../index.php'</script>";
                }
            }
    }
    else
    {
        header("location: ../index.php");
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
        <link rel="stylesheet" type="text/css" href="../css/sweetalert2.min.css">
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="../css/foodform.css">
        <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">
        <script src="../js/jquery-1.11.2.min.js"></script>
        <script type="text/javascript" src="../js/jquery.flexslider.min.js"></script>
        <script src="../js/sweetalert2.all.min.js"></script>
        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon"/>

        <style>
            ::-webkit-scrollbar {
                width: 12px;
            }

            ::-webkit-scrollbar-track {
                background: #ddd;
            }

            ::-webkit-scrollbar-thumb {
                background: #666;
            }

            .jumbotrontext {
                color: rgba(255,255,255,0.9);
                background: #666666;
                -webkit-background-clip: text;
                -moz-background-clip: text;
                background-clip: text;
                text-shadow: 0px 3px 3px rgba(255,255,255,0.5);
            }

            .content
            {
                -webkit-box-shadow: inset 9px 12px 26px -5px rgba(0,0,0,0.75);
                -moz-box-shadow: inset 9px 12px 26px -5px rgba(0,0,0,0.75);
                box-shadow: inset 9px 12px 26px -5px rgba(0,0,0,0.75);
            }
        </style>

    </head>
    <body data-spy="scroll" data-target="#template-navbar" style="background: url('../images/cart.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
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
                        <?php     if (isset($_SESSION["username"])) { echo "<li><a href='logout.php'>Log out</a></li>"; 
                        if($_SESSION["username"] == "admin"){echo "<li><a href='admin.php'>Admin Page</a></li>";}} ?>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.row -->
        </nav>

        <section>

           <div class="container content" style="background-color: rgba(216,216,216,1); margin-top: 7%; border: 1px solid gray; border-radius: 15px; height: 90vh;">
                <div class="jumbotron text-center" style="<?php if(!empty($coverpic)){echo "background-image: url('../images/profiles/".$_SESSION['username']."/".$coverpic."');";}else{echo "../images/background.jpg);";} ?> background-size: cover; background-repeat: no-repeat; position: relative; background-position: center center; color: white; margin-top: 1%;">
                    <h3 class="jumbotrontext"><?php echo $_SESSION["username"]."'s shopping cart"; ?></h3>
                </div>
                <?php 
                $selectCartForUserQuery = "SELECT cart.*, foods.name FROM cart LEFT JOIN foods ON cart.food_id = foods.id WHERE cart.status = 'cart' AND cart.user_id = ".$userid;
                $cart = $db->getArray($selectCartForUserQuery);
                $cancer = 0;
                $orderList = "";

                ?>
                    <table class="table text-center" align="center">
                      <thead>
                        <tr>
                          <th scope="col" class="text-center">Item(s)</th>
                          <th scope="col" class="text-center">Quantity</th>
                          <th scope="col" class="text-center">Subtotal</th>
                          <th scope="col" class="text-center">Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1; if(count($cart) > 0): ?>
                      <?php foreach($cart as $cartItem): ?>
                        <tr><?php if($i != 1){$orderList .= "," .$cartItem["id"];}else{$orderList .= $cartItem["id"];} ?>
                            <th scope="row" class="text-center"><?php echo $cartItem["name"]; ?></th>
                            <td ><?php echo $cartItem["quantity"]; ?></td>
                            <td><?php echo $cartItem["subtotal"]." HUF";?></td>
                            <td><button class="btn btn-sm btn-danger" name="deleteitem" onclick="window.location.href='deletefromcart.php?item=<?php echo $cartItem["id"]; ?>'"> Changed my mind..</button></td><?php $cancer = $cancer + intval($cartItem["subtotal"]); ?>
                        </tr><?php $i++; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <tr>
                  <form action="" method="post">
                    <td></td>
                    <td>Total:</td>
                    <td><?php echo $cancer." HUF"; ?></td>
                    <td><button class="btn btn-sm btn-success" name="placeOrder"><i class="fal fa-cart-plus"></i> Place Order</button></td>
                  </form>
                </tr>
            </tbody>
        </table>
            </div>

        </section>

    <?php 
        if (isset($_POST["placeOrder"])) {
            $now = date("Y-m-d H:i:s");

            $insertOrderQuery = "INSERT INTO `orders` (`id`, `items`, `progress`, `user_id`, `total`, `ordered_at`) VALUES (NULL, '$orderList', 'open', '$userid', '$cancer', '$now');";
                
            $insertOrder = $db->query($insertOrderQuery);

            $resetCartQuery = "UPDATE `cart` SET `status` = 'order ' WHERE `cart`.`user_id` = ".$userid;
            $resetCart = $db->query($resetCartQuery);
            echo "<script>window.location.href='../index.php?success=thankyou'</script>";
        }
     ?>

    <br>
    <footer>
        <div class="container" style="margin-bottom: 0 auto;">
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

      $(window).load(function() {
        $('.flexslider').flexslider({
           animation: "slide",
           controlsContainer: ".flexslider-container"
       });
    });
</script>
</body>
</html>