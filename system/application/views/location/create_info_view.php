<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title></title>
	<?php echo link_tag('template_files/style.css');?>
	<script type="text/javascript"
	    src="http://maps.google.com/maps/api/js?sensor=false">
	</script>
	
		<script type="text/javascript" charset="utf-8">
			var center = new google.maps.LatLng(<?php echo $location_data['lat']; ?>, <?php echo $location_data['lng']; ?>);
			var markerpos = new google.maps.LatLng(<?php echo $location_data['lat']; ?>, <?php echo $location_data['lng']; ?>);
			var marker;
			var map;
			function initialize() {
					
				var mapOption = {
				  zoom: 15,
				  center: center,
				  mapTypeId: google.maps.MapTypeId.TERRAIN
				};
				
				map = new google.maps.Map(document.getElementById("map_view"),mapOption);
				
				marker = new google.maps.Marker({
				    map:map,
				    draggable:true,
				    animation: google.maps.Animation.DROP,
				    position: markerpos
				  });
				 
				 google.maps.event.addListener(map, 'click', function(event) {
				    moveMarker(event.latLng);
				  });
				
				google.maps.event.addListener(marker, 'position_changed', function() {
				  	
					document.getElementsByName('location_lat')[0].value = marker.getPosition().lat();
					document.getElementsByName('location_lng')[0].value = marker.getPosition().lng();
				  });
			
			}
			
			function moveMarker(location) {
				
				marker.setAnimation(google.maps.Animation.DROP)
				marker.setPosition(location);
				map.panTo(location);
			}
			
		
			
		</script>
</head>
<body onload="initialize()">
	
	<?php include APPPATH.'/views/nav/global_nav_view.php';?> 
		
		<div id="main_wrap">
			<div id="header_text_wrap" class="container">
				<div id="header_text">
					<h2>Edit Location Info:</h2>
				</div>

			</div>
			
			<div id="page_wrap" class="container">
				<div class='page_header'>
						<h2>Location Info</h2>
				</div>
				<div class='page_box_wrap'>
					<div class='page_map_box'>
						<div id="map_view" style="width: 400px; height: 300px; position: relative; background-color: rgb(229, 227, 223); overflow: hidden; z-index: 0;"></div>
						<div>
							<ul>
								<li>You can Drag pin to location you want.</li>
								<li>Remainder if you drag pin location position will change.</li>
							
							</ul>
						</div>
					</div> <!--- /page_map_box-->
						<div class='location_info_box'>
							<div id="form_error">
								<?php echo validation_errors(); ?>
							</div>
							<?php
							echo form_open('location/location_created',array('class'=>'location_info_form'));
							echo form_hidden('location_lat', $location_data['lat']);
							echo form_hidden('location_lng', $location_data['lng']);
							echo form_label('Location Name', 'location_name');
							echo form_input('location_name', '');

							echo form_label('Description','location_description');
							echo form_textarea('location_description',isset($location_data['description']) ? $location_data['description'] : '');

							echo form_label('Address:','location_address');
							echo form_input('location_address',isset($location_data['route']) ? $location_data['route'] : '');
						
							echo form_label('Tamboon:','location_tamboon');
							echo form_input('location_tambon',isset($location_data['locality']) ? $location_data['locality'] : '');

							echo form_label('Amphoe','location_amphoe');
							echo form_input('location_amphoe',isset($location_data['amphoe']) ? $location_data['amphoe'] : '');

							echo form_label('Province','location_province');
							echo form_input('location_province', isset($location_data['province']) ? $location_data['province'] : '');

							echo form_label('Country','location_country');
							echo form_input('location_country',isset($location_data['country'])? $location_data['country'] : '');

							echo form_label('Postal Code','location_postal_code');
							echo form_input('location_postal_code',isset($location_data['postal_code']) ? $location_data['postal_code'] : '');

							echo form_submit('location_submit', 'Create');
							echo form_close();
							?>
						</div><!-- /location info form-->
				
					<div class='clear'></div>
				</div><!-- end page_box_wrap-->
				</div>

			
	
		
		</div> <!--end main wrap -->
</html>
		
