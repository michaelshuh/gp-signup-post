<?php
/**
 * Template Name: Signup Post Archive Page
 *
 * This is the template that displays full width page without sidebar
 *
 */

get_header(); ?>
<div id="content" class="site-content">
	<div id="primary" class="content-area col-sm-12 col-md-12">
		<main id="main" class="site-main" role="main">
		    <ul class="top-scroll-nav">
		        <?php while ( have_posts() ) : the_post(); ?>
                    <li>
                        <a href="#<?php global $post; echo $post->post_name; ?>"><?php the_title(); ?></a>
                    </li>
    		    <?php endwhile; ?>
		    </ul>
		    <?php rewind_posts(); ?>
			<div class="panel-group">
				<!-- Start the Loop -->
				<?php $count = 0; ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<!-- Display Signup Post -->
					<div id="<?php global $post; echo $post->post_name; ?>"  class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="<?php global $post; echo $post->post_name; ?>" href="#details-0-<?php echo $count; ?>">
				            		<img src="<?php echo esc_html( get_post_meta( get_the_ID(), 'gp_signup_post_image', true ) ); ?>" width="100%" height="350" class="alignnone size-full" />
				            		</a>
				          	</h4>
				        </div>
				        <div id="details-0-<?php echo $count; ?>" class="panel-collapse collapse" style="height: 0px;">
				        	<div class="panel-body">
								<div class="entry-content">
									<?php the_content(); ?>
								</div>
								<iframe src="<?php echo esc_html( get_post_meta( get_the_ID(), 'gp_signup_post_form', true ) ); ?>" height="<?php echo intval( get_post_meta( get_the_ID(), 'gp_signup_post_form_height', true ) ); ?>" width="100%" frameborder="0" marginwidth="0" marginheight="0"></iframe>
				          	</div>
				        </div>
				    </div>
					<?php $count++; ?>
		        <?php endwhile; ?>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->
<script>$(document).ready(function() { $('.top-scroll-nav').onePageNav(); });</script>
<?php get_footer(); ?>