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
					<h2>Login</h2>
				</div>

			</div>
			<div id="page_wrap" class="container">
				<div id="login_box">
				
				<?php if(!validation_errors() == '') :?>
						<div id="form_error">
							<?php echo validation_errors(); ?>
						</div>
				<?php endif; ?>
					<?php
						echo form_open('session/login');
						echo form_label('Your Email:', 'email');
						echo form_input('email','');

						echo form_label('Password:', 'password');
						echo form_password('password','');
						echo form_submit('submit','Login');
						echo form_close();
					?>
					
				<div class="clear"></div>
					<ul class="login_option">
						<li><?php echo anchor('login/forgot/','Forgot password,click here');?></li>
				
					</ul>
				<div class="clear">	</div>					
			</div>
			
				<div id="login_signin_box">
					<h3>Need an Account?</h3>
					<?php echo anchor('signup/', 'Click here to Sign up');?>
				</div>
				<div class="clear"></div>
		
						</div>
					</div> <!--end main wrap -->
</body>
</html>