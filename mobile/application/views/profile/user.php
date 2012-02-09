<!DOCTYPE html> 
<html> 
	<head> 
	<title><?php echo $profile_data['screen_name'];?>'s Profile</title> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.css" />
	
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.5.min.js"></script>
	
	<script type="text/javascript">
		    $(document).bind("mobileinit", function () {
		           $.mobile.ajaxLinksEnabled = false;
					$.mobile.ajaxEnabled = false;
		     });
	</script>
		
	<script type="text/javascript" src="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.js"></script>
	<script type="text/javascript">

$(document).ready(function(){
	var user_id = <?php echo $profile_data['id'];?>;
	//var getStatusUrl = 'http://mobile.9tail.com/profile/getstatus/'+user_id;
	var url  = "<?php echo site_url('profile/getstatus');?>";
	var para = {
		userid : user_id
	}
	/*	
	$.post(url,para,function(data){

			var path = "<?php echo 'http://www.9tail.com/files/user_photo/thumb/';?>";
			$.each(data, function(i,item){

			 var img =  $("<img/>").attr("src", path +item.small_thumbnail).addClass('ui-li-thumb');
			var h4 = $("<h3/>").text(item.screen_name);
			var link = $("<a/>").attr('href','<?php echo site_url("profile/user/");?>/' + item.from);
			var para = $("<p/>").text(item.text);

			$("<li/>").addClass('ui-li-has-thumb')
			.append(img)
			.append(h4)
			.append(link)
			.append(para)
			.appendTo('#messageview');

		     });

		   $('ul').listview('refresh');


	},"json");*/

	$("#submit_msg").click(function(){

		var text =  $("#post_text").val();
		var to_user = <?php echo $profile_data['id']; ?>;
		var from_user = <?php echo $user_data['id'];?>;

		if(text.trim() == "") return false;


		var url = "<?php echo site_url('profile/postmessage');?>";
		var para = {
			post_text : text,
			from: from_user,
			to: to_user
		};

		$('#post_text').attr('disabled','disabled');
		$("#submit_msg").attr('disabled','disabled');
		$.post(url,para,function(item){
			var path = "<?php echo 'http://www.9tail.com/files/user_photo/thumb/';?>";


			 var img =  $("<img/>").attr("src", path +item.small_thumbnail).addClass('ui-li-thumb');
			var h4 = $("<h3/>").text(item.screen_name);
			var link = $("<a/>").attr('href','#');
			var para = $("<p/>").text(item.text);

			$("<li/>").addClass('ui-li-has-thumb')
			.append(img)
			.append(h4)
			.append(link)
			.append(para)
			.prependTo('#messageview');

		$('#post_text').removeAttr('disabled');
		$("#submit_msg").removeAttr('disabled');
		$('#post_text').val('');



		   $('ul').listview('refresh');

		},'json');
		return false;
	});

});

</script>
	<style>
		label,input{
			display:block;
		}
	</style>
	

	
	<style>
		#top_wrap{
			
			display:block;
			height:90px;
			
			
			border-bottom:1px solid #ccc;
		}
	
	#top_wrap p{
		margin:0;
		padding:0;
		font-size:12px;
	}
	#top_wrap h3{
		margin:10px 0 10px ;
		padding:0;
	}
	
		#top_wrap img{
			max-height:80px;
			float:left;
			margin-right:20px;
		}
		
		#top_wrap #user_profile{
	
			overflow:hidden;
		}
		
		#message_box_wrap{
			margin:5px 0;
			padding:5px 0;
		}
	</style>
</head> 
<body> 
	<div data-role="page"> 
		
		<div data-role="header">	
			<h1>Profile: <?php echo $profile_data['screen_name']?></h1>
			<a href="/" data-icon="gear" class="ui-btn-right">Home</a>
			<div data-role="navbar">
					<ul>
						<li><?php echo anchor('profile/user/'.$profile_data['id'],'Profile: ' .$profile_data['screen_name'],'class="ui-btn-active"'); ?></li>
						<li><?php echo anchor('profile/photo/'.$profile_data['id'],'My Photo');?></li>
						
					</ul>
				</div><!-- /navbar -->
			</div> 

		<div data-role="content">
			<div id="top_wrap">
				
				<?php 
				$path = 'http://www.9tail.com/files/user_photo/thumb/';
				echo img($path.$profile_data['small_thumbnail']);
				?>
				
				<div id="user_profile">
					<h3><?php echo $profile_data['screen_name']?></h3>
					<p><?php echo $profile_data['firstname'] . ' ' . $profile_data['lastname']; ?></p>
					
				</div>
			</div>
			
		
			<div data-role="fieldcontain" id="message_box_wrap">
				<label for="textarea">Message:</label>
				<textarea cols="40" rows="8" name="post_text" id="post_text"></textarea>
				<button type="submit" data-theme="b" id="submit_msg">Submit</button>
					
			</div>
		
			<h3>Steam</h3>
			<ul data-role="listview" id="messageview" data-inset="true">
				<?php
				
					$path = 'http://www.9tail.com/files/user_photo/thumb/';
					foreach ($messages as $msg) {
				?>
				<li class="ui-li-has-thumb">
					<img src="<?php echo $path . $msg['small_thumbnail'];?>"/>
					<h4><?php echo $msg['screen_name']?></h4>
					<php echo site_url('profile/user/'); ?>
				
					<?php echo anchor('profile/user/'.$msg['from'].'',' ');?>
					<p><?php echo $msg['text'];?></p>
				</li>
				<?php } ?>
					
			
			</ul>
			
			<a href="<?php echo site_url('login/logout');?>" data-role="button" data-theme="a">Sign out</a>
		</div> 
		<div data-role="footer">
		<h4>9tail</h4>
		</div>
	</div>

	


</body>
</html>