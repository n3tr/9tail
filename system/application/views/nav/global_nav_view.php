<div id="global_nav_wrap">
	<div id="global_nav" class="container">
		<h1 id="logo"><a href="<?php echo base_url();?>">9Tail</a></h1>
		<ul id="main_nav">
				<li><a href="<?php echo site_url("/"); ?>">Home(<?php echo $owner_data['screen_name']?>)</a></li>
			<li><a href="<?php echo site_url("/friend/"); ?>">Friend</a></li>
				<li><a href="<?php echo site_url("/location/"); ?>">Place</a></li>
				<li><?php echo anchor('session/destroy','Logout');?></li>
		</ul><!-- end main_nav-->
		<div class='clear'></div>
	</div><!-- end global_nav	-->
</div><!-- end global_nav_wrap-->

