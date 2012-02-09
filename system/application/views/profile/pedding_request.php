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
			<p class="user_full_name"><?php echo $user_data['firstname'] . ' ' . $user_data['lastname'];?></p>
		
		</div>
	
		<div id="useravatar_box">
		<div id="useravatar">
		<img src='<?php echo site_url("files/user_photo/thumb/".$user_data["thumbnail"]);?>' />
		</div>
		</div><!-- end userinfo_wrap-->
	
	</div>
	
	<div id="page_wrap" class="container center">
		<?php if(isset($friend_guid) && $friend_guid != 0) : ?>
		
		<?php echo anchor('friend/confirm/'. $friend_guid['guid'] .'/'.$user_data['screen_name'],'Click to accept '.$user_data['screen_name'].' to be your friend.');
	 	elseif(isset($friend_pedding) && $friend_pedding != 0):?>
			<p>Waiting for User Accept</p>
	
		<?php else:
			echo anchor('/friend/request_friend/'.$user_data['screen_name'],'Sent friend request to '.$user_data['screen_name']);
	 	endif;?>
	</div>
	</div> <!--end main wrap -->
</body>

</html>