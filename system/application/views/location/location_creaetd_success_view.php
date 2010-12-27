

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>Login Page</title>
		<?php echo link_tag('template_files/style.css');?>
	</head>
	<body id="login-page">
		
		<?php include APPPATH.'/views/nav/global_nav_view.php';?> 
		
		
		<div id="main_wrap">
			<div id="header_text_wrap" class="container">
				<div id="header_text">
					<h2>Location Created:</h2>
				</div>

			</div>
			<div id="page_wrap" class="container">
				
				<div class='page_box_1'>
					<h3 class='page_box_header'>Your Location was Created.</h3>
					
					<p>Start Check-in to your Location : <?php echo anchor('/checkin/place/'.$place['id'],'Click here to Check-in to ' .$place['name']); ?></p>
					
					<p>You can visit Location Page Here : <?php echo anchor('/location/'.$place['id'],$place['name']); ?></p>
				</div>
			
				<div class="clear"></div>
		
			</div>
		</div> <!--end main wrap -->
	</body>
</html>




