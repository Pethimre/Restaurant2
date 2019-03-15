<?php  
	include('reg.php');

	error_reporting(E_ALL ^ E_NOTICE); //Hide all notice

	if (isset($_SESSION["username"])) {
		# code...
		echo "<div class='container btn-danger text-center' style='margin-top: 10%; background-color: rgba(217,83,79, .6)'>You must log out first.
				<br>
				<a class='btn btn-secondary' href='php/logout.php'>Log me out then</a>
			  </div>";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign up</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/profile.css">
	<link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">
	<link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
  <link rel="stylesheet" href="css/signup.css">
  <style>
    .bg 
{
      background-image: url("images/steak.jpg");
      height: 100vh; 
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
}
  </style>
</head>
<body class="bg">

<div class="form" style="margin-top: 3%; border-radius: 15px;">
      
      <ul class="tab-group">
        <li class="tab active"><a href="#signup">Sign Up</a></li>
        <li class="tab"><a href="#login">Log In</a></li>
      </ul>
      
      <div class="tab-content">
        <?php if(!empty($errors)): ?>
          <div align='center' style='color: rgba(255,102,102, .98)'> 
            <?php foreach ($errors as $key) { echo $key ."<br>"; } ?>
          </div>
          <?php 
        endif; 
        ?>

        <div id="signup">   
          <h1>Sign Up for Free</h1>
          
          <form action="register.php" method="post">
          
          <div class="top-row">
            <div class="field-wrap">
              <label class="placeholdertext">
               <?php if(empty($username)){echo "Username";}?><span class="req"><?php if(empty($username)){echo "*";} ?></span>
              </label>
              <input type="text" placeholder="" name="new_username" required autocomplete="off" maxlength="128" value="<?php if(!empty($username)){echo $username;} ?>"/>
            </div>
        
            <div class="field-wrap">
              <label class="placeholdertext">
                <?php if(empty($fullname)){echo "Full Name";}?><span class="req"><?php if(empty($fullname)){echo "*";} ?></span>
              </label>
              <input type="text" name="fullName" required autocomplete="off" maxlength="128" value="<?php if(!empty($fullname)){echo $fullname;} ?>"/>
            </div>
          </div>

          <div class="top-row">
            <div class="field-wrap">
              <label class="placeholdertext">
                <?php if(empty($email)){echo "Email";}?><span class="req"><?php if(empty($email)){echo "*";} ?></span>
              </label>
              <input type="email" name="new_email" placeholder="" id="email" required autocomplete="off" maxlength="128" value="<?php if(!empty($email)){echo $email;} ?>"/>
            </div>
        
            <div class="field-wrap">
              <label class="placeholdertext">
                <?php if(empty($phoneNumber)){echo "Phone Number";}?><span class="req"><?php if(empty($phoneNumber)){echo "*";} ?></span>
              </label>
              <input type="tel" placeholder="" name="phoneNumber" required autocomplete="off" maxlength="16" value="<?php if(!empty($phoneNumber)){echo $phoneNumber;} ?>"/>
            </div>
          </div>

          <div class="field-wrap">
            <label class="placeholdertext">
              <?php if(empty($shppingAddr)){echo "Shipping Address";}?><span class="req"><?php if(empty($shppingAddr)){echo "*";} ?></span>
            </label>
            <input name="shppingAddr" placeholder="" type="text" required autocomplete="off" maxlength="128" value="<?php if(!empty($shppingAddr)){echo $shppingAddr;} ?>"/>
          </div>

          <div class="field-wrap">
            <label class="placeholdertext">
              <?php if(empty($billingAddr)){echo "Billing Address";}?><span class="req"><?php if(empty($billingAddr)){echo "*";} ?></span>
            </label>
            <input type="text" name="billingAddr" placeholder="" required autocomplete="off" maxlength="128" value="<?php if(!empty($billingAddr)){echo $billingAddr;} ?>"/>
          </div>
          
          <div class="field-wrap">
            <label class="placeholdertext">
              Set a Password<span class="req">*</span>
            </label>
            <input type="password" name="password1" placeholder="" required autocomplete="off" maxlength="32" />
          </div>

          <div class="field-wrap">
            <label class="placeholdertext">
              Confirm Password<span class="req">*</span>
            </label>
            <input type="password" name="password2" placeholder="" required autocomplete="off" maxlength="32" />
          </div>
          
          <button type="submit" name="reg_user" class="button button-block"/>Sign me up</button>
          
          </form>

        </div>
        
        <div id="login">   
          <h1>Welcome Back!</h1>
          
          <form action="register.php" method="post">
          
            <div class="field-wrap">
            <label class="placeholdertext">
              <?php if(empty($username)){echo "Username";} ?><span class="req"><?php if(empty($username)){echo "*";} ?></span>
            </label>
            <input type="text" name="username" required autocomplete="off" maxlength="128" value="<?php if(!empty($username)){echo $username;}?>"/>
          </div>
          
          <div class="field-wrap">
            <label class="placeholdertext">
              Password<span class="req">*</span>
            </label>
            <input type="password" name="password" required autocomplete="off" maxlength="32" />
          </div>
          
          <p class="forgot"><a href="#"><!--Forgot Password? THIS FUNCTION IS UNDER DEVELOPMENT--></a></p><br>
          
          <button class="button button-block"/ name="login_user">Log In</button>
          
          </form>

        </div>
        
      </div><!-- tab-content -->
      
</div> <!-- /form -->

<script>
  $(document).ready(function() {
    $(window).scroll(function() {
        if ($(document).scrollTop() > 50) {
            $('nav').addClass('shrink');
        } 
        else {
            $('nav').removeClass('shrink');
        }
    });
});

  var emailInput;

       $("#email").on("change", function() 
       {
          emailInput = $(this).val();

          if (validateEmail(emailInput)) {
            $(this).css({
              color: "white",
              background: rgba(0,128,0,.4),
              border: "1px solid green"
          });
        } 
        else 
        {
            if(email != ""){message = "ok"; okmsg()}
            else
            {
             $(this).css({
              color: "red",
              border: "1px solid red"
          });
         }

         if (validateEmail(emailInput)) {
            message = "Everything is fine now!";
            okmsg();

        } else {
            message = "Invalid email entered.";
            errormsg();
            return false;
        }


         // alert("not a valid email address");
        } //end else

    }); //end function


       function validateEmail(email) {
          var pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

          return $.trim(email).match(pattern) ? true : false;
      }
</script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script  src="js/signup.js"></script>

</body>
</html>