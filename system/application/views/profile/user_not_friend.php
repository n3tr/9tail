<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>profile page</title>
		
	</head>
	<body id="profile" onload="GetMap();">
		
		<div id="global-nav">
			<ul>
				<li><a href="<?php echo base_url();?>">9Tail</a></li>
				<li><a href="<?php echo site_url("/"); ?>">Home</a></li>
				<li><a href="<?php echo site_url("/friend/"); ?>">Friend</a></li>
				<li><a href="<?php echo site_url("/location/"); ?>">Place</a></li>
				<li><?php echo anchor('session/destroy','Logout');?></li>
			</ul>
		</div>
		
		<img src='http://maps.google.com/maps/api/staticmap?center=40.714728,-73.998672&zoom=15&size=300x200&maptype=terrain&sensor=false' />
		
		<div>
			<h3>User: <?php echo $user_data['screen_name']; ?></h3>
			<h4><?php echo $user_data['firstname'] . ' ' . $user_data['lastname'];?></h4>
			<h5><?php echo anchor('/friend/user/'.$user_data['screen_name'],'Friend: ' . $friend_count . ' People');?></h5>
			<?php echo anchor('/friend/request_friend/' . $user_data['screen_name'],'Request Friend'); ?>
		</div>
		
		
	</body>
	
</html>