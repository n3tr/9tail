	<script type="text/javascript" charset="utf-8">
			$(".checkin_result").click(function(el){
				
				var divel = $('.checkin_result_name a',this).text();
				$('#confirm_place').text(divel)
				
				var link = this.id;
				link = link.substring(11);
				
				link = '<?php echo site_url('checkin/place/');?>' + '/' +link;
				$('#checkin_confirm').attr('href',link);
			 	$('#overlay').fadeIn('medium');
				$('#checkin_box').show('slow');
				
				return false;

			});
			
			$('#cancel_checkin').click(function(){
				
				$('#checkin_box').fadeOut('medium');
				$('#overlay').fadeOut('medium');
				return false;
			});
			
			$('#overlay').click(function(){
					$('#checkin_box').fadeOut('medium');
					$('#overlay').fadeOut('medium');
					return false;
			});
	</script>
	<?php
		if(count($results) > 0) :
		foreach ($results as $row) :?>
		
		<div class="checkin_result" id="s_place_id-<?php echo $row['id']; ?>">
			<div class="checkin_mini_map">
			<?php 
			$image = '<img src="http://maps.google.com/maps/api/staticmap?center=' . 
			$row['lat'] .
			 ',' . 
			$row['lng'] .
			'&zoom=15&size=175x115&maptype=terrain&sensor=false" />';
			echo anchor('checkin/place/'. $row['id'],$image);
			
			?>
			</div>
			<div class="checkin_result_text">
				<h4 class="checkin_result_name"><?php echo anchor('checkin/place/'. $row['id'],$row['name']); ?></h4>
				<div class="checkin_result_desc">
					<p><?php echo $row['description']?></p>
				</div>
				<div class="checkin_result_count">
					<p>check-in : <?php echo $row['checkin_count'];?></p>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		
	<?php endforeach;?>
			<?php else : ?>
				<div id="name">
				<p>Serach another words.</p>
				<p><a href="#">Or You can create new place.</a></p>
				</div>
		<?php endif; ?>
	
			