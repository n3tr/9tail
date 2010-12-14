<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>profile page</title>
		
	</head>
	<body id="profile" onload="GetMap();">
		<?php
		
		echo anchor('session/destroy','Logout');
		?>
		
		<img src='http://maps.google.com/maps/api/staticmap?center=40.714728,-73.998672&zoom=15&size=300x200&maptype=terrain&sensor=false' />
		
		<div>
			<h3>User: <?php echo $user_data['screen_name']; ?></h3>
			<h4><?php echo $user_data['firstname'] . ' ' . $user_data['lastname'];?></h4>
			<h5><?php echo 'friend count' . $friend_count;?></h5>
			<?php echo anchor('/friend/request_friend/' . $user_data['screen_name'],'Request Friend'); ?>
		</div>
		
		<div>
		<?php
		$hidden = array(
			'from' => $owner_data['id'],
			'to' => $user_data['id']
			);
			echo form_open('/message/post','', $hidden);
			echo form_textarea('text');
			echo form_submit('submit','Submit');
			echo form_close();
		?>
		</div>
		
	</body>
	
</html>