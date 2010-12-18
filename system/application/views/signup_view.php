

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>Login Page</title>
		<?php echo link_tag('template_files/style.css');?>
	</head>
	<body id="login-page">
		
		<?php include APPPATH.'/views/nav/non_log_gb_nav.php';?> 
		
		
		<div id="main_wrap">
			<div id="header_text_wrap" class="container">
				<div id="header_text">
					<h2>Sign up Form</h2>
				</div>

			</div>
			<div id="page_wrap" class="container">
				<div id="signup_box">
					<div id="form_error">
						<?php echo validation_errors('<div id="error">','</div>'); ?>
					</div>
								<?php 
									echo form_open('signup/submit');

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
					
					
				<div class="clear"></div>				
			</div>
			
			
				<div class="clear"></div>
		
			</div>
		</div> <!--end main wrap -->
	</body>
</html>




