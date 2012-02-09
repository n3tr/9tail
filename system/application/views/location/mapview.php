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
			var relate_place = <?php echo json_encode($relate_data); ?>;
			var place = <?php echo  json_encode($place_data); ?>;
			var image_path = "<?php echo site_url('files/location_photo/thumb/');?>";
			var site_path = "<?php echo site_url('location/place/');?>";
			function initialize() {
				var myLatlng = new google.maps.LatLng(place.lat, place.lng);
				var myOptions = {
				  zoom: 14,
				  center: myLatlng,
				  mapTypeId: google.maps.MapTypeId.ROADMAP
				}
				
				var map = new google.maps.Map(document.getElementById("mapview_div"), myOptions);
				
				var infoWindow = new google.maps.InfoWindow;
				
				for (var i = 0; i < relate_place.length; i++) {
					var name = relate_place[i].name;
					var point = new google.maps.LatLng(
				              parseFloat(relate_place[i].lat),
				              parseFloat(relate_place[i].lng));
				 	var html = "<div style='width:300px;'><img width='200px' height='100px' src='" + image_path + "/" +relate_place[i].thumbnail + "'/><br/>"
								+"<b>" + name 
								+ "</b> <br/>" + relate_place[i].description 
								+ "<a href='"+ site_path +"/" + relate_place[i].id + "'>Go to "+ name+" Page</a>"
								+ "</div>"
								;
				 	var marker = new google.maps.Marker({
				            map: map,
				            position: point, 
							title:name
				          });
					bindInfoWindow(marker, map, infoWindow, html);	
				}

			

			}
			
			function bindInfoWindow(marker, map, infoWindow, html) {
			      google.maps.event.addListener(marker, 'click', function() {
			        infoWindow.setContent(html);
			        infoWindow.open(map, marker);
			      });
			    }
		
			
		</script>
		<style lang="style">
		#mapview_div{
			width:940px;
			height:400px;
			border:1px solid #666;
		}
		</style>
</head>
<body onload="initialize()">
	
	<?php include APPPATH.'/views/nav/header_nav_view.php';?> 
		
		<div id="main_wrap">
			<div id="usernav_wrap" class="container">
				<ul id="user_nav">
					<li><?php echo anchor('/location/place/'.$place_data['id'],'Place');?></li>
					<li><?php echo anchor('/location/photos/'.$place_data['id'],'Photos');?></li>
					<li><?php echo anchor('/location/tips/'.$place_data['id'],'Tips');?></li>
				</ul>
				<div class="clear"></div>
			</div>
			<div id="userinfo_wrap" class="container">

				<div id="placeinfo">
					<h2 class="user_screen_name"><?php echo $place_data['name']; ?></h2>

				</div><!-- /userinfo -->




			<div id="useravatar_box">
				<div id="place_preview">
					<img src='<?php echo site_url("files/location_photo/thumb/".$place_data["thumbnail"]);?>' />
				</div>
			</div>

		</div><!-- end userinfo_wrap-->
			<!--
			<div id="header_text_wrap" class="container">
				<div id="header_text">
					<h2>MapView: <?php echo $place_data['name'];?></h2>
				</div>

			</div>
		-->
			<div id="page_wrap" class="container">
				<div class='page_header'>
						<h2>MapView</h2>
				</div>
				<div class='page_box_wrap'>
					<div id="mapview_div"></div>
				</div><!-- end page_box_wrap-->
				</div>

			
	
		
		</div> <!--end main wrap -->
</html>
		
