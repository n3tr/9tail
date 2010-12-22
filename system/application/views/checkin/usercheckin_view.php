<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title></title>
		<?php echo link_tag('template_files/style.css');?>
		
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js"></script>
	
		
		<script type="text/javascript" charset="utf-8">
		
		
			$(document).ready(function() {
				
				
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(successFunction, errorFunction);

				} else {
				    alert('It seems like Geolocation, which is required for this page, is not enabled in your browser. Please use a browser which supports it.');
				}

					function successFunction(position) {
						var lat = position.coords.latitude;
						var lng = position.coords.longitude;
						var urls= '<?php echo site_url("checkin/get_nearly/"); ?>';
						urls += '/'+lat+'/'+lng;
						$.get(urls, 
						function(data) {
						 $('#ajax_loader_location').remove();
						 $('#checkin_current_results').hide()
						  $('#checkin_current_results').html(data).slideDown('slow');
						
						});	
					}
					
					function errorFunction(argument) {
						$('#ajax_loader_location').hide();
							
					}
						
					$('#search_location_submit').click(function(){
					
					
						if($('#searchtext').val() == ''){
							alert('Please, Input text into Search box.');
							return false;
						}
						
						
						
						$('#location_results').html("<img id='ajax_loader_location' src='http://localhost:8888/9tail/template_files/images/ajax-loader.gif' />");
						
						

							
							//var text = $('#search_location_text').val();
							//var url= '<?php echo site_url("checkin/searchlocation/"); ?>';
							//url  += '/' + text;
							/*
							$.get(url,{searchtext:text},function(data) {
								alert(data); break;
							 $('#checkin_search_results').hide()
							 $('#checkin_search_results').html(data).slideDown('slow');
							});
							*/

							
							var form_data = {
								searchtext: $('#search_location_text').val(),
								ajax: '1'
							};
					
							$.ajax({
								url: "<?php echo site_url("checkin/searchlocation/"); ?>",
								type: 'GET',
								data: form_data,
								success: function(data) {
									$('#checkin_search_results').hide();
									 $('#checkin_search_results').html(data).slideDown('slow');
								}
								
							});
							
							
							return false;
						
					});
					
					
				
			
		 });
		</script>
		
	
</head>
<body>
		<?php include APPPATH.'/views/nav/global_nav_view.php';?> 
		
		<div id="main_wrap">
			<div id="header_text_wrap" class="container">
				<div id="header_text">
					<h2>Check In:</h2>
				</div>
			</div>
			
				<div id="page_wrap" class="container">
					
					<div class="page_box_wrap">
						<div class="checkin_list_box center">
							<h3 class='page_box_header'>Use Geo-location API to Checkin:</h3>
							<img id='ajax_loader_location' src='http://localhost:8888/9tail/template_files/images/ajax-loader.gif' />
							<div id="checkin_current_results">

							</div>
						</div>
						
						<div class="checkin_search_box center">
							<h3 class="page_box_header">Search Location to Check-in:</h3>
							<form action="<?php echo site_url('/checkin/searchlocation');?>">
							<input type="text" id="search_location_text"/>
							<input type="submit" value="seach" id="search_location_submit" />	
							</form>
							<div id="checkin_search_results">
								
							</div>
						</div>
							<div class="clear"></div>
					</div>

				

				</div>
			
		</div>
		<div class="overlay" id="overlay" style="display:none;"></div>
			<div class="box" id="checkin_box">
				 <a class="boxclose" id="boxclose"></a>
			 <h1>Confirm Check-in to</h1>
				 <p id="confirm_place">
				 
				 </p>
				<ul id="confirm_bth">
					<li><a href="#" id="checkin_confirm">Check-in</a></li>
					<li><a href="#" id="cancel_checkin">Cancel</a></li>
				</ul>
			 
				
			</div>
	
</body>
</html>