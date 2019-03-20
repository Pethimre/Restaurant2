<?php 
session_start();
error_reporting(E_ALL & ~E_ALL);

/* Prevent Caching */
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include "updateprofile.php";
require_once "uprofile.php";
require_once "ucover.php";
require_once "db.php";

if(!isset($_SESSION["username"])){header("location:../index.php");}
$usertmp = $_SESSION["username"];
$conn = mysqli_connect("localhost", "root", "", "restaurant");
$selectUserData = "SELECT * FROM users WHERE username='$usertmp' LIMIT 1";
$selectUserAddress = "SELECT * FROM addresses WHERE username='$usertmp'";
$selectUserDataQuery = mysqli_query($conn, $selectUserData);
$selecAddressQuery = mysqli_query($conn, $selectUserAddress);
$user = mysqli_fetch_assoc($selectUserDataQuery);
$address = mysqli_fetch_assoc($selecAddressQuery);
$error = mysqli_real_escape_string($conn,$_GET["error"]);
$success =  mysqli_real_escape_string($conn,$_GET["success"]);
$passconf = $user["password"];
(int)$cancer = 0;

$db = db::get();

?>
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
  <link rel="stylesheet" href="../css/sweetalert2.min.css">
  <link rel="stylesheet" href="../css/profile.css">
  <link rel="stylesheet" href="../css/foodform.css">
  <script type="text/javascript" src="../js/script.js"></script>
  <script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>
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

    .gear {
      display: none;
    }

    label.input-custom-file input[type=file] {
      display: none;
    }

    img:hover + .gear, .gear:hover {
      display: inline-block;
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
<body class="bg" data-spy="scroll" data-target="#template-navbar">
  <?php 
  switch ($error) {
   case 'emptyEmail':
   echo "<script>errortext = 'Invalid email entered'; errormsg(errortext);</script>";
   break;

   case 'emptyBa':
   echo "<script>errortext = 'No billing address given'; errormsg(errortext);</script>";
   break;

   case 'emptySa':
   echo "<script>errortext = 'No shipping address given'; errormsg(errortext);</script>";
   break;

   case 'emptyPhone':
   echo "<script>errortext = 'No phone number given'; errormsg(errortext);</script>";
   break;

   case 'emptyFn':
   echo "<script>errortext = 'No Full name given'; errormsg(errortext);</script>";
   break;

   case 'user':
   echo "<script>errortext = 'Invalid username given'; errormsg(errortext);</script>";
   break;

   case 'email':
   echo "<script>errortext = 'Email address already in use'; errormsg(errortext);</script>";
   break;

   case 'largeImg':
   echo "<script>errortext = 'Uploaded picture is too big'; errormsg(errortext);</script>";
   break;

   case 'wrongFileFormat':
   echo "<script>errortext = 'Invalid file format uploaded. Only JPG, GIF, PNG format allowed.'; errormsg(errortext);</script>";
   break;

   case 'noUpload':
   echo "<script>errortext = 'Sorry, there was an error during uploading'; errormsg(errortext);</script>";
   break;

   case 'newPw':
   echo "<script>errortext = 'You havent add new password. No changes made'; errormsg(errortext);</script>";
   break;

   case 'confNewPw':
   echo "<script>errortext = 'You havent confirmed your new password'; errormsg(errortext);</script>";
   break;

   case 'noMatch':
   echo "<script>errortext = 'Your passwords doesnt match'; errormsg(errortext);</script>";
   break;

   case 'wrongPw':
   echo "<script>errortext = 'Wrong password entered. No changes made'; errormsg(errortext);</script>";
   break;

   case 'kek':
   echo "<script>errortext = 'You should change your password'; infomsg(errortext);</script>";
   break;

   default:
     # code...
   break;
 }

 if ($success == "donePw") {
   echo "<script>oktext = 'It is done. Next time you must use your new password for login'; okmsg(oktext);</script>";
 }

 if ($success == "done") {
   echo "<script>oktext = 'Succesful modifications'; okmsg(oktext);</script>";
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
        <li><a href="../index.php"><i class="fal fa-chevron-left"></i> Main Page</a></li>
        <li><a href="#" id="reviewOrders"><i class="fal fa-shopping-cart"></i> Review Orders</a></li>
        <li><a href="#" id="modify"><i class="fal fa-address-card"></i> Modify Profile</a></li>
        <li><a href="#" id="contact"><i class="fal fa-file-signature"></i> Contact Us</a></li>
        <li><a href="logout.php" title="Log Out"><i class="fal fa-sign-out-alt"></i> Logout</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.row -->
</nav>

<div class="container" style="margin-top: 7%">
  <div class="card card-custom bg-white border-white border-0 text-center" style="border-radius: 10px;">
    <div class="card-custom-img" style="<?php if(!empty($user['coverpic'])){echo "background-image: url('../images/Profiles/".$_SESSION['username']."/".$user['coverpic']."');";}else{echo "background-image: url('../images/background.jpg');";} ?>">
     <form action="ucover.php" method="POST" enctype="multipart/form-data">
      <Label class="input-custom-file mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" onclick="setTimeout($('#UploadCover').show('slow'), 1500)">
        <i class="fal fa-cog" title="Change Cover Picture" style="margin-top: 30%; text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black; color: white;"></i>
        <input type="file" name="fileToUpload2" class="fileToUpload2">
      </Label>

      <img class="img-fluid" src="<?php if(!(empty($user["profilepic"]))){ echo '../images/profiles/'.$user['username'].'/'.$user['profilepic']; } else{echo '../images/Logo_main.png';} ?>" />

      <button type="submit" class="btn btn-sm btn-success text-center" id="UploadCover" name="UploadCover" style="border-radius: 50%;"><i class="fal fa-check-circle"></i></button>
    </form>

  </div>
  <div class="card-custom-avatar">

  </div>
  <div class="card-body" style=" display: block;">
    <div class="container">
      <h3 class="card-title text-center">Welcome, <?php echo $usertmp; ?>!</h3>
      <br>
    </div>
    <div id="modifyForm">
      <form method="POST" action="updateprofile.php" enctype="multipart/form-data" >
        <div class="container">

          <input type="text" id="fullName" class="form-control registry" placeholder="Full Name" name="fullName" onfocus="this.style.color='rgba(66,58,58,1)'" value="<?php if(!empty($user['Fullname'])){echo $user['Fullname'];} ?>">

          <input type="text" id="shippaddr" class="form-control registry" placeholder="Shipping Address" name="ShippingAddr" onfocus="this.style.color='rgba(66,58,58,1)'" value="<?php if(!empty($address['shipping_address'])){echo $address['shipping_address'];} ?>">

          <input type="text" id="billaddr" class="form-control registry" placeholder="Billing Address" name="BillingAddr" onfocus="this.style.color='rgba(66,58,58,1)'" value="<?php if(!empty($address['billing_address'])){echo $address['billing_address'];} ?>">

          <input type="tel" class="form-control registry" id="phoneNumber" placeholder="Phone Number" name="phoneNo" onfocus="this.style.color='rgba(66,58,58,1)'" value="<?php if(!empty($user['PhoneNo'])){echo $user['PhoneNo'];} ?>">

          <input type="email" id="email" class="form-control registry" placeholder="Email Address" name="email" onfocus="this.style.color='rgba(66,58,58,1)'" value="<?php if(!empty($user['email'])){echo $user['email'];} ?>">
          <input type="password" class="form-control registry" placeholder="Set Your New Password (Optional)" id="newPw" name="newPassword" onfocus="this.style.color='rgba(66,58,58,1)'">
          
          <input type="password" class="form-control registry" placeholder="Re-Enter New Password (Optional)" id="confirmNewPw" name="confirmNewPassword" onfocus="this.style.color='rgba(66,58,58,1)'">

          <input type="password" class="form-control registry" placeholder="Confirm With Your Password" id="confirmpw" name="password" onfocus="this.style.color='rgba(66,58,58,1)'" required>
          <button class="btn btn-success" name="submit"><i class="fas fa-user-cog"></i> Save Modifications</button>
          <h3 class="text-center" style="background-color: rgba(0,0,0,.33); color: white;">Profile Picture is Optional</h3>
        </form>
        <form action="uprofile.php" method="POST" enctype="multipart/form-data">
          <p>
            <label for="myDragElement" class="dragAndUpload" data-post-string="?todo=test">
              <span class="dragAndUploadIcon">
                <i class="dragAndUploadIconNeutral fas fa-arrow-up"></i>
                <i class="dragAndUploadIconUploading fas fa-cog fa-spin"></i>
                <i class="dragAndUploadIconSuccess fas fa-thumbs-up"></i>
                <i class="dragAndUploadIconFailure fas fa-thumbs-down"></i>
              </span>
              <b class="dragAndUploadText"><span class="dragAndUploadTextLarge">Upload Picture here</span> <span class="dragAndUploadTextSmall"></span></b>
              <i class="dragAndUploadCounter">0%</i>
              <input type="file" multiple="multiple" class="dragAndUploadManual" name="fileToUpload" id="myDragElement" />
            </label>
          </p>
          <button class="btn btn-sm btn-success" name="uploadProfile"><i class="fal fa-camera"></i> Save Profile Picture</button>
        </form>
      </div>
    </div>
      <?php 

      $selectReservations = "SELECT * FROM reservations WHERE user_id = '".$user['id']."' ";
      $allreservations = $db->getArray($selectReservations);

      $selectCartItems = "SELECT cart.*, foods.name FROM cart LEFT JOIN foods ON cart.food_id = foods.id WHERE cart.user_id = ".$user['id'];
      $cartContent = $db->getArray($selectCartItems);

      $selectOrders = "SELECT * FROM orders WHERE user_id = '" .$user["id"]."'";
      $allOrders = $db->getArray($selectOrders);

      ?>

      <!-- Review Modal -->
    <div id="res-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
     <div class="modal-dialog"> 
      <div class="modal-content">                  
       <div class="modal-header"> 
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">*</button> 
         <h4 class="modal-title">
           Reservation Details
         </h4> 
       </div>          
       <div class="modal-body">                   
         <div id="employee-detail">                                        
           <div class="row"> 
             <div class="col-md-12">                         
               <div class="table-responsive">                             
                 <table class="table table-striped table-bordered">
                   <tr>
                     <th>Reservation ID</th>
                     <td id="resid"></td>
                   </tr>                                     
                   <tr>
                     <th>For Who</th>
                     <td id="forwho"></td>
                   </tr>                                         
                   <tr>
                     <th>Booked At:</th>
                     <td id="bookedat"></td>
                   </tr>
                   <tr>
                     <th>Reserved To:</th>
                     <td id="reserve_date"></td>
                   </tr>                                         
                   <tr>
                     <th>People Number</th>
                     <td id="pepoleNo"></td>
                   </tr>                                             
                   <tr>
                     <th>Progress</th>
                     <td id="progress"></td>
                   </tr> 
                   <tr>
                     <th>Message</th>
                     <td id="resmessage"></td>
                   </tr> 

                 </table>                                
               </div>                                       
             </div> 
           </div>                       
         </div>                              
       </div>           
       <div class="modal-footer"> 
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>  
      </div>              
    </div> 
  </div>
</div>
</div>

<form action="insert_contact.php" method="POST" id="contactPanel" style="padding-left: 15px;">
  <input type="text" readonly="true" name="contactor" class="form-control registry" value="<?php echo $user['Fullname']; ?>">
  <input type="email" readonly="true" name="concactEmail" class="form-control registry" value="<?php echo $user['email']; ?>">
  <input type="text" value="" name="subject" class="form-control registry" placeholder=" Subject" required>
  <textarea name="concactMessage" id="message" rows="5" placeholder=" Message" resize="no" class="md-textarea form-control registry" required></textarea>
  <button class="btn btn-success" name="submitContact" id="submitContact"><i class="fal fa-paper-plane"></i> Send Contact</button>
  <br>  <br>
</form>

<div id="reviewOrdersPanel"class="container" style="width: 95%!important;">
  <?php if(count($allreservations) == 0): ?>
    <div class="container text-center" style="background-color: rgba(255,255,255,.5); width: 98%!important; border-radius: 20px;"><h3> No Reservations Yet. </h3>Get some <a href="../index.php" style="text-decoration: none;"><h4>here</h4></a></div><br>
  <?php endif; ?>
  <?php if(count($allreservations) > 0): ?>

    <table class="table" style="background-color: rgba(255,255,255,.25);">
      <thead>
        <tr>
          <th scope="col">Reservation ID:</th>
          <th scope="col">Ordered At</th>
          <th scope="col">Status</th>
          <th scope="col">Review</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($allreservations as $reservations): ?>
          <tr>
            <th scope="row"><?php echo $reservations["id"]; ?></th>
            <td><?php echo $reservations["bookedat"]; ?></td>
            <td><?php echo $reservations["progress"]; ?></td>
            <td><button data-toggle="modal" data-target="#res-modal" data-id="<?php echo $reservations["id"]; ?>" id="getEmployee" class="btn btn-sm btn-success"><i class="fas fa-search"></i>Review</button></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  <?php endif; ?>

  <?php if(count($allOrders) == 0): ?>
    <div class="container text-center" style="background-color: rgba(255,255,255,.5); width: 98%!important; border-radius: 20px;"><h3> No Orders Yet. </h3>Get some <a href="../index.php" style="text-decoration: none;"><h4>here</h4></a></div><br>
  <?php endif; ?>

  <?php if(count($allOrders) > 0): ?>

    <table class="table" style="background-color: rgba(255,255,255,.5); width: 95%!important;">
      <thead>
        <tr>
          <th scope="col">Order ID:</th>
          <th scope="col">Ordered At</th>
          <th scope="col">Status</th>
          <th scope="col">Review</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($allOrders as $orders): ?>
          <tr>
            <th scope="row"><?php echo $orders["id"]; ?></th>
            <td><?php echo $orders["ordered_at"]; ?></td>
            <td><?php echo $orders["progress"]; ?></td>
            <td><a class="btn btn-success" href="order.php?order=<?php echo $orders['id']; ?>"><i class="fas fa-search"></i>Review</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  <?php endif; ?>

    <?php if(count($cartContent) == 0): ?>
    <div class="container text-center" style="background-color: rgba(255,255,255,.5); width: 98%!important; border-radius: 20px;"><h3> Your Cart is empty. </h3><small>If you're hungry, get some food  <a href="../index.php" style="text-decoration: none;"><h4>here</h4></a></small></div><br>
  <?php endif; ?>

  <?php if(count($cartContent) > 0): ?>

    <table class="table text-center" style="background-color: rgba(255,255,255,.5); width: 95%!important; border-radius: 10px;" align="center">
      <thead>
        <tr>
          <th scope="col" class="text-center">Item name</th>
          <th scope="col" class="text-center">Quantity</th>
          <th scope="col" class="text-center">Subtotal</th>
          <th scope="col" class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($cartContent as $cart): ?>
          <tr>
            <th scope="row"><?php echo $cart["name"]; ?></th>
            <td><?php echo $cart["quantity"]; ?></td>
            <td><?php echo $cart["subtotal"]." HUF"; ?></td>
            <td><a class="btn btn-danger" href=""><i class="fal fa-trash-alt"></i> Remove</a></td>
          </tr><?php $cancer = $cancer + intval($cart["subtotal"]); ?>
        <?php endforeach; ?>
        <tr>
          <td><button class="btn btn-sm btn-danger"><i class="fal fa-cart-arrow-down"></i> Empty Cart</button></td>
          <td>Total:</td>
          <td><?php echo $cancer." HUF"; ?></td>
          <td><button class="btn btn-sm btn-success" name="placeOrder"><i class="fal fa-cart-plus"></i> Place Order</button></td>
        </tr>
      </tbody>
    </table>

  <?php endif; ?>

</div> <!-- End review container -->
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
  $("#UploadCover").hide();
  $("#contactPanel").hide();
  $("#reviewOrdersPanel").hide();

  $("#modify").click(function(e) {
    e.preventDefault();
    $("#modifyForm").toggle();

    if($("#reviewOrdersPanel").is(":visible")){
      $("#reviewOrdersPanel").hide();
    }

    if($("#contactPanel").is(":visible")){
      $("#contactPanel").hide();
    }
  });

  $("#contact").click(function(e) {
    e.preventDefault();
    $("#contactPanel").toggle();

    if($("#reviewOrdersPanel").is(":visible")){
      $("#reviewOrdersPanel").hide();
    }

    if($("#modifyForm").is(":visible")){
      $("#modifyForm").hide();
    }
  });

  $("#reviewOrders").click(function(e) {
    e.preventDefault();
    $("#reviewOrdersPanel").toggle();

    if($("#modifyForm").is(":visible")){
      $("#modifyForm").hide();
    }

    if($("#contactPanel").is(":visible")){
      $("#contactPanel").hide();
    }
  });

  $(document).ready(function(){   
   $(document).on('click', '#getEmployee', function(e){  
     e.preventDefault();  
     var empid = $(this).data('id');    
     $('#employee-detail').hide();  
     $.ajax({
      url: 'review.php',
      type: 'POST',
      data: 'empid='+empid,
      dataType: 'json',
      cache: false
    })
     .done(function(data){
      $('#employee-detail').hide();
      $('#employee-detail').show();
      $('#resid').html(data.id);
      $('#forwho').html(data.forWho);
      $('#progress').html(data.progress);
      $('#bookedat').html(data.bookedat);      
      $('#pepoleNo').html(data.pepoleNo);      
      $('#reserve_date').html(data.reserve_date);
      $('#resmessage').html(data.message); 

    })
     .fail(function(){
      $('#employee-detail').html('Error, Please try again...');
    });
   }); 
 });
</script>
<div class="card-footer" style="background: inherit; border-color: inherit;">

</div>
</div>
</body>
</html>