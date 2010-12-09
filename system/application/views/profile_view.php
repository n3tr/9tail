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
		
	</body>
	
</html>