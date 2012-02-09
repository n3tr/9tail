<?php
//	$friend_req = $this->db->get_where('friend', array('to'=>$owner_data['id'],'status'=>0))->num_rows();
?>

<div id="global_nav_wrap">
	<div id="global_nav" class="container">
		<a href="<?php echo base_url();?>" class="float_left"><?php echo img(site_url('template_files/images/mini-logo.png'));?></a>
		<ul id="main_nav">
				<li><a href="<?php echo site_url("/"); ?>">Home(<?php echo $owner_data['screen_name']?>)</a></li>
				<li><a href="<?php echo site_url("/photo/"); ?>">Photo</a></li>
				<li><a href="<?php echo site_url("/friend/"); ?>">Friend</a></li>
				<li><a href="<?php echo site_url("/location/"); ?>">Place</a></li>
				<li><?php echo anchor('session/destroy','Logout');?></li>
		</ul><!-- end main_nav-->
		<div class='clear'></div>
	</div><!-- end global_nav	-->
</div><!-- end global_nav_wrap-->

