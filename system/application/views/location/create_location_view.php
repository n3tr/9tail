<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<title></title>	
		
		<?php echo link_tag('template_files/style.css');?>
		
		<script type="text/javascript"
		    src="http://maps.google.com/maps/api/js?sensor=true">
		</script>
		<script type="text/javascript" charset="utf-8">
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
			
			} else {
			    alert('It seems like Geolocation, which is required for this page, is not enabled in your browser. Please use a browser which supports it.');
			}
			
			function successFunction (position) {
					document.getElementsByName("usergeo_submit")[0].disabled = false;
					
				 document.getElementsByName("lat_field")[0].value = position.coords.latitude;
				document.getElementsByName("lng_field")[0].value = position.coords.longitude;
				
				var imgloader = document.getElementById('ajax_loader_location');			
				imgloader.src = 'http://localhost:8888/9tail/template_files/images/tick.png';
				var x = document.getElementsByName("usergeo_submit");
				 x[0].style.visibility = 'visible';
			}
			function errorFunction(argument) {
				alert('Sorry !! Can not get your current location');
			}
		</script>
		
</head>
<body>
		
	<?php include APPPATH.'/views/nav/global_nav_view.php';?> 
		
		<div id="main_wrap">
			<div id="header_text_wrap" class="container">
				<div id="header_text">
					<h2>Create Location:</h2>
				</div>

			</div>
			
			<div id="page_wrap" class="container">
				<div class='page_header'>
						<h2>You have 3 Options to Create New Place</h2>
				</div>
				<div class='page_box_wrap'>
				<div class='page_box_3'>
					<h3 class='page_box_header'>1. Search by Geolocation Support</h3>
					<img id='ajax_loader_location' src='http://localhost:8888/9tail/template_files/images/ajax-loader.gif' />
					<?php
					echo form_open('/location/searchbyuser','',array('lat_field'=>'','lng_field'=>''));
					echo form_submit('usergeo_submit', 'Use your current location');
					echo form_close();
					?>
				</div>
				<div class='page_box_3'>
					<h3 class='page_box_header'>2. Search By Location</h3>
					<?php
					echo form_open('/location/searchbytext');
					echo form_input('location_search_text', '');
					echo form_submit('searchtext_submit', 'Search');
					echo form_close();
					?>
				</div>
				<div class='page_box_3'>
					<h3 class='page_box_header'>3. Drop Pin on Map</h3>
					<?php echo anchor('/location/mapbypin','Create map by drop pin')?>
				</div>
				<div class='clear'></div>
				</div>
					<script type="text/javascript" charset="utf-8">
								var x = document.getElementsByName("usergeo_submit");
								 x[0].style.visibility = 'hidden';
					</script>
				
								
			</div>
			
	
		
		</div> <!--end main wrap -->
</html>
		
	