<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>Register Page</title>
		<style type="text/css" media="screen">
			label{
				display:block;
			}
			input{
				display:block;
			}
		</style>
	</head>
	<body id="register-page">
		
		<div id='register-form'>
				<?php echo validation_errors(); ?>
			<?php 
				echo form_open('user/register_submit');
				
				echo form_label('Email:', 'email');
				echo form_input('email',set_value('email'));
				
				echo form_label('Password:', 'password');
				echo form_password('password');
				
				echo form_label('Screen Name', 'screen_name');
				echo form_input('screen_name',set_value('screen_name'));
				
				echo form_label('first Name:', 'firstname');
				echo form_input('firstname',set_value('firstname'));
				
				echo form_label('Last Name:', 'lastname');
				echo form_input('lastname',set_value('lastname'));
				
				echo form_submit('submit', 'Submit');
				echo form_close();
			
			?>
		
		
		</div>
	</body>
</html>