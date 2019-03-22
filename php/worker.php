<?php 

session_start();
require_once"updateworker.php";
error_reporting(E_ALL & ~E_ALL);

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

    function okMsg(oktext)
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

if (isset($error) && $error == "kek") {
  echo "<script> errortext = 'Your should change your password.'; infoMsg(errortext);</script>";
}

if (isset($success) && $success == "done") {
  echo "<script>oktext = 'It is done'; okMsg(oktext);</script>";
}

if (isset($success) && $success == "donePw") {
  echo "<script>oktext = 'It is done. Next time you must use your new password for login'; okMsg(oktext);</script>";
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

          $selectReservations = "SELECT * FROM reservations";
          $allreservations = $db->getArray($selectReservations);

          ?>
          <br>
          <div style="background-color: rgba(255,255,255,.1);" id="reserveList">
            <?php if(count($allreservations) == 0): ?>
              <div class="container text-center" style="background-color: rgba(255,255,255,.5); width: 98%!important; border-radius: 20px;"><h3> No Reservation Yet. </h3></div>
            <?php endif; ?>
            <?php if(count($allreservations) > 0): ?>

              <table class="table" align="center" style="background-color: rgba(255,255,255,.5); width: 98%; border-radius: 10px;">
                <thead>
                  <tr>
                    <th scope="col">Reservation ID:</th>
                    <th scope="col">Ordered At</th>
                    <th scope="col">Status</th>
                    <th scope="col">Reserved By</th>
                    <th scope="col" id="togglerev"><div id="hideRev"><i class="fal fa-eye-slash"></i> Hide</div><div id="showrev"><i class="fal fa-eye"></i> Show</div></th>
                  </tr>
                </thead>
                <tbody class="revitem">
                  <?php foreach($allreservations as $reservations): ?>
                    <tr style="text-align:left;">
                      <th scope="row"><?php echo $reservations["id"]; ?></th>
                      <td><?php echo $reservations["bookedat"]; ?></td>
                      <td><?php echo $reservations["progress"]; ?></td>
                      <td><?php echo $reservations["forWho"]; ?></td>
                      <td><button data-toggle="modal" data-target="#res-modal" data-id="<?php echo $reservations["id"]; ?>" id="getEmployee" onclick="reload()" class="btn btn-sm btn-success"><i class="fas fa-edit"></i>Edit</button></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php endif; ?>
          </div>

        </div>
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

      <!-- Modal 2 -->

      <div id="res-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <form action="admin.php" method="POST">
         <div class="modal-dialog"> 
          <div class="modal-content">                  
           <div class="modal-header"> 
             <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="far fa-times-circle"></i></button> 
             <h3 class="modal-title">
               Reservation Details
             </h3> 
           </div>          
           <div class="modal-body">                   
             <div id="employee-detail">                                        
               <div class="row"> 
                 <div class="col-md-12">                         
                   <div class="table-responsive">        
                     <form action="" method="POST" id="insert_form">                     
                       <table class="table table-striped table-bordered">
                         <tr>
                           <th>Reservation ID</th>
                           <td id=""><input type="text" id="resid" value="" readonly="true" style="border: none; outline: none; text-decoration: none;" name="resid"></td>
                         </tr> 
                         <tr>
                           <th>Reserved By:</th>
                           <td id=""><iframe src="iframe/userid.php" frameborder="0" id="reservedby" height="25px" scrolling="no"></iframe></td>
                         </tr>                                     
                         <tr>
                           <th>For Who</th>
                           <td><input type="text" value="" id="forwho" name="forwho" readonly="true"></td>
                         </tr>                                         
                         <tr>
                           <th>Booked At:</th>
                           <td id=""><input type="date" value="" id="bookedat" name="bookedat" readonly="true"></td>
                         </tr>   
                         <tr>
                           <th>Reserved To: <div id="reservedate"></div></th>
                           <td>
                            <input type="datetime-local" value="" id="newReservedate" name="newReservedate">
                          </td>
                        </tr>  
                        <tr>
                         <th>Reservation Expires: <div id="expire"></div></th>
                         <td>
                          <input type="datetime-local" value="" id="newExpire" name="newExpire">
                        </td>
                      </tr>                                   
                      <tr>
                           <th>People Number</th>
                           <td id=""><input type="number" id="pepoleNo" value="" name="pepoleNo"></td>
                         </tr> 
                         <tr>
                           <th>Message:</th>
                           <td id=""><textarea name="message" id="message" rows="3"></textarea></td>
                         </tr>                                             
                         <tr>
                           <th>Progress</th>
                           <td id=""><input type="text" value="" id="progress" name="progress"></td>
                         </tr> 

                       </table>
                     </form>                                
                   </div>                                       
                 </div> 
               </div>                       
             </div>                              
           </div>           
           <div class="modal-footer"> 
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> 
            <button id="insert" class="btn btn-success" onclick="return validateModal()">Update</button>
          </div>              
        </div> 
      </div>
    </form>
  </div>


  <script>
    $("#profilePanel").hide();
    $("#head").hide();
    $("#showrev").hide();

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

    function reload()
    {
      document.getElementById('reservedby').contentWindow.location.reload();
    }

    function redirect()
    {
      window.location.href = "editres.php"
    }

    function validateModal()
    {
      var forwho = $('#forwho').val();
      var reservedate = $('#newReservedate').val();
      var expire = $('#newExpire').val();
      var pepoleno = $('#pepoleNo').val();
      var message = $('#message').val();
      var progress = $('#progress').val();

      if(forwho != "" || pepoleno != "" || message != "" || progress != "")
      {
        document.cookie = "forwho=" + forwho;
        document.cookie = "reservedate=" + reservedate;
        document.cookie = "expire=" + expire;
        document.cookie = "pepoleno=" + pepoleno;
        document.cookie = "message=" + message;
        document.cookie = "progress=" + progress;
        redirect();
      }

      else
      {
        alert("All gaps must be filled in order to update reservation.");
      }
    }

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
        $('#resid').val(data.id);
        $('#forwho').val(data.forWho);
        $('#progress').val(data.progress);
        $('#bookedat').val(data.bookedat);      
        $('#reservedate').html(data.reserve_date);      
        $('#expire').html(data.reserve_date_end);      
        $('#pepoleNo').val(data.pepoleNo);      
        $('#message').val(data.message);

        document.cookie = "userid="+data.user_id;
        document.cookie = "id="+data.id;
        document.getElementById('reservedby').contentWindow.location.reload();

      })
       .fail(function(){
        $('#employee-detail').html('Error, Please try again...');
      });
     }); 
   });
 </script>

</body>
</html>