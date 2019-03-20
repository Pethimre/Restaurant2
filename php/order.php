<?php 

session_start();
require_once"updateworker.php";
require_once"db.php";
//error_reporting(E_ALL & ~E_ALL);

/* Prevent Caching */
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if(!isset($_SESSION["username"])){header("location:../index.php");}

$db = db::get();

$order = $db->escape($_GET["order"]);

?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo $_SESSION["username"] ."'s dashboard"; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/main.css">
  <script src="../js/jquery-1.11.2.min.js"></script>
  <script type="text/javascript" src="../js/jquery.flexslider.min.js"></script>
  <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon"/>
  <link rel="stylesheet" type="text/css" href="../css/dragndrop.css">
  <link rel="stylesheet" href="../css/sweetalert2.min.css">
  <link rel="stylesheet" href="../css/profile.css">
  <link rel="stylesheet" href="../css/foodform.css">
  <script type="text/javascript" src="../js/script.js"></script>
  <script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script type="text/javascript">
    $(window).load(function() {
      $('.flexslider').flexslider({
        animation: "slide",
        controlsContainer: ".flexslider-container"
      });
    });
  </script>
  <style>
    .registry
    {
      background-color: rgba(255,255,255,.74);
      border-color: rgba(255,255,255,0.3);
      border-radius: 10px;
      height: 30px;
      width: 98%;
    }

    input::placeholder {
      color: rgba(66,58,58,1)!important;
      text-align: left!important;
    }

    input[readonly] {
      background-color: rgba(255,255,255,.74)!important;
    }

    textarea::placeholder {
      color: rgba(66,58,58,1)!important;
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
          <li><a href="../index.php"><i class="fal fa-chevron-left"></i> Main Page</a></li>
          <li><a href="logout.php" title="Log Out"><i class="fal fa-sign-out-alt"></i> Logout</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.row -->
  </nav>

  <?php 
      $selectOrderedItemsQuery = "SELECT * FROM orders WHERE id =".$order;
      $orders = $db->getArray($selectOrderedItemsQuery);
   ?>

  <div class="container" style="margin-top: 7%">
    <div class="card card-custom bg-white border-white border-0 text-center" style="border-radius: 10px; background-color: rgba(255,255,255,.5);">
      <div class="card-custom-img" id="modifyReserve">
      </div>
      <div class="card-custom-avatar">
      </div>
      <div class="container">
        <div class="card-body" style="display: block;">
          <?php if(count($orders) > 0): ?>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($orders as $order): ?>
                  <tr>
                    <td><?php echo $order["items"]; ?></td>
                  </tr>
                <?php endforeach; ?>
          </tbody>
          </table>
          <?php endif; ?>
        </div>

        <div class="card-footer">

        </div>
      </div>

    </body>
    </html> 