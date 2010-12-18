<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
		foreach ($map_results as $result) {
			$str = 'http://maps.google.com/maps/api/staticmap?center='. $result->geometry->location->lat.','.$result->geometry->location->lng.
			'&markers=color:blue|label:S|'.$result->geometry->location->lat.','.$result->geometry->location->lng.
			'&maptype=terrain&zoom=15&size=300x150&sensor=false';
		echo img($str);
			
				
		echo anchor('/location/result_selected/'.$result->geometry->location->lat.'/'.$result->geometry->location->lng,
		$result->formatted_address);
			
		}
	?>
	
</body>
</html>