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

$selectUserRoleQuery = "SELECT role_id FROM users WHERE username ='".$_SESSION["username"]."'";
$selectUser = $db->getArray($selectUserRoleQuery);

  foreach ($selectUser as $user) {
    $roleid = $user["role_id"];
    }

?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo $_SESSION["username"] ."'s order"; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/main.css">
  <script src="../js/jquery-1.11.2.min.js"></script>
  <script type="text/javascript" src="../js/jquery.flexslider.min.js"></script>
  <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon"/>
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

    label.input-custom-file input[type=file] {
      display: none;
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
          <li><a href="../index.php"><i class="fal fa-chevron-left"></i><i class="fal fa-chevron-left"></i> Main Page</a></li>
          <?php if($roleid == 2): ?><li><a href="profile.php"><i class="fal fa-chevron-left"></i> Profile</a></li><?php endif; ?>
          <?php if($roleid == 1): ?><li><a href="admin.php"><i class="fal fa-chevron-left"></i> Admin Page</a></li><?php endif; ?>
          <?php if($roleid != 1 && $roleid != 2): ?><li><a href="router.php"><i class="fal fa-chevron-left"></i> Dashboard</a></li><?php endif; ?>
          <li><a href="logout.php" title="Log Out"><i class="fal fa-sign-out-alt"></i> Logout</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.row -->
  </nav>

  <?php 
      $selectOrderedItemsQuery = "SELECT * FROM orders WHERE id =".$order;
      $orders = $db->getArray($selectOrderedItemsQuery);

      foreach ($orders as $order) {
        $tmp = $order["items"];
        $total = $order["total"];
        $progress = $order["progress"];
      }

      $list = explode(",", $tmp);

      if ($roleid == 2) {
      $selectUserData = "SELECT profilepic, coverpic FROM users WHERE username ='".$_SESSION["username"]."'";
      $getUserData = $db->getArray($selectUserData);
      foreach ($getUserData as $user) {
        $cover = $user["coverpic"];
        $profile = $user["profilepic"];
      }
      }
        
             
   ?>

  <div class="container" style="margin-top: 7%">
    <div class="card card-custom bg-white border-white border-0 text-center" style="border-radius: 10px; background-color: rgba(255,255,255,.5);">
      <div class="card-custom-img" style="<?php if(!empty($cover)){echo "background-image: url('../images/Profiles/".$_SESSION['username']."/".$cover."');";}else{echo "background-image: url('../images/background.jpg');";} ?>">
       <?php if($roleid == 2): ?>
       <form action="ucover.php" method="POST" enctype="multipart/form-data">
        <Label class="input-custom-file mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" onclick="setTimeout($('#UploadCover').show('slow'), 1500)">
          <i class="fal fa-cog" title="Change Cover Picture" style="margin-top: 30%; text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black; color: white;"></i>
          <input type="file" name="fileToUpload2" class="fileToUpload2">
        </Label>

        <img class="img-fluid" src="<?php if(!(empty($profile))){ echo '../images/profiles/'.$_SESSION['username'].'/'.$profile; } else{echo '../images/Logo_main.png';} ?>" />

        <button type="submit" class="btn btn-sm btn-success text-center" id="UploadCover" name="UploadCover" style="border-radius: 50%;"><i class="fal fa-check-circle"></i></button>
      </form>
    <?php endif; ?>
    </div>
      <div class="card-custom-avatar">
      </div>
      <div class="container">
        <div class="card-body" style="display: block;">
          <?php if(count($orders) > 0): ?>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col" class="text-center">Item's name</th>
                  <th scope="col" class="text-center">Quantity</th>
                  <th scope="col" class="text-center">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <?php
                for ($i=0; $i < count($list); $i++) :
                  $selectOrderedItemsQuery = "SELECT cart.food_id, cart.quantity, cart.subtotal, foods.name FROM cart LEFT JOIN foods ON cart.food_id = foods.id WHERE cart.id =".$list[$i];
                  $getOrderedElement = $db->getArray($selectOrderedItemsQuery);
                  ?>
                  <?php foreach ($getOrderedElement as $element) : ?>
                  <tr>
                    <td><?php echo $element["name"]; ?></td>
                    <td><?php echo $element["quantity"]; ?></td>
                    <td><?php echo $element["subtotal"]; ?></td>
                  </tr>
                <?php  endforeach; ?>
                <?php  endfor; ?>
                <tr>
                  <td>
                    <b>Status:</b> <?php echo $progress; ?>
                   <?php if($roleid == 1): ?>
                    <div id="openStatusUpdate"> <i class="fas fa-cog"></i></div>
                    <form action="updateorder.php?order=<?php echo $order['id']; ?>" method="post">
                      <select name="statusUpdate" id="statusUpdate">
                        <option value="">Status Udate here</option>
                        <option value="open">Open</option>
                        <option value="delivered">Delivered</option>
                        <option value="suspended">Suspended</option>
                        <option value="cancelled">Cancelled</option>
                      </select>
                      <button class="btn btn-sm btn-success" name="updateStatus" id="updateStatus"><i class="far fa-check"></i> Submit</button>
                    </form>
                  <?php endif; ?>
                  </td>
                  <td>Total:</td>
                  <td><?php echo $total." HUF"; ?></td>
                </tr>
          </tbody>
          </table>
          <?php endif; ?>
        </div>

        <div class="card-footer">

        </div>
      </div>
  <script>
    $("#UploadCover").hide();
    $("#statusUpdate").hide();
    $("#updateStatus").hide();

      $("#openStatusUpdate").click(function(e) {
    e.preventDefault();
    $("#statusUpdate").toggle();
    $("#updateStatus").toggle();
  });
  </script>
    </body>
    </html> 