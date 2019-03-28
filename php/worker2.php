<?php 

session_start();
require_once"updateworker.php";
//error_reporting(E_ALL & ~E_ALL);

/* Prevent Caching */
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if(!isset($_SESSION["username"])){header("location:../index.php");}
$usertmp = $_SESSION["username"];
$conn = mysqli_connect("localhost", "root", "", "restaurant");
$selectUserData = "SELECT * FROM users WHERE username='$usertmp' LIMIT 1";
$selectUserAddress = "SELECT * FROM addresses WHERE username='$usertmp'";
$selectUserDataQuery = mysqli_query($conn, $selectUserData);
$selecAddressQuery = mysqli_query($conn, $selectUserAddress);
$user = mysqli_fetch_assoc($selectUserDataQuery);
$address = mysqli_fetch_assoc($selecAddressQuery);
$passconf = $user["password"];

$error = mysqli_real_escape_string($conn,$_GET["error"]);
$success =  mysqli_real_escape_string($conn,$_GET["success"]);

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

    function errorMsg(errortext)
    {
      Swal.fire({
        type: 'error',
        title: 'Oops...',
        text: errortext + "!",
        footer: ''
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
<?php 
if (isset($error) && $error == "empty") {
  echo "<script> errortext = 'Every necessary gaps must be filled'; errorMsg(errortext);</script>";
}

if (isset($error) && $error == "newPw") {
  echo "<script> errortext = 'Your new password was given insufficently. Your password havent been changed'; errorMsg(errortext);</script>";
}

if (isset($error) && $error == "confNewPw") {
  echo "<script> errortext = 'You havent re-entered your new password. Your password havent been changed'; errorMsg(errortext);</script>";
}

if (isset($error) && $error == "noMatch") {
  echo "<script> errortext = 'The 2 password doesnt match. Your password havent been changed'; errorMsg(errortext);</script>";
}

if (isset($error) && $error == "wrongPw") {
  echo "<script> errortext = 'You entered your password incorrectly. No changes commited.'; errorMsg(errortext);</script>";
}

if (isset($error) && $error == "wrongEmail") {
  echo "<script> errortext = 'Incorrect Email entered.'; errorMsg(errortext);</script>";
}

if (isset($success) && $success == "done") {
  echo "<script>oktext = 'It is done'; okmsg(oktext);</script>";
}

if (isset($success) && $success == "donePw") {
  echo "<script>oktext = 'It is done. Next time you must use your new password for login'; okmsg(oktext);</script>";
}

if (isset($error) && $error == "error") {
  echo "<script> errortext = 'Invalid id entered.'; errorMsg(errortext);</script>";
}

 ?>
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
          <li><a href="#" id="modify"><i class="fal fa-address-card"></i> Modify Profile</a></li>
          <li><a href="logout.php" title="Log Out"><i class="fal fa-sign-out-alt"></i> Logout</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.row -->
  </nav>

  <div class="container" style="margin-top: 7%">
    <div class="card card-custom bg-white border-white border-0 text-center" style="border-radius: 10px; background-color: rgba(255,255,255,.5);">
      <div class="card-custom-img" id="modifyReserve">
        <div id="ordercontent">
          <?php 
          require_once "db.php";
          $db = db::get();

          $selectOrders = "SELECT orders.*, users.username FROM orders LEFT JOIN users ON orders.user_id = users.id WHERE orders.progress = 'open' OR orders.progress = 'suspended'";
          $allorders = $db->getArray($selectOrders);

          ?>
          <br>
          <div style="background-color: rgba(255,255,255,.1);" id="reserveList">
            <?php if(count($allorders) == 0): ?>
              <div class="container text-center" style="background-color: rgba(255,255,255,.5); width: 98%!important; border-radius: 20px;"><h3> No Orders at the moment. </h3></div>
            <?php endif; ?>
            <?php if(count($allorders) > 0): ?>

              <table class="table" align="center" style="background-color: rgba(255,255,255,.5); width: 98%; border-radius: 10px;">
                <thead>
                  <tr>
                    <th scope="col">Reservation ID:</th>
                    <th scope="col">Ordered At</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ordered By</th>
                    <th scope="col">Destination:</th>
                    <th scope="col" id="togglerev"><div id="hideRev"><i class="fal fa-eye-slash"></i> Hide</div><div id="showrev"><i class="fal fa-eye"></i> Show</div></th>
                  </tr>
                </thead>
                <tbody class="revitem">
                  <?php foreach($allorders as $orders): ?>
                    <tr style="text-align:left;"><form action="updateorder.php?item=<?php echo $orders['id']; ?>" method="post">
                      <?php 
                          $getCurrentAddressQuery = "SELECT shipping_address FROM addresses WHERE username = '".$orders["username"]."'";
                          $currentAddress = $db->getArray($getCurrentAddressQuery);
                       ?>
                      <th scope="row"><?php echo $orders["id"]; ?></th>
                      <td><?php echo $orders["ordered_at"]; ?></td>
                      <td><?php echo $orders["progress"]; ?></td>
                      <td><?php echo $orders["username"]; ?></td>
                      <td><?php foreach($currentAddress as $address){echo $address["shipping_address"];} ?></td>
                      <td>
                        <select name="statusUpdate">
                          <option value="delivered">Delivered</option>
                          <option value="suspended">Suspended</option>
                          <option value="canceled">Canceled</option>
                        </select>
                        <button class="btn btn-sm btn-success" name="updateOrder"><i class="fas fa-edit"></i> Edit</button>
                      </td>
                    </tr></form>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php endif; ?>
          </div>

        </div>
      </div>
      <div class="card-custom-avatar">
      </div>
     <div class="container">
      <div class="card-body" style="display: block;">
        
        <div class="jumbotron text-center" id="head" style="background-image: url('https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/intermediary/f/d785543a-4d1a-4c2c-9023-ecbf90a7dd5f/davh3nf-cdc58872-2e42-4368-88eb-8b51bf434597.png/v1/fill/w_1382,h_578,q_70,strp/abstract_wallpaper_for_ultrawide_by_kanttii_davh3nf-pre.jpg'); width: 98%; margin-top: 0.5%;">
              <h2>Edit Profile</h2>
            </div>

          <div id="profilePanel">
            <form method="POST" action="updateworker.php" enctype="multipart/form-data" id="modifyForm">
              <div class="container" style="width: 98%;">
                
                <input type="tel" class="form-control registry" id="phoneNumber" placeholder="Phone Number" name="phoneNo" onfocus="this.style.color='rgba(66,58,58,1)'" value="<?php if(!empty($user['PhoneNo'])){echo $user['PhoneNo'];} ?>">
                
                <input type="email" id="email" class="form-control registry" placeholder="Email Address" name="email" onfocus="this.style.color='rgba(66,58,58,1)'" value="<?php if(!empty($user['email'])){echo $user['email'];} ?>">
                
                <input type="password" class="form-control registry" placeholder="Set Your New Password" id="newPw" name="newPassword" onfocus="this.style.color='rgba(66,58,58,1)'">
                <input type="password" class="form-control registry" placeholder="Re-Enter New Password" id="confirmNewPw" name="confirmNewPassword" onfocus="this.style.color='rgba(66,58,58,1)'">
                
                <input type="password" class="form-control registry" placeholder="Confirm With Your Password" id="confirmpw" name="password" onfocus="this.style.color='rgba(66,58,58,1)'" required="true">

                <button name="updateWorker" id="updateWorker" class="btn-success btn"><i class="fal fa-user-cog"></i> Update</button>
                <br>   <br>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="card-footer">

      </div>
    </div>

     
  <script>
    $("#profilePanel").hide();
    $("#showrev").hide();
    $("#head").hide();

    $("#modify").click(function(e) {
    e.preventDefault();
      $("#profilePanel").toggle();
      $("#head").toggle();
      $("#modifyReserve").toggle();
    });

    $("#togglerev").click(function(e) {
      e.preventDefault();
      $("#hideRev").toggle();
      $("#showrev").toggle();
      $(".revitem").toggle("slow");
    });
 </script>

</body>
</html> 