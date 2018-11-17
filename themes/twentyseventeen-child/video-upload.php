<?php
/**
 * Template Name: Video Upload
 *
 */
 wp_head();
 if(is_user_logged_in()){
 ?>
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <script>
  $( function() {
    $( "#sortable" ).sortable({
		stop: function( event, ui ) {
			$('.ui-sortable-handle').each(function(){
				var vid_id = $(this).attr('vid_id');
				$("[viewport_vid_id='" + vid_id + "']").css("z-index", -$(this).index());
			});
		}
	});
    $( "#sortable" ).disableSelection();
  } );
  
  jQuery(document).ready(function(){
	  $('.ui-sortable-handle').each(function(){
		var vid_id = $(this).attr('vid_id');
		$("[viewport_vid_id='" + vid_id + "']").css("z-index", -$(this).index());
	});
	
		var zindex = 0;
		$("#play_button").on("click", function() {
			$('.preview-viewport video').each(function(){
				if($(this).css('z-index') == zindex){
					$('.preview-viewport video').each(function(){
						$(this).get(0).style.display = "none";
					});
					$(this).get(0).style.display = "block";
					$(this).get(0).play();
				}
			});
			zindex--;
			return zindex;
		});
		$('.preview-viewport video').each(function(){
			$(this).get(0).onended = function(){
				var next = $(this).css('z-index') - 1;
				$(this).get(0).style.display = "none";
				$(this).get(0).currentTime = 0;
				$('.preview-viewport video').each(function(){
					if($(this).css('z-index') == next){
						$(this).get(0).style.display = "block";
						$(this).get(0).play();
					}
				});
				if($(this).css('z-index') == -($('.preview-viewport video').length - 1)){
					$('.preview-viewport video').each(function(){
						$(this).get(0).style.display = "block";
						zindex=0;
						return zindex;
					});
				}
			};
		});

 });
  </script>
 <body class="video-manager">
 
 <div class="centered heading" >
	<h1>Create Your Video</h1>
 </div>
 <div class="centered">
 <div class="manager-lhs">
   <div class="video-upload-section">
	</div>
		<div class="video-list" >
			<?php
			
				$id = get_current_user_id();
				$accepted_mimes = array ('video/x-flv', 'video/mp4', 'application/x-mpegURL', 'video/MP2T', 'video/3gpp', 'video/quicktime', 'video/x-msvideo', 'video/x-ms-wmv', );
				$args = array(
					'author' => $id,
					'post_type' => 'attachment',
					'post_status'    => 'inherit',
					'posts_per_page' => -1,
					'post_mime_type'    => $accepted_mimes
				);
				$query = new WP_Query( $args );
				/*?><pre><?php print_r($query); ?><pre><?php */
				// The Loop
				if ( $query->have_posts() ) {
					?>
					<h3 class="instrunction" > Drag and drop the videos to set the order. </h3>
					<ul id="sortable" class="video-list" >
			<?php
					while ( $query->have_posts() ) {
						$query->the_post();
						?>
						<li class="video-viewport" vid_id="<?php echo get_the_ID();?>">
							<video width="100" height="70">
								<source src="<?php echo $query->post->guid; ?>" type="video/mp4">
								<source src="<?php echo $query->post->guid; ?>" type="video/ogg">
								Your browser does not support the video tag.
							</video>
							<form class="remove_video" method="post" action="#">
								<div class="remove-video" >Remove Video</div>
								<input type="hidden" name="remove_id" id="post_id" value="<?php echo get_the_ID();?>" />
								<?php wp_nonce_field( 'remove_video', 'remove_video_nonce' ); ?>
							</form>
						</li>
						<?php 
					}
					/* Restore original Post Data */
					?>
					</ul>
					<div class="video-upload-wrapper">
						<h3 id="upload_the_video"><i class="fas fa-upload"></i> Upload video or image. </h3>
						<form id="featured_upload" method="post" action="#" enctype="multipart/form-data">
						<input type="file" name="my_image_upload" id="my_image_upload"  multiple="false" />
						<?php wp_nonce_field( 'my_image_upload', 'my_image_upload_nonce' ); ?>
						<input id="submit_my_image_upload" name="submit_my_image_upload" type="submit" value="Upload" />
					</form>
					</div>
					</div>
					</div>
					<?php
					wp_reset_postdata();
				} else {
					// no posts found
				}
				?>
				
		<div class="preview-video">
			
			<?php
				$id = get_current_user_id();
				$accepted_mimes = array ('video/x-flv', 'video/mp4', 'application/x-mpegURL', 'video/MP2T', 'video/3gpp', 'video/quicktime', 'video/x-msvideo', 'video/x-ms-wmv', );
				$args = array(
					'author' => $id,
					'post_type' => 'attachment',
					'post_status'    => 'inherit',
					'posts_per_page' => -1,
					'post_mime_type'    => $accepted_mimes
				);
				$query = new WP_Query( $args );
				// The Loop           
				if ( $query->have_posts() ) {
					?>
					<div id="preview_viewport" class="preview-viewport" >
					<?php
					while ( $query->have_posts() ) {
						$query->the_post();
						?>
							<video viewport_vid_id="<?php echo get_the_ID();?>">
								<source src="<?php echo $query->post->guid; ?>" type="video/mp4">
								<source src="<?php echo $query->post->guid; ?>" type="video/ogg">
								Your browser does not support the video tag.
							</video>
						<?php 
					}
					/* Restore original Post Data */
					wp_reset_postdata();
					?>
				</div>
				<button id="play_button">Play</button>
				<?php
				} else {
					// no posts found
				}
			}else{
				echo 'Computer says no... "Please log in"';
			}
			?>
			
		</div>
	</div>
</div>
<script>
	jQuery('.remove-video').on('click', function(){
		jQuery(this).parent().submit();
	});
	
	jQuery('#upload_the_video').on('click', function(){
		if($('#my_image_upload').val() == ''){
			$('#my_image_upload').click();
		}
	});
	$('#my_image_upload').on('change' , function(){
		console.log($('#my_image_upload'));
		$('#featured_upload').submit();
	});
</script>
</body>