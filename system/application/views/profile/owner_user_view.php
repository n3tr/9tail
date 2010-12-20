<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title><?php echo $owner_data['screen_name']?>'s Profile : Home</title>
		<?php echo link_tag('template_files/style.css');?>
	</head>
	<body id="profile">
		
			<?php include APPPATH.'/views/nav/global_nav_view.php';?> 
		
		<div id="main_wrap">
			<div id="usernav_wrap" class="container">
				<ul id="user_nav">
					<li><?php echo anchor('/user/'.$owner_data['screen_name'],'Profile');?></li>
					<li><a href="#">Photo</a></li>
					<li><?php echo anchor('/friend/user/'.$owner_data['screen_name'],'Friend');?></li>
				</ul>
				<div class="clear"></div>
			</div>
			
			<div id="userinfo_wrap" class="container">

			<div id="userinfo">
				<h2 class="user_screen_name"><?php echo $owner_data['screen_name']; ?></h2>
				<p class="user_full_name"><?php echo $owner_data['firstname'] . ' ' . $owner_data['lastname'];?></p>
				<h2><?php echo anchor('/friend/','Friend: ' . $friend_count . ' People');?></h2>
			</div>
		
			<div id="useravatar_box">
			<img src='http://localhost:8888/9tail/static-html/images/useravatar.png' />
			</div><!-- end userinfo_wrap-->
		
		</div>
		
		<div id="content" class="container">
			<div id="page">
				<div id="page_inner">
					
					<div id="message_post_box">
						<?php
						$hidden = array(
							'from' => $owner_data['id'],
							'to' => $owner_data['id']
							);
						$fval = array(
							'value'=>'Post',
							'type'=>'submit',
							'name'=>'post_message_submit',
							'class'=>'submit_message_bth'
							);
							echo form_open('/message/post','', $hidden);
							echo form_textarea('text');
							echo form_submit($fval);
							echo form_close();
						?>
						<div class="clear"></div>
					</div>

		
						<div id="messages">
						<?php if (count($messages) > 0) : ?>
				
							<?php foreach ($messages as $row) : ?>
				
								<div class="message">
									<div class="message_content">
										<div class="user_avatar">
											<?php echo anchor('user/'.$row['screen_name'], "<img src='http://localhost:8888/9tail/static-html/images/useravatar.png' />");?>										
										</div>
										<div class="message_text">
											<?php echo anchor('user/'.$row['screen_name'], $row['screen_name'],array('class'=>'user_link'));?>
											<?php echo '<p>' . $row['text'] .'</p>' .' <i>'. $row['datetime'] . '</i>';?>								
										</div>
										<div class="clear"></div>
									</div>
								</div>
								<?php endforeach; ?>

							<?php endif; ?>
							</div>
						</div>
					</div>
					<div id="sidebar">
						<div class="widget_box location_widget">
							<ul>
								<li><?php echo anchor('/checkin/','Check-in'); ?></li>
								<li><a href="#">Add Photo</a></li>

							</ul>
						</div>

						<div class="widget_box">
							<h3 class="widget_title">Widget Title</h3>
							<?php 
							$image = '<img src="http://maps.google.com/maps/api/staticmap?center=' . 
							$last_checkin['lat'] .
							 ',' . 
							$last_checkin['lng'] .
							'&zoom=15&size=340x160&
							markers=color:blue|label:P|'.
							$last_checkin['lat'] .
							 ',' . 
							$last_checkin['lng'] .
							'&maptype=terrain&sensor=false" />';
							echo anchor('location/place/'. $last_checkin['place_id'],$image);

							?>
						</div>
						<div class="widget_box">
							<h3 class="widget_title">Widget Title</h3>
							<img src="./images/map_preview.png"/>
						</div>
						<div class="widget_box">
							<h3 class="widget_title">Widget Title</h3>
							<img src="./images/map_preview.png"/>
						</div>
					</div>
					<div class="clear"></div>

			</div> <!--end main wrap -->
			
		 
	
	</body>
	
</html>