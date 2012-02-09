<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title><?php echo $user_data['screen_name']?>'s Profile : Home</title>
		<?php echo link_tag('template_files/style.css');?>
			
	</head>
	<body id="profile" onload="GetMap();">
		
		<?php include APPPATH.'/views/nav/global_nav_view.php';?> 
	
	<div id="main_wrap">
			<div id="usernav_wrap" class="container">
				<ul id="user_nav">
					<li><?php echo anchor('/user/'.$user_data['screen_name'],'Profile');?></li>
					<li><?php echo anchor('/photo/user/'.$user_data['screen_name'],'Photo');?></li>
					<li><?php echo anchor('/friend/user/'.$user_data['screen_name'],'Friend');?></li>
				</ul>
				<div class="clear"></div>
			</div>
		
		<div id="userinfo_wrap" class="container">

		<div id="userinfo">
			<h2 class="user_screen_name"><?php echo $user_data['screen_name']; ?></h2>
			<span class="user_full_name"><?php echo $user_data['firstname'] . ' ' . $user_data['lastname'];?></span>
		
		</div>
	
		<div id="useravatar_box">
		
		<div id="useravatar">
		<img src='<?php echo site_url("files/user_photo/thumb/".$user_data["thumbnail"]);?>' />
		</div>
		</div>
	
	</div><!-- end userinfo_wrap-->
	
	<div id="content" class="container">
		<div id="page">
			<div id="page_inner">
				
				<div id="message_post_box">
					<?php
					$hidden = array(
						'from' => $owner_data['id'],
						'to' => $user_data['id']
						);
					$fval = array(
						'value'=>'Post',
						'type'=>'submit',
						'name'=>'post_message_submit',
						'class'=>'submit_message_bth'
						);
						echo form_open('/message/post','', $hidden);
						echo '<textarea name="text" id="msg_text"></textarea>';
					
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
									
									<?php echo anchor('user/'.$row['screen_name'], "<img src=".site_url("files/user_photo/thumb/".$row['small_thumbnail'])." />");?>	
																			
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
					
					<div class="widget_box">
						<h3 class="widget_title">You're Here</h3>
							<?php 
								if(!$last_checkin ==0){
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
								}else{
									echo '<p>This user not check-in yet.</p>';
								}

							?>
					</div>
					<div class="widget_box">
						<h3 class="widget_title">Who stay here</h3>
						
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
</body>

</html>