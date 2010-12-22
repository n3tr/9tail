<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>Success Sign up</title>
		<?php echo link_tag('template_files/style.css');?>
	</head>
	<body id="login-page">
		
		<?php include APPPATH.'/views/nav/non_log_gb_nav.php';?> 
		
		
		<div id="main_wrap">
			<div id="header_text_wrap" class="container">
				<div id="header_text">
					<h2>Sign up Success</h2>
				</div>

			</div>
			<div id="page_wrap" class="container">
				<div="page_message_box">
					<p>Congratulations !!</p>
					<p>Activation progress was successfully</p>
					<p> <?php echo anchor('/login','Go to Login');?> </p>
					
					
				</div>
				
		
			</div>
		</div> <!--end main wrap -->
	</body>
</html>