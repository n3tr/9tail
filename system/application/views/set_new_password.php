<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>Password Reset Page</title>
		<?php echo link_tag('template_files/style.css');?>
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('input[type="submit"]').click(function(){
					var new_passwd = $('input[name="reset_password"]').val();
					
					var con_passwd = $('input[name="reset_conpassword"]').val();
					
					if (new_passwd != con_passwd) {
						alert('Password not match, Please check Your password again');
						return false;
					};
				
				});
				
			});
		</script>
	</head>
	<body id="login-page">
		
		<?php include APPPATH.'/views/nav/non_log_gb_nav.php';?> 
		
		
		<div id="main_wrap">
			<div id="header_text_wrap" class="container">
				<div id="header_text">
					<h2>Password Recovery</h2>
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
						echo form_open('login/set_new_password');
						echo form_hidden('password_id',$password_id);
						echo form_hidden('guid',$guid);
						echo form_label('Password:', 'password');
						echo form_password('reset_password');
						echo form_label('Confirm Password:', 'conpassword');
						echo form_password('reset_conpassword');
						echo form_submit('submit','Submit');
						echo form_close();
					?>
					
				<div class="clear"></div>			
			</div>
			
		
						</div>
					</div> <!--end main wrap -->
</body>
</html>