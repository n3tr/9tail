<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>Login Page</title>
		<style type="text/css" media="screen">
			label{
				display:block;
				
			}
			input{
				display:block;
				
			}
		</style>
	</head>
	<body id="login-page">
	
		<div id="form-error">
			<?php echo validation_errors(); ?>
		</div>
		<div id='login_box'>
		<?php
			echo form_open('session/login');
			echo form_label('Your Email:', 'email');
			echo form_input('email','Email');
			
			echo form_label('Password:', 'password');
			echo form_password('password','Password');
			echo form_submit('submit','Login');
			echo form_close();
		?>
		</div>
		<?php
		echo anchor('/signup','New User? Click Here to Register');
		
		?>
	</body>
</html>