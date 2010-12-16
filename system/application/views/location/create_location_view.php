<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<title></title>
		<style type="text/css">
		  html { height: 100% }
		  body { height: 100%; margin: 0px; padding: 0px }
		  #map_canvas { height: 100% }
		</style>
		
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
			}
			function errorFunction(argument) {
				alert('Sorry !! Can not get your current location');
			}
		</script>
	


	</head>

	<body>
		<h1>Create New Location</h1>
		<h2>you have 3 Options to Create New Place</h2>
		
		<h3>1. Search by Geolocation Support</h3>
		
		<?php
		echo form_open('/location/searchbyuser','',array('lat_field'=>'','lng_field'=>''));
		echo form_submit('usergeo_submit', 'Use your current location');
		echo form_close();
		?>
		
		<h3>2. Search By Location</h3>
		<?php
		echo form_open('/location/searchbytext');
		echo form_input('searchtext', '');
		echo form_submit('searchtext_submit', 'Search');
		echo form_close();
		?>
		
		<h3>3. Drop Pin on Map</h3>
		<?php echo anchor('/location/mapbypin','Create map by drop pin')?>
		
		<script type="text/javascript" charset="utf-8">
					var x = document.getElementsByName("usergeo_submit");
					 x[0].disabled = true;
		</script>
		<?php
		foreach ($map_results as $map) {
			print_r($map->formatted_address);
			
		}
		?>
		

		
		
	</body>
	</html>