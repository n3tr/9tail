<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title></title>
</head>
<body>
	<div id="global-nav">
		<ul>
			<li><a href="<?php echo base_url();?>">9Tail</a></li>
			<li><a href="<?php echo site_url("/"); ?>">Home</a></li>
			<li><a href="<?php echo site_url("/friend/"); ?>">Friend</a></li>
			<li><a href="<?php echo site_url("/location/"); ?>">Place</a></li>
			<li><?php echo anchor('session/destroy','Logout');?></li>
		</ul>
	</div>
	<?php
	if (isset($request_list)) {
		
		?>
			<ul>
					<?php
				foreach ($request_list as $row) {
					echo '<li>';
					echo anchor('/user/'.$row['screen_name'],$row['screen_name']); 
					echo anchor('/friend/confirm/' . $row['friend_guid']. '/', 'Accept Friend');	
				}
			?>
		
			</ul>
			<?php
	}else {
		echo "no have any request now";
	}
	?>
	
</body>
</html>