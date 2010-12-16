<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title></title>
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
				  zoom: 16,
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
	<div id="map_view" style="width: 400px; height: 300px; position: relative; background-color: rgb(229, 227, 223); overflow: hidden; z-index: 0;">
		
	</div>
	<div id="location_form">
		<?php
		echo form_open('location_created','',array('location_lat'=>$location_data['lat'],'location_lng'=>$location_data['lng']));
		echo form_label('Location Name', 'location_name');
		echo form_input('location_name', '');
		
		echo form_label('Address:','location_address');
		echo form_input('location_address',$location_data['route']);
		
		echo form_label('Tamboon:','location_tamboon');
		echo form_input('location_tambon',$location_data['locality']);
		
		echo form_label('Amphoe','location_amphoe');
		echo form_input('amphoe',$location_data['amphoe']);
		
		echo form_label('Province','location_province');
		echo form_input('location_province', $location_data['province']);
		
		echo form_label('Country','location_country');
		echo form_input('location_country',$location_data['country']);
		
		echo form_label('Postal Code','location_postal_code');
		echo form_input('location_postal_code',$location_data['postal_code']);
		
		echo form_submit('location_submit', 'Create');
		echo form_close();
		?>
	</div>
</body>
</html>