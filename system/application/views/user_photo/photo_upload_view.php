<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>Photo Upload</title>
</head>
<body>
	<?php 
		echo form_open_multipart('photo/upload');
		echo form_upload('userfile');
		echo form_submit('upload','Upload');
		echo form_close();
	?>
	
</body>
</html>