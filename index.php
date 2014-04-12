<?php
/**
 * The main template file.
 */

get_header();?>
		<div class="blog_container">
			<div class="blog_logo" align="center">
				<?php if ( function_exists( 'ot_get_option' ) ) { ?>
					<?php if(ot_get_option( 'blog_logo')) { ?>
						<a href="<?php echo site_url()?>" ><img src="ot_get_option( 'blog_logo')" title="<?php bloginfo('name'); ?>"></a>
					<?php } else { ?>
						<a href="<?php echo site_url()?>" ><img src="<?php echo IMAGES?>/bloglogo.png" ></a>
					<?php } ?>
				<?php } ?>
			</div>
			<?php
				get_template_part( 'blog-nav');
			?>
			<?php
				if ( have_posts() ) :
					// Start the Loop.
					while ( have_posts() ) : the_post();
						get_template_part( 'content', get_post_format() );
					endwhile;
					else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );
				endif;
			?>
<?php get_footer();?>