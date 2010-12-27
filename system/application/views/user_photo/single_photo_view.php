<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title></title>
		<?php echo link_tag('template_files/style.css');?>
</head>
<body>

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
		
				
							<div id="page_wrap" class="container">

								<div class="page_box_wrap center">
									
									<?php if(isset($photo)) : ?>
									<div id='photo_nav'>
									<?php echo anchor('/album/id/'.$photo['album_id'],'Back to album',array('class'=>'float_left blue_link')); ?>
									
									<?php if($user_data['id'] == $owner_data['id']) : ?>
									<?php echo anchor('/album/set_thumb/'.$photo['id'],'Set as Album Photo',array('class'=>'blue_link')); ?>
									<?php echo anchor('/user/set_profile_image/'.$photo['id'],'Set as Photo Profile',array('class'=>'float_right blue_link')); ?>
								<?php endif; ?>
										<div class="clear"></div>
									</div>
									<div class="single_image">
										<?php echo img(site_url('/files/user_photo/'.$photo['path'])); ?>
										
									</div>
									<?php else: ?>

										<p>You not have any photo</p>
										
										<p>Start upload Photo</p>

									<?php endif;?>

								</div>



							</div>

					</div>
	

</body>
</html>