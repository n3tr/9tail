<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title><?php echo $owner_data['screen_name']?>'s Profile : Home</title>
		
		<?php echo link_tag('template_files/style.css');?>
		
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				
				
				
				$('#sw_tips').click(function(){
					$(this).addClass('current');
					$('#sw_status').removeClass('current');
					$('#message_wrap').hide();
					$('#tips_post_wrap').show();
						return false;
				});
				
				$('#sw_status').click(function(){
					$(this).addClass('current');
					$('#sw_tips').removeClass('current');
					$('#tips_post_wrap').hide();
					$('#message_wrap').show();
					return false;
				});
			
			
					$('#post_tip_submit').click(function(){
						if($('#tip_text').val() == ''){
							
							alert("Tip Box Cant't be Empty !!'")
							
						}else{
							$('#tip_text').attr('disabled','disabled');
							$('#post_tip_submit').attr('disabled','disabled');
							var tpi = $('input[name$="tip_place_id"]').val();
							var tui = $('input[name$="tip_user_id"]').val();
							var tiptext = $('#tip_text').val();
							
							var tip_data = {
								tip_text:tiptext,
								tip_place_id:tpi,
								tip_user_id:tui,
								ajax:'1'
							}
							
							url = '<?php echo site_url('tip/addtip')?>';
							
							$.post(url,tip_data,function(data){
								$(data).prependTo('#tips');
								document.getElementById('tip_text').value = '';
								
								$('#tip_text').removeAttr('disabled');
								$('#post_tip_submit').removeAttr('disabled');
							});
							
			
						}
							return false;
					
						
					
					});
					
						$('#post_msg_submit').click(function(){
							if($('#msg_text').val() == ''){

								alert("Message Box Cant't be Empty !!'")
								return false;
							}
						});
						
						$('.user_report').click(function(){
						
								
									$('#overlay').fadeIn('medium');
										$('#user_report_box').fadeIn('medium');
								return false;
							
						});
						
						$('#overlay').click(function(){
							$('#user_report_box').fadeOut('medium');
							$('#overlay').fadeOut('medium');
							return false;
						});
			
			});
		</script>
				<style>
				label{
					display:block;
				}
				textarea{
					display:block;
				}
				</style>
	</head>
	<body id="profile">
		
			<?php include APPPATH.'/views/nav/global_nav_view.php';?> 
		
		<div id="main_wrap">
			<div id="usernav_wrap" class="container">
				<ul id="user_nav">
					<li><?php echo anchor('/user/'.$owner_data['screen_name'],'Profile');?></li>
					<li><?php echo anchor('/photo/user/'.$owner_data['screen_name'],'Photo');?></li>
					<li><?php echo anchor('/friend/user/'.$owner_data['screen_name'],'Friend');?></li>
				</ul>
				<div class="clear"></div>
			</div>
			
			
			
			<div id="userinfo_wrap" class="container">

			<div id="userinfo">
				<h2 class="user_screen_name"><?php echo $owner_data['screen_name']; ?></h2>
				<span class="user_full_name"><?php echo $owner_data['firstname'] . ' ' . $owner_data['lastname'];?></span>
			
			</div>
		
			<div id="useravatar_box">
			<div id="useravatar">
			<img src='<?php echo site_url("files/user_photo/thumb/".$owner_data["thumbnail"]);?>' />
			</div>
			</div><!-- end userinfo_wrap-->
		
		</div>
		
		<div id="content" class="container">
			<div id="page">
				<div id="page_inner">
					
					
					<div id="msg_tip_nav">
					<ul id="msg_tip_bar">
						<li ><a href="#" class="current" id="sw_status">Status</a></li>
						<li><a href="#" id="sw_tips">Tips</a></li>
					</ul>
					</div>
				
					<div id="message_wrap">
					
						<div id="message_post_box">
							<?php
							$hidden = array(
								'from' => $owner_data['id'],
								'to' => $owner_data['id']
								);
							$fval = array(
								'value'=>'Post',
								'type'=>'submit',
								'name'=>'post_message_submit',
								'class'=>'submit_message_bth',
								'id'=>'post_msg_submit'
								);
							echo form_open('/message/post','', $hidden);
						echo '<textarea name="text" id="msg_text"></textarea>';
							echo form_submit($fval);
							echo form_close();
							?>
							<div class="clear"></div>
						</div><!-- message_post_box -->
						
						
		
						<div id="messages">
							
						<?php if (count($messages) > 0) : ?>
				
							<?php foreach ($messages as $row) : ?>
				
								<div class="message">
									<div class="message_content">
										
										<div class="user_avatar">
											<?php echo anchor('user/'.$row['screen_name'], "<img src=".site_url("files/user_photo/thumb/".$row['small_thumbnail'])." />");?>										
										</div>
										
										<div class="message_text">
											<?php echo anchor('user/'.$row['screen_name'], $row['screen_name'],array('class'=>'user_link'));?>
											<?php echo '<p>' . $row['text'] .'</p>' .' <i>'. $row['datetime'] . '</i>';?>								
										</div>
										
										<div class="clear"></div>
									</div><!-- message_content -->
								</div><!-- message -->
								<?php endforeach; ?>

							<?php endif; ?>
							
						</div><!-- messages -->
						
					</div><!-- message_wrap -->
						
					<?php if(!$last_checkin ==0): ?>
						
						<div id="tips_post_wrap">
							
						
							<div id="message_post_box">
								<?php
								$hidden = array(
									'tip_place_id' => $last_checkin['place_id'],
									'tip_user_id' => $owner_data['id']
									);
								$fval = array(
									'value'=>'Add Tip',
									'type'=>'submit',
									'name'=>'post_tip_submit',
									'class'=>'submit_message_bth',
									'id'=>'post_tip_submit'
									);
								echo form_open('/tip/addtip','', $hidden);
						
							echo '<textarea name="tip_text" id="tip_text"></textarea>';
								echo form_submit($fval);
								echo form_close();
								?>
								<div class="clear"></div>
							</div><!-- message_post_box -->
							
							
							<div id="tips">

								<?php if (count($tips) > 0) : ?>

									<?php foreach ($tips as $row) : ?>

										<div class="message">
											<div class="message_content">

												<div class="user_avatar">
													<?php echo anchor('user/'.$row['screen_name'], "<img src=".site_url("files/user_photo/thumb/".$row['small_thumbnail'])." />");?>										
												</div>

												<div class="message_text">
													<?php echo anchor('user/'.$row['screen_name'], $row['screen_name'],array('class'=>'user_link'));?>
													<?php echo '<p>' . $row['text'] .'</p>' .' <i>'. $row['datetime'] . '</i>';?>								
												</div>

												<div class="clear"></div>
											</div><!-- message_content -->
										</div><!-- message -->
										<?php endforeach; ?>
									<?php else: ?>
									<p>No have any tips</p>
									
		
									<?php endif; ?>

								</div><!-- messages -->
							
						</div>
					<?php else: ?>
						<div id="tips_post_wrap">
					<p>You not Check-in yet.</p>
					<?php echo anchor('/checkin/','Click to start Check-in.',array('class'=>'blue_link')); ?>
						</div>
						<?php endif;?>
						</div><!-- page inner -->
					</div><!-- page  -->
					
			
					
					<div id="sidebar">
						<div class="widget_box location_widget">
							<ul>
								<li><?php echo anchor('/checkin/','Check-in'); ?></li>
								<li><a href="#">Add Photo</a></li>

							</ul>
						</div>

						<div class="widget_box">
							<h3 class="widget_title">You are here: <?php echo $last_checkin['name'] ?></h3>
							<?php 
							
							if(!$last_checkin ==0){
								$image = '<img src="http://maps.google.com/maps/api/staticmap?center=' . 
								$last_checkin['lat'] .
								 ',' . 
								$last_checkin['lng'] .
								'&zoom=15&size=340x160&
								markers=color:blue|label:P|'.
								$last_checkin['lat'] .
								 ',' . 
								$last_checkin['lng'] .
								'&maptype=terrain&sensor=false" />';
								echo anchor('location/place/'. $last_checkin['place_id'],$image);
							}else{
								echo '<p>You not check-in yet.</p>';
								echo anchor('checkin', 'Click here to start Check-in',array('class'=>'blue_link'));
							}
						

							?>
						</div>
						
						<div class="widget_box">
							<h3 class="widget_title">Who are here:</h3>
							<?php if(!$user_in_location ==0): ?>
							<?php foreach ($user_in_location as $user) :?>
							<a href="<?php echo site_url('/user/'.$user['screen_name'])?>">
							<img src="<?php echo site_url('files/user_photo/thumb/'.$user['thumbnail']); ?>" width='100' height='100' />
							</a>
						<?php endforeach;?>
					<?php endif;?>
						</div>
					
					<!--
						<div class="widget_box">
							<h3 class="widget_title">Widget Title</h3>
							<img src="./images/map_preview.png"/>
						</div>
						-->
					</div>
					<div class="clear"></div>
					</div>
			</div> <!--end main wrap -->
			
			<div id="footer_wrap">
				<div class="container" id="footer" >
					<a href="#" class="user_report">Report to Administrator</a>
					
					
				</div>
			</div>
			
			<div class="overlay" id="overlay" style="display:none;"></div>
			
			<div class="box" id="user_report_box">
			
			
		
			 <h1>Report to Administrator</h1>
				<div id="user_report_textbox">
					<?php
					/*
					$hidden = array(
						'tip_place_id' => $place_data['id'],
						'tip_user_id' => $user_data['id'] 
						);*/
					$pval = array(
						'value'=>'Submit',
						'type'=>'submit',
						'name'=>'upload_photo_submit',
						'class'=>'submit_message_bth',
						'id'=>'upload_photo_submit'
						);
					
					echo form_open_multipart('location/photo_upload');
					echo form_label('Title');
					echo form_input('title');
					echo form_label('Text');
					?>
					<textarea name="text" rows="8" cols="30"></textarea>
					<?php
					echo form_hidden('url');
					echo form_submit($pval);
					echo form_close();
					?>
					<div class="clear"></div>
				</div><!-- message_post_box -->



			</div>
			
		 
	
	</body>
	
</html>