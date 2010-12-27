
<div class="message new_message">
	<div class="message_content">

		<div class="user_avatar">
			<?php echo anchor('user/'.$tip_user['screen_name'], "<img src=".site_url("files/user_photo/thumb/".$tip_user['thumbnail'])." />");?>										
		</div>

		<div class="message_text">
			<?php echo anchor('user/'.$tip_user['screen_name'], $tip_user['screen_name'],array('class'=>'user_link'));?>
			<?php echo '<p>' . $tip_data['text'] .'</p>' .' <i>'. $tip_data['datetime'] . '</i>';?>								
		</div>

		<div class="clear"></div>
	</div><!-- message_content -->
</div><!-- message -->