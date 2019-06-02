<?php 

  session_start();
  error_reporting(E_ALL & ~E_NOTICE); //Hide php notifications on the page
  
  /* Prevent Caching */
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");

  require_once "upload.php";
  require_once "newreview.php";
  require_once "addworker.php";
  require_once "editinvertory.php";
  require_once "db.php";
  
  if (($_SESSION["username"])) 
  {
    $db = db::get();

    $routingQuery = "SELECT role_id FROM users WHERE username ='".$_SESSION["username"]."'";
    $routing = $db->query($routingQuery);
    foreach($routing as $routmp){$roles=$routmp;}
    $role = $roles["role_id"];
    $role = (int)$role;

    if (isset($_GET["error"])) {
      $error = $db->escape($_GET["error"]);
    }

    if (isset($_GET["success"])) {
      $success = $db->escape($_GET["success"]);
    }

    switch ($role) {
      case 1:
      break;

      case 2:
        header("location: ../index.php"); //user role
        break;

        case 3:
        header("location: worker.php"); //receotionist role
        break;

        case 4:
        header("location: worker2.php"); //courier role
        break;

        case 5:
        header("location: worker3.php"); //waiter role
        break;

        default:
        header("location: ../index.php"); //in case of wtf
        break;
      }
    }
    else
    {
      header("location: ../index.php");
    }

    $errors = array();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
     <title>Admin Page</title>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.min.css">
     <link rel="stylesheet" href="../css/bootstrap.min.css">
     <link rel="stylesheet" href="../css/main.css">
     <script src="../js/jquery-1.11.2.min.js"></script>
     <link rel="stylesheet" type="text/css" href="../css/dragndrop.css">
     <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon"/>
     <link rel="stylesheet" href="../css/sweetalert2.min.css">
     <script src="../js/sweetalert2.all.min.js"></script>
     <script type="text/javascript">
      $(window).load(function() {
        $('.flexslider').flexslider({
          animation: "slide",
          controlsContainer: ".flexslider-container"
        });
      });
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
    <style>
      .bg 
      { 
       background-image: url("../images/bg.jpg");
       background-repeat: no-repeat;
       background-size: cover;
     }
     .registry
     {
      background-color: rgba(255,255,255,.74);
      border-color: rgba(255,255,255,0.3);
      height: 30px;
    }

    ::-webkit-scrollbar {
      width: 10px;
    }

    ::-webkit-scrollbar-track {
      background: #ddd;
    }

    ::-webkit-scrollbar-thumb {
      background: #666;
    }

    input::placeholder {
      color: rgba(66,58,58,1)!important;
    }
    textarea::placeholder {
      color: rgba(66,58,58,1)!important;
    }
    iframe
    {
      overflow: hidden;
    }

    .ui-select
    {
      width: 100%
    }
    select::-ms-expand 
    {  
      display: none; 
    }

    select
    {
      -webkit-appearance: none;
      appearance: none;
    }

    .invTableItem
    {
      text-decoration: none;
      border: none;
      background: transparent;
    }

  </style>
</head>
<body class="bg info" data-spy="scroll" data-target="#template-navbar">
  <?php 

  switch ($error) {
    case 'closed':
      echo "<script>oktext = 'We are not opened on that interval.'; errormsg(oktext);</script>";
      break;

    case 'empty':
      echo "<script>oktext = 'Every gap must be filled.'; errormsg(oktext);</script>";
      break;

    case 'wrongPW':
      echo "<script>oktext = 'Invalid password entered.'; errormsg(oktext);</script>";
      break;

    case 'shortPW':
      echo "<script>oktext = 'New password must be at least 8 characters long.'; errormsg(oktext);</script>";
      break;

    case 'noMatch':
      echo "<script>oktext = 'The given passwords doesnt match.'; errormsg(oktext);</script>";
      break;

    case 'imageExists':
      echo "<script>oktext = 'Image already exists.'; errormsg(oktext);</script>";
      break;

    case 'notImage':
      echo "<script>oktext = 'The selected file doesnt seem to be a valid image.'; errormsg(oktext);</script>";
      break;

    case 'largeImage':
      echo "<script>oktext = 'The selected file doesnt seem to be a valid image.'; errormsg(oktext);</script>";
      break;

    case 'wrongFileFormat':
      echo "<script>oktext = 'Only JPEG, JPG, PNG and GIF files are allowed.'; errormsg(oktext);</script>";
      break;

    case 'noUpload':
      echo "<script>oktext = 'Sorry, your file wasnt uploaded.'; errormsg(oktext);</script>";
      break;

    case 'unexpected':
      echo "<script>oktext = 'WoW. Something unexpected happened. Please try again later'; errormsg(oktext);</script>";
      break;
    
    default:
      # code...
      break;
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
          <li><a href="../index.php"><i class="fal fa-chevron-left"></i><i class="fal fa-chevron-left"></i> Main Page</a></li>
          <li><a href="#" id="modifyOrdersButton"><i class="fal fa-shopping-cart"></i> Orders</a></li>
          <li><a href="#" id="modifyRes"><i class="fal fa-calendar-alt"></i> Reservations</a></li>
          <li><a href="#" id="modifyInv"><i class="fal fa-warehouse"></i> Invertory</a></li>
          <li><a href="#" id="revContacts" onclick="refreshContacts()"><i class="fal fa-comments"></i> Contacts</a></li>
          <li>
            <ul class="dropdownmenu">
              <li class="button-dropdown">
                <a href="javascript:void(0)" class="dropdown-toggle" style="background-color: #8bc34a;">
                  <i class="fal fa-plus-square"></i> Add <span>▼</span>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="#" id="addfbutton"><i class="fal fa-utensils"></i> new Food </a></li>
                  <li><a href="#" id="newWorker"><i class="fal fa-user-plus"></i> new Worker </a></li>
                  <li><a href="#" id="newReview"><i class="fal fa-file-edit"></i> Review </a></li>
                </ul>
              </li>
            </ul>
          </li>
          <li>
            <ul class="dropdownmenu">
              <li class="button-dropdown">
                <a href="javascript:void(0)" class="dropdown-toggle" style="background-color: #8bc34a;">
                  <i class="fal fa-users"></i> Users <span>▼</span>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="#" id="manageWorker"><i class="fal fa-user-cog"></i> Workers</a></li>
                  <li><a href="#" id="manageUsers"><i class="fal fa-users-cog"></i> Users </a></li>
                  <li><a href="#" id="manageAdmin"><i class="fal fa-cog"></i> Admin Profile </a></li>
                </ul>
              </li>
            </ul>
          </li>
          <li><a href="logout.php" title="Log Out"><i class="fal fa-sign-out-alt"></i></a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.row -->
  </nav>

  <div class="info container" style="margin-top: 5%;background-color: gray;">
   <div class="jumbotron text-center" style="background-color: rgba(255,255,255,.5);">
    <h2>Admin Page</h2>
    <small>Welcome back!</small>
  </div>
  <div id="addfeaturedForm">
   <form method="POST" action="upload.php" enctype="multipart/form-data">
    <div class="form-row">
      <div class="col">
        <input type="text" class="form-control registry" placeholder="Food Name" name="name" onfocus="this.style.color='rgba(66,58,58,1)'">
        <input type="text" class="form-control registry" placeholder="Price" name="price" onfocus="this.style.color='rgba(66,58,58,1)'">
        <select name="type" id="" class="form-control registry">
          <option value="starter">Starter</option>
          <option value="maincourse">Main Course</option>
          <option value="dessert">Dessert</option>
        </select>
        <select name="attr" class="form-control registry">
          <option value="normal">Normal meal</option>
          <option value="special">Special diet available</option>
        </select>
        <select name="class" class="form-control registry">
          <option value="restaurant">Restaurant meal</option>
          <option value="webshop">Webshop item</option>
          <option value="both">Both</option>
        </select>
        <textarea class="registry form-control" rows="3" placeholder="Description for the food" name="food_desc" onfocus="this.style.color='rgba(66,58,58,1)';this."></textarea>
        <input type="button" class="btn btn-primary form-control" data-toggle="modal" data-target="#exampleModal" style="background-color: rgba(51,122,183, .49)" value="Add Nutrients Table">
        <input type="submit" class="btn btn-success form-control" style="color: white;" value="Upload new dish" name="submit" onfocus="this.style.color='white'">
        <p>
          <label for="myDragElement" class="dragAndUpload" data-post-string="?todo=test">
            <span class="dragAndUploadIcon">
              <i class="dragAndUploadIconNeutral fas fa-arrow-up"></i>
              <i class="dragAndUploadIconUploading fas fa-cog fa-spin"></i>
              <i class="dragAndUploadIconSuccess fas fa-thumbs-up"></i>
              <i class="dragAndUploadIconFailure fas fa-thumbs-down"></i>
            </span>
            <b class="dragAndUploadText"><span class="dragAndUploadTextLarge">Upload Picture</span> <span class="dragAndUploadTextSmall">with a click here</span></b>
            <i class="dragAndUploadCounter">0%</i>
            <input type="file" multiple="multiple" class="dragAndUploadManual" name="fileToUpload" id="myDragElement" />
          </label>
        </p>
      </div>
    </div>
    <!-- MODAL -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Nutrients<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button></h5>

          </div>
          <div class="modal-body">

            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Protein:</label>
              <input type="text" class="form-control" id="recipient-name" name="protein" value="<?php if(!(empty($protein))){echo $protein;} ?>">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Carbohydrates:</label>
              <input type="text" class="form-control" id="recipient-name" name="carb" value="<?php if(!(empty($carb))){echo $carb;} ?>">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Sodium:</label>
              <input type="text" class="form-control" id="recipient-name" name="sodium" value="<?php if(!(empty($sodium))){echo $sodium;} ?>">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Fiber:</label>
              <input type="text" class="form-control" id="recipient-name" name="fiber" value="<?php if(!(empty($fiber))){echo $fiber;} ?>">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Fat:</label>
              <input type="text" class="form-control" id="recipient-name" name="fat" value="<?php if(!(empty($fat))){echo $fat;} ?>">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Saturated Fat:</label>
              <input type="text" class="form-control" id="recipient-name" name="sat_fat" value="<?php if(!(empty($sat_fat))){echo $sat_fat;} ?>">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Sugar:</label>
              <input type="text" class="form-control" id="recipient-name" name="sugar" value="<?php if(!(empty($sugar))){echo $sugar;} ?>">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Cholesterol:</label>
              <input type="text" class="form-control" id="recipient-name" name="cholesterol" value="<?php if(!(empty($cholesterol))){echo $cholesterol;} ?>">
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <small>Data will be saved automatically.</small>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<div id="invertoryPanel">
  <?php $selectAllItem = "SELECT * FROM wrappers ORDER BY wrappername"; $allitem = $db->getArray($selectAllItem); ?>
  <?php if(count($allitem) == 0): ?>
    <div class="text-center" data-toggle="modal" data-target="#exampleModal" style="background-color: rgba(255,255,255,.5); border-radius: 15px;"><h3> No Items on list. <br> <i class="fal fa-plus-circle"></i> New Item</h3></div>
  <?php endif; ?>
  <?php if(count($allitem) > 0): ?>

    <table class="table" style="background-color: rgba(255,255,255,.5);">
      <thead>
        <tr><!-- -->
          <th><input style="border-radius: 10px; background-color: rgba(255,255,255, .5); border:none; width: 100%;" id="searchInv" type="text" placeholder=" Search.."></th>
          <th>Wrapper</th>
          <th>Quantity</th>
          <th>Edited at</th>
          <th><button  id="newitemInv" class="btn btn-sm btn-primary"><i class="fal fa-plus-circle"></i> New Item</button> </th>
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

  
  <form id="newITemPanel" method="POST" action="insertItem.php">
    <div class="form-group">
      <label for="invWrapperName" style="color: black;">Wrapper Name</label>
      <input type="text" class="form-control registry" id="invWrapperName" name="wrname" required="true">
    </div>
    <div class="form-group">
      <label for="InvItemQuantity" style="color: black;">Quantity</label>
      <input type="number" class="form-control registry" name="wrquantity" id="InvItemQuantity" required="true">
    </div>
    <button class="btn btn-primary" name="addInvItem"><i class="fas fa-plus"></i> Add item</button>
  </form>
  

</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
      </div>
    </div>
  </div>
</div>

<div id="contactMenu" class="container text-center">
  <iframe width="100%" height="600vh" id="contactPanel" src="iframe/contacts.php" frameborder="0" allowtransparency="true" scrolling="no"></iframe>
</div>

<?php 
$selectReservations = "SELECT reservations.*, users.username AS resby FROM reservations LEFT JOIN users ON users.id = reservations.user_id";
$allreservations = $db->getArray($selectReservations);
?>

<div id="modifyOrders">
  <div class="container">
    <div class="card-body" style="display: block;">
        <table class="table" style="width: 98%;">
          <thead>
            <tr>
              <th scope="col">Customer's username</th>
              <th scope="col">Total</th>
              <th scope="col">Ordered At:</th>
              <th scope="col">Status:</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php
              $selectOrderedItemsQuery = "SELECT orders.id, progress, total, ordered_at, users.username FROM `orders` LEFT JOIN users ON orders.user_id = users.id";
              $getOrderedElement = $db->getArray($selectOrderedItemsQuery);
              ?>
              <?php foreach ($getOrderedElement as $element) : ?>
                <tr>
                  <td><?php echo $element["username"]; ?></td>
                  <td><?php echo $element["total"]; ?></td>
                  <td><?php echo $element["ordered_at"]; ?></td>
                  <td><?php echo $element["progress"]; ?></td>
                  <td><a class="btn btn-success" href="order.php?order=<?php echo $element['id']; ?>"><i class="fas fa-search"></i>Review</a></td>
                </tr>
              <?php  endforeach; ?>
          </tbody>
        </table>
    </div>
  </div>
</div>

<div id="modifyReserve" id="reserveList">
  <?php if(count($allreservations) == 0): ?>
    <div class="text-center" style="background-color: rgba(255,255,255,.5); height: 5vh; border-radius: 15px;"><h3 style="padding-top: 5px; padding-bottom: 5px;"> No Reservations Yet. </h3></div>
  <?php endif; ?>
  <?php if(count($allreservations) > 0): ?>

    <table class="table" style="background-color: rgba(255,255,255,.5);">
      <thead>
        <tr>
          <th scope="col">Reservation ID:</th>
          <th scope="col">Booked At</th>
          <th scope="col">Status</th>
          <th scope="col">Reserved For</th>
          <th scope="col">Review</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($allreservations as $reservations): ?>
          <tr>
            <th scope="row"><?php echo $reservations["id"]; ?></th>
            <td><?php echo $reservations["bookedat"]; ?></td>
            <td><?php echo $reservations["progress"]; ?></td>
            <td><?php echo $reservations["forWho"]; ?></td>
            <td><button data-toggle="modal" data-target="#res-modal<?php echo $reservations['id']; ?>" class="btn btn-sm btn-success"><i class="fas fa-edit"></i>Edit</button></td>
          </tr>

          <script>
            function validateModal(id,expire,pepoleno,message,progress)
            {
              
              if(forwho != "" || reservedate != "" || pepoleno != "" || expire != "" || message != "" || progress != "")
              {
                $.ajax({
                  url:'editres.php',
                  method:'POST',
                  data:{id:id,pepoleno:pepoleno,expire:expire,message:message,progress:progress},
                  success:function(data){
                    alert(data);
                  }
                });
              }

              else
              {
                alert("All gaps must be filled for update.");
              }
            }
        </script>
        <?php endforeach; ?>
      </tbody>
    </table>

    <?php foreach($allreservations as $reservations): ?>
      <div id="res-modal<?php echo $reservations['id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <form method="post">
             <div class="modal-dialog"> 
              <div class="modal-content">                  
               <div class="modal-header"> 
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="far fa-times-circle"></i></button> 
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
                               <td id="resid"><?php echo $reservations["id"]; ?></td>
                             </tr> 
                             <tr>
                               <th>Reserved By:</th>
                               <td id=""><?php echo $reservations["resby"]; ?></td>
                             </tr>                                     
                             <tr>
                               <th>For Who</th>
                               <td><input type="text" value="<?php echo $reservations["forWho"]; ?>" id="forwho<?php echo $reservations["id"]; ?>"></td>
                             </tr>                                         
                             <tr>
                               <th>Booked At:</th>
                               <td><?php echo $reservations["bookedat"]; ?></td>
                             </tr>   
                             <tr>
                               <th>Reserved To: <div><?php echo $reservations["reserve_date"]; ?></div></th>
                               <td>
                                <input type="datetime-local" value="" name="newReservedate<?php echo $reservations["id"]; ?>">
                              </td>
                            </tr>  
                            <tr>
                             <th>Reservation Expires: <div><?php echo $reservations["reserve_date_end"]; ?></div></th>
                             <td>
                              <input type="datetime-local" value="" name="newExpire<?php echo $reservations["id"]; ?>">
                            </td>
                          </tr>                                 
                          <tr>
                           <th>People Number</th>
                           <td><input type="number" name="pepoleNo<?php echo $reservations["id"]; ?>" value="<?php echo $reservations["pepoleNo"]; ?>"></td>
                         </tr> 
                         <tr>
                           <th>Message:</th>
                           <td><textarea name="message<?php echo $reservations["id"]; ?>" rows="3"><?php echo $reservations["message"]; ?></textarea></td>
                         </tr>                                             
                         <tr>
                           <th>Progress</th>
                           <td><input type="text" value="<?php echo $reservations["progress"]; ?>" name="progress<?php echo $reservations["id"]; ?>"></td>
                         </tr> 
                       </table>
                   </div>                                       
                 </div> 
               </div>                       
             </div>                              
           </div>           
           <div class="modal-footer"> 
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> 
            <button name="update<?php echo $reservations['id']; ?>" class="btn btn-success">Update</button>
              </form>
              <?php  
              $tmp = "update".$reservations['id'];
                if (isset($_POST[$tmp])) {
                  $id = $reservations["id"];
                  $expire = $db->escape($_POST["newExpire".$reservations['id']]);
                  $progress = $db->escape($_POST["progress".$reservations['id']]);
                  $message = $db->escape($_POST["message".$reservations['id']]);
                  $pepoleNo = $db->escape($_POST["pepoleNo".$reservations['id']]);

                  $update = "UPDATE `reservations` SET `reserve_date_end` = '$expire', `pepoleNo` = '$pepoleNo', `message` = '$message', `progress` = '$progress' WHERE `reservations`.`id` = ".$id;
                  $exe = $db->query($update);
                  echo "<script>window.location.href='admin.php?success=done'</script>";
                }
               ?>
          </div>              
        </div> 
      </div>
  </div>
    <?php endforeach; ?>

  <?php endif; ?>

</div> <!-- End reserve container -->


<?php 

$selectReviews = "SELECT * FROM reviews";
$allReviews = $db->getArray($selectReviews);
?>

<div id="reviewsPanel" id="reserveList">
  <?php if(count($allReviews) == 0): ?>
    <div class="container text-center" style="background-color: rgba(255,255,255,.5);"><h3> No Reviews Yet. </h3></div>
  <?php endif; ?>
  <?php if(count($allReviews) > 0): ?>
    <div class="container">
      <table class="table" style="background-color: rgba(255,255,255,.5); width: 97%;">
        <thead>
          <tr>
            <th scope="col">Review ID</th>
            <th scope="col">Title</th>
            <th scope="col">Author</th>
            <th scope="col">Portfolio site</th>
            <th scope="col">Cover picture url</th>
            <th scope="col" id="togglerev"><div id="hideRev"><i class="fal fa-eye-slash"></i> Hide</div><div id="showrev"><i class="fal fa-eye"></i> Show</div></th>
          </tr>
        </thead>
        <tbody class="revitem">
          <?php foreach($allReviews as $review): ?>
            <th scope="row"><?php echo $review["id"]; ?></th>
            <td><?php echo $review["title"]; ?></td>
            <td><?php echo $review["author"]; ?></td>
            <td><?php echo substr($review["website"], 0,29); if(strlen($review["website"])>29){echo "...";} ?></td>
            <td><?php echo substr($review["url"], 0,29); if(strlen($review["url"])>29){echo "...";} ?></td>
            <td>
              <button data-toggle="modal" data-target="#rev-modal" data-id="<?php echo $review["id"]; ?>" id="getReview" class="btn btn-sm btn-success">
                <i class="fal fa-book-open"></i> Read</button>
                <button class="btn btn-sm btn-danger" name="deleteReview" onclick="window.location.href='deletereview.php?delete=<?php echo $review['id']; ?>'"><i class="fal fa-eraser"></i> Remove</button>
              </td>
            </tr>

          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>

  <form method="POST" action="upload.php">
    <div class="form-group row">
      <label for="revtitle" class="col-sm-2 col-form-label">Title</label>
      <div class="col-sm-10">
        <input type="text" class="form-control registry" id="revtitle" name="revtitle" required>
      </div>
    </div>
    <div class="form-group row">
      <label for="revauthor" class="col-sm-2 col-form-label">Author</label>
      <div class="col-sm-10">
        <input type="text" class="form-control registry" id="revauthor" name="revauthor" required>
      </div>
    </div>
    <div class="form-group row">
      <label for="revwebsite" class="col-sm-2 col-form-label">Website</label>
      <div class="col-sm-10">
        <input type="text" class="form-control registry" id="revwebsite" name="revwebsite" required>
      </div>
    </div>
    <div class="form-group row">
      <label for="revurl" class="col-sm-2 col-form-label">URL for Cover Picture</label>
      <div class="col-sm-10">
        <input type="text" class="form-control registry" id="revurl" name="revurl" required>
      </div>
    </div>
    <div class="form-group row">
      <label for="revmessage" class="col-sm-2 col-form-label">Review's Content</label>
      <div class="col-sm-10">
        <textarea class="form-control registry" name="revmessage" id="revmessage" rows="5" required></textarea>
      </div>
    </div>
    <button type="submit" class="btn btn-success" name="addrev"><i class="fal fa-plus"></i> Add Review</button>
  </form>
</div> 

<?php 
$selectRolesQuery = "SELECT * FROM roles"; 
$allrole = $db->getArray($selectRolesQuery);
?>

<div id="newWorkerPanel">
  <form action="addworker.php" method="POST">
    <div class="form-group">
      <label for="exampleFormControlInput1">Worker's username:</label>
      <input type="text" name="username" class="form-control registry" id="exampleFormControlInput1" placeholder="Ought to be person specific" required>
    </div>
    <div class="form-group">
      <label for="exampleFormControlSelect1">Profession</label>
      <select name="selectrole" id="selectrole" class="exampleFormControlSelect1 form-control registry">
        <option value="">Select Rule</option>
        <?php if(count($allrole) > 0): ?>
          <?php foreach($allrole as $role): ?>
            <?php if($role["role"] != "admin" && $role["role"] != "user"): ?>
              <option value="<?php echo $role['id']; ?>" title="<?php echo $role['description']; ?>"><?php echo $role["role"]; ?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </select>
    </div>
    <div class="form-group">
      <label for="exampleFormControlInput1">Email Address:</label>
      <input type="email" name="email" class="form-control registry" id="exampleFormControlInput1" required>
    </div>
    <div class="form-group">
      <label for="exampleFormControlInput1">Full Name:</label>
      <input type="text" name="fullNameInput" class="form-control registry" id="exampleFormControlInput2" required>
    </div>
    <div class="form-group">
      <label for="exampleFormControlInput1">Phone Number:</label>
      <input type="tel" name="phone" class="form-control registry" id="exampleFormControlInput3" required>
    </div>
    <button class="btn btn-success" name="addworker" id="addworker"><i class="fal fa-user-plus"></i> Add Worker</button>
    <br><hr>
  </form>
</div>

<?php 
$selectWorkersByRoleQuery = "SELECT users.id, users.role_id, roles.role, users.username FROM users INNER JOIN roles ON users.role_id = roles.id WHERE users.role_id = 3 OR users.role_id = 4 OR users.role_id = 5 ORDER BY users.id ASC";
$allWorker = $db->getArray($selectWorkersByRoleQuery);
?>
<div id="manageWorkerPanel">
  <?php if(count($allWorker) == 0): ?>
    <div class="container text-center" style="background-color: rgba(255,255,255,.5);"><h3> No Workers Yet. </h3></div>
  <?php endif; ?>
  <?php if(count($allWorker) > 0): ?>

    <table class="table" align="center" style="background-color: rgba(255,255,255,.5); width: 95%;">
      <thead>
        <tr>
          <th scope="col">Worker's ID:</th>
          <th scope="col">Username</th>
          <th scope="col">Job</th>
          <th scope="col">Permission Code(s)</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($allWorker as $worker): ?>
          <tr>
            <th scope="row"><?php echo $worker["id"]; ?></th>
            <td><?php echo $worker["username"]; ?></td>
            <td><?php echo $worker["role"]; ?></td>
            <td><?php echo $worker["role_id"]; ?></td>
            <td>
              <button data-toggle="modal" data-target="#worker-modal" data-id="<?php echo $worker["id"]; ?>" id="getWorker" onclick="reload()" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i>Edit</button>
              <a href="delete.php?workerid=<?php echo $worker['id']; ?>" class="btn btn-sm btn-danger" title="Remove Worker"><i class="fal fa-user-minus"> Remove</i></a>
              <a href="resetworkerpw.php?worker=<?php echo $worker['username']; ?>" class="btn btn-sm btn-light" title="Reset Password"><i class="fas fa-sync-alt"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  <?php endif; ?>

</div>

<!-- Worker Modal -->

<div id="worker-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <form action="editworker.php" method="POST">
   <div class="modal-dialog"> 
    <div class="modal-content">                  
     <div class="modal-header"> 
       <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="far fa-times-circle"></i></button> 
       <h4 class="modal-title">
         Worker Details
       </h4> 
     </div>          
     <div class="modal-body">                   
       <div id="worker-detail">                                        
         <div class="row"> 
           <div class="col-md-12">                         
             <div class="table-responsive">        
               <form action="" method="POST" id="insert_form">                     
                 <table class="table table-striped table-bordered">
                   <tr>
                     <th>User's ID:</th>
                     <td><input type="text" name="workid" id="workid" readonly="true" style="border: none; text-decoration: none; background-color: transparent;"></td>
                   </tr> 
                   <tr>
                     <th>Username:</th>
                     <td id="workerusername"></td>
                   </tr>                                                                                 
                   <tr>
                    <th>Active Role:</th>
                    <td>
                     <select name="selectrole" id="workroles">
                      <option value="">New Role..</option>
                      <?php foreach($allrole as $role): ?>
                        <?php if($role["role"] != "admin"): ?>
                          <option value="<?php echo $role['id']; ?>"><?php echo $role["role"]; ?></option>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </select>
                  </td>
                </tr> 
                <tr>
                 <th>Permission Code(s): </th>
                 <td><input id="role_id" value="" readonly="true" style="border: none; text-decoration: none;"></td>
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
  <button id="insert" class="btn btn-success" onclick="return validateWorkerModal()">Update</button>
</div>              
</div> 
</div>
</form>
</div>

<!-- User Panel -->

<?php 
$selectUsersByRoleQuery = "SELECT  id, username, email, profilepic FROM users WHERE role_id = 2";
$allUser = $db->getArray($selectUsersByRoleQuery);
?>
<div id="manageUserPanel">
  <?php if(count($allUser) == 0): ?>
    <div class="container text-center" style="background-color: rgba(255,255,255,.5);"><h3> No Workers Yet. </h3></div>
  <?php endif; ?>
  <?php if(count($allUser) > 0): ?>

    <table class="table" align="center" style="background-color: rgba(255,255,255,.5); width: 95%;">
      <thead>
        <tr>
          <th scope="col">User's ID:</th>
          <th scope="col">Username</th>
          <th scope="col">Email Address</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($allUser as $user): ?>
          <tr>
            <th scope="row"><?php echo $user["id"]; ?></th>
            <td>
              <img src="<?php if(!(empty($user["profilepic"]))){ echo '../images/profiles/'.$user['username'].'/'.$user['profilepic'];} else{ echo '../images/Logo_main.png';} ?>" alt="<?php echo $user['username'].'s profile picture' ?>" style="height: 25px; width: 25px; border-radius: 50%;">  <?php echo $user["username"]; ?>
            </td>
            <td><?php echo $user["email"]; ?></td>
            <td>
              <!--a href="delete.php?workerid=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" title="Dismiss User"><i class="fal fa-user-minus"> Dismiss</i></a-->
              <a href="resetworkerpw.php?worker=<?php echo $user['username']; ?>" class="btn btn-sm btn-light" title="Reset Password"><i class="fas fa-sync-alt"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  <?php endif; ?>

</div>

<div id="manageAdminPanel">
  <form class="form-group" action="updateadmin.php" method="post">
    <div class="form-row">
      <input type="password" name="currentPasword" class="form-control" placeholder="Current password">
      <input type="password" name="newPassword" class="form-control" placeholder="New password">
      <input type="password" name="newPassword2" class="form-control" placeholder="Confirm new password">
      <button class="btn btn-success" name="setNewPassword"><i class="fal fa-wrench"></i> Set new password</button>
    </div>
  </form>
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

<!-- Review Modal -->
<div id="rev-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <form action="" method="POST">
    <div class="modal-dialog"> 
      <div class="modal-content">                  
        <div class="modal-header"> 
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="far fa-times-circle"></i></button> 
          <h4 class="modal-title">
            Details
          </h4> 
        </div>          
        <div class="modal-body">                   
          <div id="review-detail">                                        
            <div class="row"> 
              <div class="col-md-12">                         
                <div class="table-responsive">                             
                  <table class="table table-striped table-bordered">
                    <tr>
                      <th>Review ID:</th>
                      <td id="revid"></td>
                    </tr>                                     
                    <tr>
                      <th>Author's Name:</th>
                      <td id="author2"></td>
                    </tr>                                         
                    <tr>
                      <th>Title</th>
                      <td id="title2"></td>
                    </tr>   
                    <tr>
                      <th>Website:</th>
                      <td id="website2"></td>
                    </tr>                                         
                    <tr>
                      <th>Message:</th>
                      <td id="message2"></td>
                    </tr> 
                    <tr>
                      <th>URL:</th>
                      <td id="url2"></td>
                    </tr>                                             
                  </table>                                
                </div>                                       
              </div> 
            </div>                       
          </div>                              
        </div>           
        <div class="modal-footer"> 
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
          <!--<button class="btn btn-success" data-dismiss="modal">Reply</button> -->
        </div>              
      </div> 
    </div>
  </form>
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
  function reload()
  {
    document.getElementById('reservedby').contentWindow.location.reload();
  }

  function refreshContacts()
  {
    document.getElementById('contactPanel').contentWindow.location.reload();
  }

  $(document).ready(function(){
    $("#searchInv").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#invTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
  
  $("#addfeaturedForm").hide();
  $("#invertoryPanel").hide();
  $("#manageUserPanel").hide();
  $("#modifyReserve").hide();
  $("#modifyOrders").hide();
  $("#contactMenu").hide();
  $("#newWorkerPanel").hide();
  $("#reviewsPanel").hide();
  $("#manageWorkerPanel").hide();
  $("#showrev").hide();
  $("#newITemPanel").hide();
  $("#manageAdminPanel").hide();

  $("#addfbutton").click(function(e) {
    e.preventDefault();
    $("#addfeaturedForm").toggle();

    if($("#contactMenu").is(":visible")){
      $("#contactMenu").hide();
    }

    if($("#manageUserPanel").is(":visible")){
      $("#manageUserPanel").hide();
    }

    if($("#invertoryPanel").is(":visible")){
      $("#invertoryPanel").hide();
    }

    if($("#manageWorkerPanel").is(":visible")){
      $("#manageWorkerPanel").hide();
    }

    if($("#modifyOrders").is(":visible")){
      $("#modifyOrders").hide();
    }

    if($("#modifyReserve").is(":visible")){
      $("#modifyReserve").hide();
    }

    if($("#newWorkerPanel").is(":visible")){
      $("#newWorkerPanel").hide();
    }

    if($("#reviewsPanel").is(":visible")){
      $("#reviewsPanel").hide();
    }

    if($("#manageAdminPanel").is(":visible")){
      $("#manageAdminPanel").hide();
    }

  });

  $("#manageAdmin").click(function(e) {
    e.preventDefault();
    $("#manageAdminPanel").toggle();

    if($("#contactMenu").is(":visible")){
      $("#contactMenu").hide();
    }

    if($("#manageUserPanel").is(":visible")){
      $("#manageUserPanel").hide();
    }

    if($("#invertoryPanel").is(":visible")){
      $("#invertoryPanel").hide();
    }

    if($("#manageWorkerPanel").is(":visible")){
      $("#manageWorkerPanel").hide();
    }

    if($("#modifyOrders").is(":visible")){
      $("#modifyOrders").hide();
    }

    if($("#modifyReserve").is(":visible")){
      $("#modifyReserve").hide();
    }

    if($("#newWorkerPanel").is(":visible")){
      $("#newWorkerPanel").hide();
    }

    if($("#reviewsPanel").is(":visible")){
      $("#reviewsPanel").hide();
    }

    if($("#addfeaturedForm").is(":visible")){
      $("#addfeaturedForm").hide();
    }
    
  });

  $("#newReview").click(function(e) {
    e.preventDefault();
    $("#reviewsPanel").toggle();

    if($("#contactMenu").is(":visible")){
      $("#contactMenu").hide();
    }

    if($("#manageWorkerPanel").is(":visible")){
      $("#manageWorkerPanel").hide();
    }

    if($("#modifyReserve").is(":visible")){
      $("#modifyReserve").hide();
    }

    if($("#modifyOrders").is(":visible")){
      $("#modifyOrders").hide();
    }

    if($("#newWorkerPanel").is(":visible")){
      $("#newWorkerPanel").hide();
    }

    if($("#addfeaturedFormdd").is(":visible")){
      $("#addfeaturedForm").hide();
    }

    if($("#invertoryPanel").is(":visible")){
      $("#invertoryPanel").hide();
    }

    if($("#manageUserPanel").is(":visible")){
      $("#manageUserPanel").hide();
    }

    if($("#manageAdminPanel").is(":visible")){
      $("#manageAdminPanel").hide();
    }

  });

  $("#togglerev").click(function(e) {
    e.preventDefault();
    $("#hideRev").toggle();
    $("#showrev").toggle();

    $(".revitem").toggle("slow");

  });

  $("#newWorker").click(function(e) {
    e.preventDefault();
    $("#newWorkerPanel").toggle();

    if($("#contactMenu").is(":visible")){
      $("#contactMenu").hide();
    }

    if($("#manageAdminPanel").is(":visible")){
      $("#manageAdminPanel").hide();
    }    

    if($("#manageWorkerPanel").is(":visible")){
      $("#manageWorkerPanel").hide();
    }

    if($("#modifyReserve").is(":visible")){
      $("#modifyReserve").hide();
    }

    if($("#addfeaturedForm").is(":visible")){
      $("#addfeaturedForm").hide();
    }

    if($("#reviewsPanel").is(":visible")){
      $("#reviewsPanel").hide();
    }

    if($("#invertoryPanel").is(":visible")){
      $("#invertoryPanel").hide();
    }

    if($("#modifyOrders").is(":visible")){
      $("#modifyOrders").hide();
    }

    if($("#manageUserPanel").is(":visible")){
      $("#manageUserPanel").hide();
    }

  });

  $("#revContacts").click(function(e) {
    e.preventDefault();
    $("#contactMenu").toggle();

    if($("#modifyReserve").is(":visible")){
      $("#modifyReserve").hide();
    }

    if($("#manageWorkerPanel").is(":visible")){
      $("#manageWorkerPanel").hide();
    }

    if($("#addfeaturedForm").is(":visible")){
      $("#addfeaturedForm").hide();
    }

    if($("#newWorkerPanel").is(":visible")){
      $("#newWorkerPanel").hide();
    }

    if($("#reviewsPanel").is(":visible")){
      $("#reviewsPanel").hide();
    }

    if($("#invertoryPanel").is(":visible")){
      $("#invertoryPanel").hide();
    }

    if($("#modifyOrders").is(":visible")){
      $("#modifyOrders").hide();
    }

    if($("#manageUserPanel").is(":visible")){
      $("#manageUserPanel").hide();
    }

    if($("#manageAdminPanel").is(":visible")){
      $("#manageAdminPanel").hide();
    }

  });

  $("#modifyInv").click(function(e) {
    e.preventDefault();
    $("#invertoryPanel").toggle();

    if($("#modifyReserve").is(":visible")){
      $("#modifyReserve").hide();
    }

    if($("#manageWorkerPanel").is(":visible")){
      $("#manageWorkerPanel").hide();
    }

    if($("#addfeaturedForm").is(":visible")){
      $("#addfeaturedForm").hide();
    }

    if($("#newWorkerPanel").is(":visible")){
      $("#newWorkerPanel").hide();
    }

    if($("#reviewsPanel").is(":visible")){
      $("#reviewsPanel").hide();
    }

    if($("#contactMenu").is(":visible")){
      $("#contactMenu").hide();
    }

    if($("#modifyOrders").is(":visible")){
      $("#modifyOrders").hide();
    }

    if($("#manageUserPanel").is(":visible")){
      $("#manageUserPanel").hide();
    }

    if($("#manageAdminPanel").is(":visible")){
      $("#manageAdminPanel").hide();
    }

  });

  $("#manageWorker").click(function(e) {
    e.preventDefault();
    $("#manageWorkerPanel").toggle();

    if($("#contactMenu").is(":visible")){
      $("#contactMenu").hide();
    }
    if($("#addfeaturedForm").is(":visible")){
      $("#addfeaturedForm").hide();
    }

    if($("#modifyReserve").is(":visible")){
      $("#modifyReserve").hide();
    }

    if($("#newWorkerPanel").is(":visible")){
      $("#newWorkerPanel").hide();
    }

    if($("#reviewsPanel").is(":visible")){
      $("#reviewsPanel").hide();
    }

    if($("#invertoryPanel").is(":visible")){
      $("#invertoryPanel").hide();
    }

    if($("#modifyOrders").is(":visible")){
      $("#modifyOrders").hide();
    }

    if($("#manageUserPanel").is(":visible")){
      $("#manageUserPanel").hide();
    }

    if($("#manageAdminPanel").is(":visible")){
      $("#manageAdminPanel").hide();
    }

  });
  
  $("#modifyRes").click(function(e) {
    e.preventDefault();
    $("#modifyReserve").toggle();

    if($("#contactMenu").is(":visible")){
      $("#contactMenu").hide();
    }
    if($("#addfeaturedForm").is(":visible")){
      $("#addfeaturedForm").hide();
    }

    if($("#manageWorkerPanel").is(":visible")){
      $("#manageWorkerPanel").hide();
    }

    if($("#newWorkerPanel").is(":visible")){
      $("#newWorkerPanel").hide();
    }

    if($("#reviewsPanel").is(":visible")){
      $("#reviewsPanel").hide();
    }

    if($("#invertoryPanel").is(":visible")){
      $("#invertoryPanel").hide();
    }

    if($("#modifyOrders").is(":visible")){
      $("#modifyOrders").hide();
    }

    if($("#manageUserPanel").is(":visible")){
      $("#manageUserPanel").hide();
    }

    if($("#manageAdminPanel").is(":visible")){
      $("#manageAdminPanel").hide();
    }

  });

  $("#modifyOrdersButton").click(function(e) {
    e.preventDefault();
    $("#modifyOrders").toggle();

    if($("#contactMenu").is(":visible")){
      $("#contactMenu").hide();
    }
    if($("#addfeaturedForm").is(":visible")){
      $("#addfeaturedForm").hide();
    }

    if($("#manageWorkerPanel").is(":visible")){
      $("#manageWorkerPanel").hide();
    }

    if($("#newWorkerPanel").is(":visible")){
      $("#newWorkerPanel").hide();
    }

    if($("#reviewsPanel").is(":visible")){
      $("#reviewsPanel").hide();
    }

    if($("#invertoryPanel").is(":visible")){
      $("#invertoryPanel").hide();
    }

    if($("#modifyReserve").is(":visible")){
      $("#modifyReserve").hide();
    }

    if($("#manageUserPanel").is(":visible")){
      $("#manageUserPanel").hide();
    }

    if($("#manageAdminPanel").is(":visible")){
      $("#manageAdminPanel").hide();
    }

  });

    $("#manageUsers").click(function(e) {
    e.preventDefault();
    $("#manageUserPanel").toggle();

    if($("#contactMenu").is(":visible")){
      $("#contactMenu").hide();
    }
    if($("#addfeaturedForm").is(":visible")){
      $("#addfeaturedForm").hide();
    }

    if($("#manageWorkerPanel").is(":visible")){
      $("#manageWorkerPanel").hide();
    }

    if($("#newWorkerPanel").is(":visible")){
      $("#newWorkerPanel").hide();
    }

    if($("#reviewsPanel").is(":visible")){
      $("#reviewsPanel").hide();
    }

    if($("#invertoryPanel").is(":visible")){
      $("#invertoryPanel").hide();
    }

    if($("#modifyReserve").is(":visible")){
      $("#modifyReserve").hide();
    }

    if($("#modifyOrders").is(":visible")){
      $("#modifyOrders").hide();
    }

    if($("#manageAdminPanel").is(":visible")){
      $("#manageAdminPanel").hide();
    }
    
  });

  $(document).ready(function(){   
   $(document).on('click', '#getWorker', function(e){  
     e.preventDefault();  
     var workid = $(this).data('id');    
     $('#worker-detail').hide();  
     $.ajax({
      url: 'revieworker.php',
      type: 'POST',
      data: 'workid='+workid,
      dataType: 'json',
      cache: false
    })
     .done(function(data){
      $('#worker-detail').hide();
      $('#worker-detail').show();
      $('#workid').val(data.id);
      $('#workerusername').html(data.username);
      $('#workerole').html(data.role);
      $('#role_id').val(data.role_id);     

    })
     .fail(function(){
      $('#worker-detail').html('Error, Please try again...');
    });
   }); 
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

  $("#newitemInv").click(function(e) {
    e.preventDefault();
    $("#newITemPanel").toggle();

  });
  function redirectWorker()
  {
    window.location.href = "editworker.php";
  }

  function redirectInv()
  {
    window.location.href = "editinvertory.php";
  }

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

  function validateWorkerModal()
  {
    var workerusername = $('#workerusername').val();
    var roleid = $('#role_id').val();

    if(roleid == "")
    {
      alert("If you dont change role, use cancel to go back.");
    }

    else
    {
      document.cookie = "workid=" + data.id;
      document.cookie = "workerusername=" + workerusername;
      document.cookie = "roleid=" + roleid;
      redirectWorker();
    }
  }

  $(document).ready(function(){   
    $(document).on('click', '#getReview', function(e){  
      e.preventDefault();  
      var rev_id = $(this).data('id');    
      $('#review-detail').hide();  
      $.ajax({
        url: 'reviewrev.php',
        type: 'POST',
        data: 'rev_id='+rev_id,
        dataType: 'json',
        cache: false
      })
      .done(function(data){
        $('#review-detail').hide();
        $('#review-detail').show();
        $('#revid').html(data.id);
        $('#title2').html(data.title);
        $('#author2').html(data.author);      
        $('#website2').html(data.website);      
        $('#url2').html(data.url);      
        $('#message2').html(data.message);

      })
      .fail(function(){
        $('#contact-detail').html('Error, Please try again...');
      });
    }); 
  });

  jQuery(document).ready(function (e) {
    function t(t) {
      e(t).bind("click", function (t) {
        t.preventDefault();
        e(this).parent().fadeOut()
      })
    }
    e(".dropdown-toggle").click(function () {
      var t = e(this).parents(".button-dropdown").children(".dropdown-menu").is(":hidden");
      e(".button-dropdown .dropdown-menu").hide();
      e(".button-dropdown .dropdown-toggle").removeClass("active");
      if (t) {
        e(this).parents(".button-dropdown").children(".dropdown-menu").toggle().parents(".button-dropdown").children(".dropdown-toggle").addClass("active")
      }
    });
    e(document).bind("click", function (t) {
      var n = e(t.target);
      if (!n.parents().hasClass("button-dropdown")) e(".button-dropdown .dropdown-menu").hide();
    });
    e(document).bind("click", function (t) {
      var n = e(t.target);
      if (!n.parents().hasClass("button-dropdown")) e(".button-dropdown .dropdown-toggle").removeClass("active");
    })
  });

</script>

</body>
</html>