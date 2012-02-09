<div class="message new_message">
	<div class="message_content">

		<div class="user_avatar">
			<?php echo anchor('user/'.$user['screen_name'], "<img src=".site_url("files/user_photo/thumb/".$user['thumbnail'])." />");?>										
		</div>

		<div class="message_text">
			<?php echo anchor('user/'.$user['screen_name'], $user['screen_name'],array('class'=>'user_link'));?>
			<?php echo '<p>' . $tip['text'] .'</p>' .' <i>'. $tip['datetime'] . '</i>';?>								
		</div>

		<div class="clear"></div>
	</div><!-- message_content -->
</div><!-- message -->