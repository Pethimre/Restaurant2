<?php 

session_start();
#error_reporting(E_ALL & ~E_ALL);

/* Prevent Caching */
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include "php/insert_profile.php";
require_once "php/ucover.php";

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
require_once "php/db.php";
$db = db::get();


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
          <li><a href="#" id="reviewOrders">Review Orders</a></li>
          <li><a href="#" id="modify">Modify Profile</a></li>
          <li><a href="#" id="contact">Contact Us</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.row -->
  </nav>

  <div class="container" style="margin-top: 7%">
    <div class="card card-custom bg-white border-white border-0 text-center" style="border-radius: 10px; background-color: rgba(255,255,255,.5);">
      <div class="card-custom-img" style="<?php if(!empty($user['coverpic'])){echo "background-image: url('../images/Profiles/".$_SESSION['username']."/".$user['coverpic']."');";}else{echo "background-image: url('../images/background.jpg');";} ?>">
       <form action="ucover.php" method="POST" enctype="multipart/form-data">
        <Label class="input-custom-file mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" onclick="setTimeout($('#UploadCover').show('slow'), 1500)">
          <i class="fal fa-cogs" style="margin-top: 30%;"></i>
          <input type="file" name="fileToUpload2" class="fileToUpload2">
        </label>

        <img class="img-fluid" src="<?php if(!(empty($user["profilepic"]))){ echo '../images/profiles/'.$user['username'].'/'.$user['profilepic']; } else{echo '../images/Logo_main.png';} ?>" />

        <button type="submit" class="btn btn-sm btn-success" id="UploadCover" name="UploadCover">Ok</button>
      </form>

    </div>
    <div class="card-custom-avatar">

    </div>
    <div class="card-body" style=" display: block;">
      <div class="container">
        <h3 class="card-title text-center">Welcome, <?php echo $usertmp; ?>!</h3>
        <br>
      </div>

      <form method="POST" action="insert_profile.php" enctype="multipart/form-data" id="modifyForm">
        <div class="container">

          <input type="text" id="fullName" class="form-control registry" placeholder="Full Name" name="fullName" onfocus="this.style.color='rgba(66,58,58,1)'" value="<?php if(!empty($user['Fullname'])){echo $user['Fullname'];} ?>">

          <input type="text" id="shippaddr" class="form-control registry" placeholder="Shipping Address" name="ShippingAddr" onfocus="this.style.color='rgba(66,58,58,1)'" value="<?php if(!empty($address['shipping_address'])){echo $address['shipping_address'];} ?>">

          <input type="text" id="billaddr" class="form-control registry" placeholder="Billing Address" name="BillingAddr" onfocus="this.style.color='rgba(66,58,58,1)'" value="<?php if(!empty($address['billing_address'])){echo $address['billing_address'];} ?>">

          <input type="tel" class="form-control registry" id="phoneNumber" placeholder="Phone Number" name="phoneNo" onfocus="this.style.color='rgba(66,58,58,1)'" value="<?php if(!empty($user['PhoneNo'])){echo $user['PhoneNo'];} ?>">

          <input type="email" id="email" class="form-control registry" placeholder="Email Address" name="email" onfocus="this.style.color='rgba(66,58,58,1)'" value="<?php if(!empty($user['email'])){echo $user['email'];} ?>">

          <input type="password" class="form-control registry" placeholder="Set Your New Password" id="newPw" name="newPassword" onfocus="this.style.color='rgba(66,58,58,1)'">
          <input type="password" class="form-control registry" placeholder="Re-Enter New Password" id="confirmNewPw" name="confirmNewPassword" onfocus="this.style.color='rgba(66,58,58,1)'">

          <input type="password" class="form-control registry" placeholder="Confirm With Your Password" id="confirmpw" name="password" onfocus="this.style.color='rgba(66,58,58,1)'" required="true">
          <h3 class="text-center" style="color: white;">Profile Picture is Optional</h3>
          <p>
            <label for="myDragElement" class="dragAndUpload" data-post-string="?todo=test">
              <span class="dragAndUploadIcon">
                <i class="dragAndUploadIconNeutral fas fa-arrow-up"></i>
                <i class="dragAndUploadIconUploading fas fa-cog fa-spin"></i>
                <i class="dragAndUploadIconSuccess fas fa-thumbs-up"></i>
                <i class="dragAndUploadIconFailure fas fa-thumbs-down"></i>
              </span>
              <b class="dragAndUploadText"><span class="dragAndUploadTextLarge">Upload Profile Picture here</span> <span class="dragAndUploadTextSmall"></span></b>
              <i class="dragAndUploadCounter">0%</i>
              <input type="file" multiple="multiple" class="dragAndUploadManual" name="fileToUpload" id="myDragElement" />
            </label>
          </p>
        </form>

        <form action="insert_contact.php" method="POST" id="contactPanel" style="padding-left: 15px;">
          <input type="text" readonly="true" name="contactor" class="form-control registry" value="<?php echo $user['Fullname']; ?>">
          <input type="email" readonly="true" name="concactEmail" class="form-control registry" value="<?php echo $user['email']; ?>">
          <input type="text" value="" name="subject" class="form-control registry" placeholder=" Subject" required="true">
          <textarea name="concactMessage" id="message" rows="5" placeholder=" Message" resize="no" class="md-textarea form-control registry" required="true"></textarea>
          <button class="btn btn-success" name="submitContact" id="submitContact"><i class="fal fa-paper-plane"></i> Send Contact</button>
          <br>  <br>
        </form>

        <script>
          $("#changePw").click(function(e) {
            e.preventDefault();

          });

          var fullName = $("#fullName").val();
          var Billing = $("#billaddr").val();
          var Shipping = $("#shippaddr").val();
          var phone = $("#phoneNumber").val();
          var email = $("#email").val();
          var confirm = $("#confirmpw").val();

          if(fullName === "" || Billing === "" || Shipping === "" || phone === "" || email === "" || confirm)
          {
            message = 'You need to fill all the gaps!';
            errormsg();
          }

        function errormsg()
        {
          Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: message,
            footer: 'Every field necessary.'
          })
        }

        function okmsg()
        {
          Swal.fire({
            position: 'center',
            type: 'success',
            title: message,
            showConfirmButton: false,
            timer: 1500
          })
        }
      </script>

      <?php 

      $selectReservations = "SELECT * FROM reservations WHERE user_id = '".$user['id']."' ";
      $allreservations = $db->getArray($selectReservations);

      $selectOrders = "SELECT * FROM orders WHERE user_id = '" .$user["id"]."'";
      $allOrders = $db->getArray($selectOrders);

      ?>

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
                  <td><a class="btn btn-success" href=""><i class="fas fa-search"></i>Review</a></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

        <?php endif; ?>
      </div> <!-- End review container -->

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
                       <th>Price</th>
                       <td id="price"></td>
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
      if(data.price == 0){ $('#price').html("Not Paid yet.");}
      else{$('#price').html(data.price);}
      $('#resmessage').html(data.message); 

    })
     .fail(function(){
      $('#employee-detail').html('Error, Please try again...');
    });
   }); 
 });
</script>
</div>
</div>
<div class="card-footer" style="background: inherit; border-color: inherit;">

</div>
</body>
</html>