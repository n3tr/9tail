<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title><?php echo $user_data['screen_name']?>'s Profile : Home</title>
		<?php echo link_tag('template_files/style.css');?>
			
			
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js"></script>

		
	</head>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function(){
			$("#checkinhere").click(function(){

				
			 	$('#overlay').fadeIn('medium');
				$('#checkin_box').show('slow');

				return false;

			});

			$('.cancel_checkin').click(function(){
				$('#place_tip_box').fadeOut('medium');
				$('#checkin_box').fadeOut('medium');
				$('#overlay').fadeOut('medium');
				return false;
			});
			
			$('#place_add_tip').click(function(){

				$('#place_tip_box').fadeIn('medium');
				$('#overlay').fadeIn('medium');
					return false;
			});
			
			$('#place_upload_photo').click(function(){

				$('#place_photo_box').fadeIn('medium');
				$('#overlay').fadeIn('medium');
					return false;
			});
			
			$('#overlay').click(function(){
					$('#place_tip_box').fadeOut('medium');
					$('#place_photo_box').fadeOut('medium');
					$('#checkin_box').fadeOut('medium');
					$('#overlay').fadeOut('medium');
					return false;
			});
			
			$('#post_tip_submit').click(function(){
					var tiptext = $("#tip_text").val();
				if(tiptext.trim() == ''){
					alert('Tip box cant Empty ');
					return false;
				}
				$('#tip_text').attr('disabled','disabled');
				$('#post_tip_submit').attr('disabled','disabled');
				var placeid = <?php echo $place_data['id']; ?>;
				var userid  = <?php echo $user_data['id']; ?>;
				var url = '<?php echo site_url('tip/addtip_from_place')?>';
			
				var tip_data = {
					tip_text:tiptext,
					place_id:placeid,
					user_id:userid,
					ajax:'1'
				}
				
					$.post(url,tip_data,function(data){
					
						$(data).prependTo('#tips');
							
						$('#tip_text').val('');
						$('#tip_text').removeAttr('disabled');
						$('#post_tip_submit').removeAttr('disabled');
						$('#place_tip_box').fadeOut('medium');
						$('#checkin_box').fadeOut('medium');
						$('#overlay').fadeOut('medium');
					});
				return false;	
			});
		});
	</script>
	<body id="profile">
		
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
	
	<div id="content" class="container">
		<div id="page">
			<div id="page_inner">
				
					<h2 class='content_title'>Place's Photo</h2>
					<div id='place_photo'>
						<?php if (count($photo_data) > 0) : ?>
						<?php foreach ($photo_data as $photo): ?>
							<div class="place_photo_box">
							<a href=<?php echo site_url('location/photo_view/' . $photo['id']);?>>
							<img class="photo" src=<?php echo site_url('files/location_photo/thumb/'.$photo['thumbnail_path']);?>>
							</a>
							</div>
						<?php endforeach; ?>
						<?php else : ?>
							<p>No Image was uploaded to this place</p>
							
						<?php endif;?>
					</div>
					<div class="clear"></div>
					
				
					</div>
				</div>
				<div id="sidebar">
					
						<div class="widget_box location_widget">
							<ul>
								<li><a href="#" id='checkinhere'>Check-in Here</a></li>
								<li><a href="#" id='place_add_tip'>Add Tip</a></li>
								<li><a href="#" id='place_upload_photo'>Add Photo</a></li>

							</ul>
						</div>
					
					<div class="widget_box place_info_widget">
						<h3 class="widget_title">Place Info</h3>
						<ul>
							<li><strong>Title:</strong> <?php echo $place_data['name']?></li>
							<li><strong>Descripstion:</strong> <?php echo $place_data['description']?></li>
							<li><strong>Address:</strong> <?php echo $place_data['address'] . ', ' . 
							$place_data['tambon'] . ', ' . 
							$place_data['amphoe'] . ', ' .
							$place_data['province'] . ', ' .
							$place_data['country'] . ', ' .
							$place_data['postal']?></li>
						</ul>
					</div>
			
					
					<div class="widget_box">
							<h3 class="widget_title">Who are here:</h3>
							<?php if(!$user_in_location ==0): ?>
							<?php foreach ($user_in_location as $user) :?>
							<a href="<?php echo site_url('/user/'.$user['screen_name'])?>">
							<img src="<?php echo site_url('files/user_photo/thumb/'.$user['thumbnail']); ?>" width='100' height='100' />
							</a>
						<?php endforeach;?>
					<?php endif;?>
					</div>
					
					<!--
					<div class="widget_box">
						<h3 class="widget_title">Widget Title</h3>
						<img src="./images/map_preview.png"/>
					</div>
					
					-->
				</div>
				<div class="clear"></div>

		</div> <!--end main wrap -->
		<div class="overlay" id="overlay" style="display:none;"></div>
			<div class="box" id="checkin_box">
				 <a class="boxclose" id="boxclose"></a>
			 <h1>Confirm Check-in to</h1>
				 <p id="confirm_place">
				 
				 </p>
				<ul id="confirm_bth">
					<li><?php echo anchor('checkin/place/'.$place_data['id'],'Confirm Check-in');?></li>
					<li><a href="#" class="cancel_checkin">Cancel</a></li>
				</ul>
			 
				
			</div>
			
			<div class="box" id="place_tip_box">
				
			 <h1>Add Tip to this Place</h1>
				<div id="message_post_box">
					<?php
					/*
					$hidden = array(
						'tip_place_id' => $place_data['id'],
						'tip_user_id' => $user_data['id'] 
						);*/
					$fval = array(
						'value'=>'Add Tip',
						'type'=>'submit',
						'name'=>'post_tip_submit',
						'class'=>'submit_message_bth',
						'id'=>'post_tip_submit'
						);
					echo form_open('#','#');
			
				echo '<textarea name="tip_text" id="tip_text"></textarea>';
					echo form_submit($fval);
					echo form_close();
					?>
					<div class="clear"></div>
				</div><!-- message_post_box -->
				
			</div>
			
			<div class="box" id="place_photo_box">
				
			 <h1>Upload Photo to this Place</h1>
				<div id="photo_upload_box">
					<?php
					/*
					$hidden = array(
						'tip_place_id' => $place_data['id'],
						'tip_user_id' => $user_data['id'] 
						);*/
					$pval = array(
						'value'=>'Upload',
						'type'=>'submit',
						'name'=>'upload_photo_submit',
						'class'=>'submit_message_bth',
						'id'=>'upload_photo_submit'
						);
						$hidden = array(
							'place_id' => $place_data['id'],
							'user_id' => $user_data['id']
							);
					echo form_open_multipart('location/photo_upload');
					echo form_hidden('place_id',$place_data['id']);
					echo form_hidden('user_id',$user_data['id']);
					echo form_upload('userfile');
					echo form_submit($pval);
					echo form_close();
					?>
					<div class="clear"></div>
				</div><!-- message_post_box -->
			
			 
				
			</div>
</body>

</html>