<?php 
  /* Prevent Caching */
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
  
  session_start();

  if ($_SESSION["username"] != "admin") 
  {
    header("location: ../../index.php");
  }
  else
  {
    require_once "../db.php";

    $db = db::get();

    $selectReviews = "SELECT * FROM reviews";
    $allReviews = $db->getArray($selectReviews);
  }

 ?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Contact List</title>
  <link rel="stylesheet" href="bootstrap.min.css">
  <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
</head>
<body style="background-color: transparent;">
  <script type="text/javascript" src="../../js/jquery-1.11.2.min.js"></script>
  <script src="../../js/bootstrap.min.js"></script>

  <div id="content">
      <div class="wrap">
        <div class="content-bg"></div>  
        <div class="content-text">
          <table class="table table-striped">
            <thead>
              <tr style="background-color: rgba(255,255,255,.23);">
                <th scope="col">Contact ID:</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Subject</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <?php if(count($allReviews) > 0): ?>
                <?php foreach($allReviews as $review): ?>
                  <tr style="background-color: rgba(255,255,255,.2);">
                    <th scope="row"><?php echo $review["id"]; ?></th>
                    <td><?php echo $review["title"]; ?></td>
                    <td><?php echo $review["author"]; ?></td>
                    <td><?php echo $review["website"]; ?></td>
                    <td><?php echo $review["url"]; ?></td>
                    <td>
                      <button data-toggle="modal" data-target="#rev-modal" data-id="<?php echo $review["id"]; ?>" id="getReview" class="btn btn-sm btn-success"><i class="far fa-book-open"></i> Read</button>
                      <button class="btn btn-danger" name="deleteReview" onclick="window.location.href='../deletereview.php?delete=<?php echo $review['id']; ?>'"><i class="fal fa-eraser"></i> Remove</button>
                  </td>
                  </tr>

                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
  </div>

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
                        <td><input type="text" name="revid" id="revid" value=""></td>
                      </tr>                                     
                      <tr>
                        <th>Author's Name:</th>
                        <td ><input id="author2" type="text" value=""></td>
                      </tr>                                         
                      <tr>
                        <th>Title</th>
                        <td><input type="text" value="" id="title2"></td>
                      </tr>   
                      <tr>
                        <th>Website:</th>
                        <td ><input id="website2" type="text" value=""></td>
                      </tr>                                         
                      <tr>
                        <th>Message:</th>
                        <td ><input id="message2" type="text" value=""></td>
                      </tr> 
                      <tr>
                        <th>URL:</th>
                        <td ><input id="url2" type="text" value=""></td>
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
  
<script>

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
        $('#title2').val(data.title);
        $('#author2').val(data.author);      
        $('#website2').val(data.website);      
        $('#url2').val(data.url);      
        $('#message2').val(data.message);

      })
      .fail(function(){
        $('#contact-detail').html('Error, Please try again...');
      });
    }); 
  });
</script>

</body>
</html>