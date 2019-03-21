<?php 

session_start();
require_once"updateworker.php";
require_once "editinvertory.php";
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

  .shadow {
   -moz-box-shadow:    inset 0 0 5px #000000;
   -webkit-box-shadow: inset 0 0 5px #000000;
   box-shadow:         inset 0 0 5px #000000;
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

  if (isset($error) && $error == "kek") {
  echo "<script> errortext = 'Your should change your password.'; infoMsg(errortext);</script>";
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
          <li><a href="../index.php"><i class="fal fa-chevron-left"></i><i class="fal fa-chevron-left"></i>Main Page</a></li>
          <li><a href="#" id="modify"><i class="fal fa-address-card"></i>Modify Profile</a></li>
          <li><a href="logout.php" title="Log Out"><i class="fal fa-sign-out-alt"></i> Logout</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.row -->
  </nav>

  <div class="container" style="margin-top: 7%">
    <div class="card card-custom bg-white border-white border-0 text-center" style="border-radius: 10px; background-color: rgba(255,255,255,.5);">
      <div class="card-custom-img" id="invertoryPanel">
        <div id="ordercontent">
          <?php 
          require_once "db.php";
          $db = db::get();

          $selectitem = "SELECT * FROM wrappers";
          $allItems = $db->getArray($selectitem);

          ?>
          <br>
          <div class="container" style="width: 98%;">
            <?php $selectAllItem = "SELECT * FROM wrappers"; $allitem = $db->getArray($selectAllItem); ?>
            <?php if(count($allitem) == 0): ?>
              <div class="text-center" data-toggle="modal" data-target="#exampleModal" style="background-color: rgba(255,255,255,.5); border-radius: 15px;"><h3> No Items on list. <br> <i class="fal fa-plus-circle"></i> New Item</h3></div>
            <?php endif; ?>
            <?php if(count($allitem) > 0): ?>

              <table class="table" style="background-color: rgba(255,255,255,.5); border-radius: 10px;">
                <thead>
                  <tr><!-- -->
                    <th><input style="border-radius: 10px; background-color: rgba(255,255,255, .5); border:none; width: 100%;" id="searchInv" type="text" placeholder=" Search.."></th>
                    <th>Wrapper</th>
                    <th>Quantity</th>
                    <th>Edited at</th>
                    <th><button  id="newitemInv" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fal fa-plus-circle"></i> New Item</button> </th>
                  </tr>
                </thead>
                <tbody id="invTable">
                  <?php foreach($allitem as $item): ?>
                    <tr>
                      <td><button data-toggle="modal" data-target="#inv-modal" data-id="<?php echo $item["id"]; ?>" id="getInv" class="btn btn-sm btn-success"><i class="fas fa-edit"></i>Edit</button></td>
                      <th scope="row"><?php echo $item["wrappername"]; ?></th>
                      <td><?php echo $item["quantity"]; ?></td>
                      <td><?php echo $item["last_update_by"]; ?></td>
                      <td><button class="btn btn-sm btn-danger" name="deleteItem" onclick="window.location.href='deleteitem.php?item=<?php echo $item['id']; ?>'"><i class="fas fa-trash"></i> Delete</button></td>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body" style="background-color: rgba(255,255,255,.6);">
        <form id="newITemPanel" method="POST" action="insertItem.php">
              <div class="form-group">
                <label for="invWrapperName" style="color: black;">Wrapper Name</label>
                <input type="text" class="form-control registry shadow" id="invWrapperName" name="wrname" required="true">
              </div>
              <div class="form-group">
                <label for="InvItemQuantity" style="color: black;">Quantity</label>
                <input type="number" class="form-control registry shadow" name="wrquantity" id="InvItemQuantity" required="true">
              </div>
              <button class="btn btn-primary" name="addInvItem"><i class="fas fa-plus"></i> Add item</button>
            </form>
      </div>
    </div>
  </div>
</div>

      <!-- Invertory Modal -->

      <div id="inv-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <form action="" method="POST">
         <div class="modal-dialog"> 
          <div class="modal-content">                  
           <div class="modal-header"> 
             <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="far fa-times-circle"></i></button> 
             <h4 class="modal-title">
               Wrapper Details
             </h4> 
           </div>          
           <div class="modal-body">                   
             <div id="employee-detail">                                        
               <div class="row"> 
                 <div class="col-md-12">                         
                   <div class="table-responsive">        
                     <form action="" method="POST" id="insert_form">                     
                       <table class="table table-striped table-bordered">
                         <tr>
                           <th>Wrapper id</th>
                           <td><input type="text" id="wrapperid" value="" name="wrapperid" readonly="true" style="border: none; text-decoration: none; background:transparent;"></td>
                         </tr> 
                         <tr>
                           <th>Wrapper name</th>
                           <td><input type="text" id="wrapper_name" value="" name="wrapper_name"></td>
                         </tr> 
                         <tr>
                           <th>Updated By:</th>
                           <td><input type="text" id="Inv_updated_by" readonly="true" style="border:none; text-decoration: none; background: transparent;"></td>
                         </tr>                                     
                         <tr>
                           <th>Quantity</th>
                           <td><input type="number" value="" id="wrapper_quantity" name="wrapper_quantity"></td>
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
            <button id="insert" class="btn btn-success" name="updateINvItem" onclick="return invModal()">Update</button>
          </div>              
        </div> 
      </div>
    </form>
  </div>

  <div class="card-footer">

  </div>
</div>

<script>
  $("#head").hide();
  $("#modifyForm").hide();
  $("#newITemPanel").hide();


  $("#modify").click(function(e) {
    e.preventDefault();
    $("#modifyForm").toggle();
    $("#head").toggle();
    $("#invertoryPanel").toggle();

    if($("#newITemPanel").is(":visible")){
    $("#newITemPanel").hide();
    }

  });

    $("#newitemInv").click(function(e) {
    e.preventDefault();
    $("#modifyForm").toggle();

    if($("#modifyForm").is(":visible")){
    $("#modifyForm").hide();
    }

    if($("#head").is(":visible")){
    $("#head").hide();
    }

  });

  $("#newitemInv").click(function(e) {
  e.preventDefault();
  $("#newITemPanel").toggle();

  });

  $(document).ready(function(){   
   $(document).on('click', '#getInv', function(e){  
     e.preventDefault();  
     var invid = $(this).data('id');    
     $('#invertory-detail').hide();  
     $.ajax({
      url: 'reviewinvertory.php',
      type: 'POST',
      data: 'invid='+invid,
      dataType: 'json',
      cache: false
    })
     .done(function(data){
      $('#invertory-detail').hide();
      $('#invertory-detail').show();
      $('#wrapperid').val(data.id);
      $('#wrapper_name').val(data.wrappername);
      $('#Inv_updated_by').val(data.last_update_by);
      $('#wrapper_quantity').val(data.quantity);
      
      document.cookie = "invid="+data.id;

    })
     .fail(function(){
      $('#invertory-detail').html('Error, Please try again...');
    });
   }); 
 });


  $(document).ready(function(){
    $("#searchInv").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#invTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });

  function invModal()
  {
    var wrapperid = $('#wrapperid').val();
    var wrapperName = $('#wrapper_name').val();
    var wrapperQuantity = $('#wrapper_quantity').val();
    var InvUpdatedBy = $('#Inv_updated_by').val();

    if(wrapperName == "" || wrapperQuantity == "" || InvUpdatedBy == "")
    {
      alert("All gaps must be filled!");
    }

    else
    {
      document.cookie = "wrapperid=" + wrapperid;
      document.cookie = "wrapperName=" + wrapperName;
      document.cookie = "wrapperQuantity=" + wrapperQuantity;
      document.cookie = "InvUpdatedBy=" + InvUpdatedBy;
      redirectInv();
    }
  }

  function redirectInv()
  {
    window.location.href = "editinvertory.php";
  }

</script>

</body>
</html>