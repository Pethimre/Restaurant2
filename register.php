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
	<style>
		html, body {
  			overflow: hidden;
		}

		.bg 
		{ 
		  background-image: url("images/steak.jpg");
		  height: 100%; 
		  background-position: center;
		  background-repeat: no-repeat;
		  background-size: cover;
		}

		.registry
		{
			background-color: rgba(255,255,255,.4);
			border-color: rgba(255,255,255,0.3);
			height: 30px;
		}

		input::placeholder {
  			color: #FFD700!important;
  			text-align: center;
	</style>
</head>
<body <?php if (isset($_SESSION["username"])) { echo "class='bg'";} ?>>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

<?php  
	if (!isset($_SESSION["username"])) {
		# code...
		echo "
				<div class='box2'>
					<img src='images/steak.jpg'>
					<div class='box-content'>
						<div class='inner-content'>
							<h3 class='title text-center'></h3>
							<span class='post'>
								<div class='container text-center'>
						<div class='form-roup'>
							<div class='container'>";
							if (!empty($errors)) { echo "<div align='center' style='background-color: rgba(255,102,102, .5)'>"; foreach ($errors as $key) { echo $key ."<br>"; } echo "</div>"; }
							echo "<form method='post' action='register.php'
							  <div class='col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3'>
							    <div class='login-button-container clearfix'>

							      <div class='col-xs-6 sign-in'>
							        <button class='btn sign-in__button active registry'>
							          Sign in here       
							        </button>
							      </div>

							      <div class='col-xs-6 register'>
							        <button class='btn register__button registry'>
							          Sign up here        
							        </button>
							      </div>

							    </div>
							  </div>

							  <div class='col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3'>

							    <div class='row login__form' style='display: block;'>
							      <form action='register.php' method='post'>
							        <div>
							          <fieldset class='form__fieldset required form__login'>
							            <legend class='form__legend--subtitle' style='color:white;'>
							              Welcome back!</legend>

							            <div class='form__field__wrapper form-item'> <label for='edit-email' class='text-input__label'><span class='form-required' aria-hidden='true' title='This field is required.'></span></label>
							              <input class='form-control form-text required text-input__field registry' type='text' id='edit-email' name='username' size='60' maxlength='128' aria-describedby='edit-email-descriptor' placeholder='Username' value='"; if(!empty($username)){echo $username;} echo "'>
							            </div>
							            <div class='form__field__wrapper form-item'> <label for='edit-password' class='text-input__label'><span class='form-required' aria-hidden='true' title='This field is required.'></span></label>
							              <input class='form-control form-text password__field text-input__field required registry' type='password' id='edit-password' name='password' size='60' maxlength='128' placeholder='Password'>
							            </div><br>
							          </fieldset>
							          <button name='login_user' class='inpt-btn btn btn-primary form-submit js-registerSubmit' type='submit' id='edit-submit' style='background-color:rgba(0,0,0,.2);'>Sig in</button>
							          <button class='inpt-btn btn btn-danger form-submit js-registerSubmit'style='background-color:rgba(0,0,0,.2);'><a href='index.php' style='text-decoration:none; background:transparent; color:white;'>Back</a></button>
							        </div>
							      </form>
							    </div>

							    <div class='row register__form' style='display: none;'>
							      <div id='registration-form-wrapper'>
							        <form action='register.php' method='POST'>
							          <div>
							            <div class='form__register'>


							              <div class='clearfix'></div>

							              <div class='divide-width'>
							                <div class='middle-bottom-inner-left'>
							                  <div class='form__field__wrapper form-item'> <label for='edit-username' class='text-input__label'><span class='form-required' aria-hidden='true' title='This field is required.'></span></label><br> <br>
							                    <input placeholder='Username' class='form-control form-text required text-input__field registry' type='text' id='edit-username' name='new_username' size='60' maxlength='128' aria-describedby='edit-username-descriptor' value='"; if(!empty($username)){echo $username;} echo "'>
							                  </div>
							                </div>
							              </div>
							              <div class='divide-width divide-mrgn'>
							                <div class='middle-bottom-inner-left'>
							                  <div class='form__field__wrapper form-item'> <label for='edit-input' class='input__label'><span class='form-required' aria-hidden='true' title='This field is required.'></span></label>
							                    <input placeholder='Email address' class='form-control form-text required text-input__field registry' type='text' id='edit-email--2' name='new_email' size='60' maxlength='128' aria-required='true' aria-describedby='edit-email--2-descriptor' value='"; if(!empty($email)){echo $email;} echo "'>
							                  </div>
							                </div>
							              </div>
							              <div class='middle-bottom-inner-left'>
							                <div class='form__field__wrapper form-item'> <label for='edit-email--2' class='input__label'><span class='form-required' aria-hidden='true' title='This field is required.'></span></label>
							                  <input placeholder='Password' class='form-control form-text required text-input__field registry' type='password' id='edit-input' name='password1' size='60' maxlength='128' aria-required='true' aria-describedby='edit-input-descriptor'>
							                </div>
							              </div>

							              <div class='middle-bottom-inner-left-pass'>
							                <div class='form-type-password form-item-password form-item form-group' id='display-second-part'>
							                  <div class='form__field__wrapper form-item'> <label for='edit-password--2' class='text-input__label'></label>
							                    <input class='form-group form-control form-text password__field text-input__field registry' placeholder='Confirm Password' data-edit-password='true' type='password' id='edit-password--2' name='password2' size='60' maxlength='128'> <span class='field-suffix'><span id='passwordval'></span></span>
							                  </div>

							                </div>
							              </div>

							            </div>
							            <button class='inpt-btn btn btn-primary form-submit js-registerSubmit' type='submit' id='edit-submit--2' name='reg_user' style='background-color:rgba(0,0,0,.2);'>Register</button>
							            <button class='inpt-btn btn btn-danger form-submit js-registerSubmit'style='background-color:rgba(0,0,0,.2);'><a href='index.php' style='text-decoration:none; background:transparent; color:white;'>Back</a></button>
							          </div>
							        </form>
							      </div>
							    </div>
							</form>
							  </div>

							</div>
						</div>
					</div>
							</span>
							<ul class='icon'>
								<li></li>
								<li></li>
							</ul>
						</div>
					</div>
				</div>
		";
	}
?>

<script>
	$('.register__form').hide();

	$('.sign-in__button').click(function(e) {
		e.preventDefault();
		$(this).addClass('active');
		$('.register__button').removeClass('active');
		$('.login__form').show();
		$('.register__form').hide();
   $('#edit-email').focus(); //Should appear after $('.login__form').show(); because if it's before that, the register form doesn't exist in the DOM
});

	$('.register__button').click(function(e) {
		e.preventDefault();
		$(this).addClass('active');
		$('.sign-in__button').removeClass('active');
		$('.register__form').show();
		$('.login__form').hide();
   $('#edit-username').focus(); //Should appear after $('.register__form').show(); because if it's before that, the register form doesn't exist in the DOM
});
</script>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>