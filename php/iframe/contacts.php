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

		$selectContacts = "SELECT * FROM contacts";
		$allContacts = $db->getArray($selectContacts);
	}

 ?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="contact.css">
  <title>Contact List</title>
  <link rel="stylesheet" href="bootstrap.min.css">
  <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
</head>
<body onload="timing()" style="background-color: transparent;">
  <script type="text/javascript" src="../../js/jquery-1.11.2.min.js"></script>
  <script src="../../js/bootstrap.min.js"></script>
  
  <div id="loader">
    <h1 class="loadertext">Loading in progress..</h1>
    <div id="cooking">
      <div class="bubble"></div>
      <div class="bubble"></div>
      <div class="bubble"></div>
      <div class="bubble"></div>
      <div class="bubble"></div>
      <div id="area">
        <div id="sides">
          <div id="pan"></div>
          <div id="handle"></div>
        </div>
        <div id="pancake">
          <div id="pastry"></div>
        </div>
      </div>
    </div>
  </div>
  
  <div id="content" class="container">
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
  						<?php if(count($allContacts) > 0): ?>
  							<?php foreach($allContacts as $contact): ?>
  								<tr style="background-color: rgba(255,255,255,.2);">
  									<th scope="row"><?php echo $contact["id"]; ?></th>
  									<td><?php echo $contact["name"]; ?></td>
  									<td><?php echo $contact["email"]; ?></td>
  									<td><?php echo $contact["subject"]; ?></td>
  									<td><button data-toggle="modal" data-target="#res-modal" data-id="<?php echo $contact["id"]; ?>" id="getContact" class="btn btn-sm btn-success"><i class="far fa-book-open"></i> Read</button></td>
  								</tr>

  							<?php endforeach; ?>
  						<?php endif; ?>
  					</tbody>
  				</table>
  			</div>
  		</div>
  </div>

  <div id="res-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
  					<div id="contact-detail">                                        
  						<div class="row"> 
  							<div class="col-md-12">                         
  								<div class="table-responsive">                             
  									<table class="table table-striped table-bordered">
  										<tr>
  											<th>Contact ID:</th>
  											<td id="contactid"></td>
  										</tr>                                     
  										<tr>
  											<th>Submitter's Name:</th>
  											<td id="submitter"></td>
  										</tr>                                         
  										<tr>
  											<th>Submitted At:</th>
  											<td id="submittedat"></td>
  										</tr>   
  										<tr>
  											<th>Subject:</th>
  											<td id="subject"></td>
  										</tr>                                         
  										<tr>
  											<th>Email:</th>
  											<td id="email"></td>
  										</tr> 
  										<tr>
  											<th>Message:</th>
  											<td id="message"></td>
  										</tr>                                             
  									</table>                                
  								</div>                                       
  							</div> 
  						</div>                       
  					</div>                              
  				</div>           
  				<div class="modal-footer"> 
  					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> 
  					<!--<button class="btn btn-success" data-dismiss="modal">Reply</button> -->
  				</div>              
  			</div> 
  		</div>
  	</form>
  </div>
  
<script>
	var timer;

	function timing() {
		$("#content").hide();
		timer = setTimeout(showPage, 1500);
	}

	function showPage() 
	{
		$("#loader").hide();
		$("#content").show();
	}

	function reload()
	{
		document.getElementById('reservedby').contentWindow.location.reload();
	}

	$(document).ready(function(){   
		$(document).on('click', '#getContact', function(e){  
			e.preventDefault();  
			var empid = $(this).data('id');    
			$('#contact-detail').hide();  
			$.ajax({
				url: 'review.php',
				type: 'POST',
				data: 'empid='+empid,
				dataType: 'json',
				cache: false
			})
			.done(function(data){
				$('#contact-detail').hide();
				$('#contact-detail').show();
				$('#contactid').html(data.id);
				$('#submitter').html(data.name);
				$('#submittedat').html(data.submitted_at);      
				$('#subject').html(data.subject);      
				$('#email').html(data.email);      
				$('#message').html(data.message);

			})
			.fail(function(){
				$('#contact-detail').html('Error, Please try again...');
			});
		}); 
	});
</script>

</body>
</html>