<!DOCTYPE html> 
<html> 
	<head> 
	<title>Page Title</title> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.5.min.js"></script>
	<script type="text/javascript">
		    $(document).bind("mobileinit", function () {
		           $.mobile.ajaxLinksEnabled = false;
					$.mobile.ajaxEnabled = false;
		     });
	</script>
	<script type="text/javascript" src="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.js"></script>
	<style>
		label,input{
			display:block;
		}
	</style>
</head> 
<body> 
	<div data-role="page"> 
	
		<div data-role="content">
		<?php 
			echo form_open('login/signin/');
			echo form_label('Email:','email');
			echo form_input('email');
			echo form_label('Password:','password');
			echo form_password('password');
			echo form_submit('submit','Sign in');
			echo form_close();
		?>
		</div> 
	
	</div>

	

</body>
</html>