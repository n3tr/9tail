<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title></title>
		<?php echo link_tag('template_files/style.css');?>
</head>
<body>

	<?php include APPPATH.'/views/nav/header_nav_view.php';?> 
	
	<div id="main_wrap">
				<div id="usernav_wrap" class="container">
					<ul id="user_nav">
						
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
		
				
							<div id="page_wrap" class="container">

								<div class="page_box_wrap center">
									
								
									<div class="single_image">
										<?php echo img(site_url('/files/location_photo/'.$photo_data['image_path'])); ?>
										
									</div>
									<div style="width:500px;margin:0 auto;">
									<?php
										echo form_open('/location/setcaption/');
										echo form_hidden('place_id',$photo_data['place_id']);
										echo form_hidden('photo_id',$photo_data['id']);
										echo form_hidden('photo_guid',$photo_data['guid']);
										echo form_hidden('user_id',$photo_data['user_id']);
									?>
										<textarea name="caption_text" rows="4" cols="40" style="display:block;margin:0 auto;"></textarea>
										<input type="submit" name="submit" value="Set Caption" class='submit_message_bth' id="submit">
									<?php
										
										echo form_close();
									
									?>
									</div>
									

										

								</div>



							</div>

					</div>
	

</body>
</html>