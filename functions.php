<?php
/*****************************************************************************/
/*Define Constants*/
/*****************************************************************************/

define('THEMEROOT', get_stylesheet_directory_uri());
define('IMAGES',THEMEROOT. '/images');
function Hannas_setup() {
	/*
	 * Makes voyage available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Thirteen, use a find and
	 * replace to change 'twentythirteen' to the name of your theme in all
	 * template files.
	 */
	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
	/*
	 * This theme supports all available post formats by default.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-thumbnails' );
}

add_action( 'after_setup_theme', 'Hannas_setup' );

/**
* Enqueue Scripts and Styles for Front-End
*/
function Hannas_assets() {
		wp_enqueue_script('jquery');
		wp_enqueue_style( 'styles', get_template_directory_uri().'/style.css',false,'0.0.0.1', 'all' );
		// Load JavaScripts
		wp_enqueue_script( 'modernizr', get_template_directory_uri().'/js/modernizr.js',false, '2.6.2',true);
		wp_enqueue_script('smoothScroll',get_template_directory_uri().'/js/SmoothScroll.js',false,'0.9.9',true);
		wp_enqueue_script( 'device', get_template_directory_uri() . '/js/device.min.js', false,'0.1.57', true);
		wp_enqueue_script( 'dlmenu', get_template_directory_uri() . '/js/jquery.dlmenu.js', false,'1.0.1', true);
		wp_enqueue_script('masonry',get_template_directory_uri() . '/js/masonry.pkgd.min.js',array('jquery'),null,true);
		wp_enqueue_script('infinite',get_template_directory_uri() . '/js/jquery.infinitescroll.min.js',array('jquery'),null,true);
		wp_enqueue_script('main',get_template_directory_uri() . '/js/main.js',array('jquery'),null,true);
		// Load Google Fonts API
		wp_enqueue_style( 'google-fonts-roboto', 'http://fonts.googleapis.com/css?family=Roboto:900' ,false,null,false);
		wp_enqueue_style( 'google-fonts-lato', 'http://fonts.googleapis.com/css?family=Lato:300,400,900,400italic,900italic' ,false,null,false);
}

add_action( 'wp_enqueue_scripts', 'Hannas_assets' );

if ( ! function_exists( 'twentythirteen_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 */
function Hannas_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<div class="nav-links">

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '', 'Hannas' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( '', 'Hannas' ) ); ?></div>
		<?php endif; ?>

	</div><!-- .nav-links -->
	<?php
}
endif;

/**
 * Required: include OptionTree.
 */

/**
 * Theme Mode
 */
add_filter( 'ot_theme_mode', '__return_false' );

include_once( trailingslashit( get_template_directory() ) . 'inc/theme-options.php' );
include_once( trailingslashit( get_template_directory() ) . 'inc/resize.php' );
// Get URL of first image in a post
function catch_first_post_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  if(isset($matches[1][0])){
  	$first_img = $matches [1][0];
  	$width = 150;                                                                  // Optional. Defaults to '150'
	$height = 150;                                                                 // Optional. Defaults to '150'
	$crop = true;                                                                  // Optional. Defaults to 'true'
	$retina = false;                                                               // Optional. Defaults to 'false'

	// Call the resizing function (returns an array)
	$image = matthewruddy_image_resize( $first_img, $width, $height, $crop, $retina );
	//print_r($image);
	if ( is_wp_error( $image ) ) {
	    echo $image->get_error_message();        // Displays error message returned from resizing function
	} else {
	   return $image['url'];          // Everything appears to have gone well. Continue as normal!
	}
  }
}
function list_blog(){
	$list=wp_get_sites();
	$blog_id_and_name=array();
	$i=0;
	foreach ($list as $key) {
		$blog_id_and_name[$i]['id']=$key['blog_id'];
		$blog_id_and_name[$i]['name']=get_blog_name_from_id($key['blog_id']);
		$i++;
	}
	return $blog_id_and_name;
}
function get_blog_name_from_id($id){
	return get_blog_details($id,true)->blogname;
}

function theme_option_list_blog(){
	$arg = array();
	$i=0;
	foreach (list_blog() as $key) {
		$arg[$i]= array(
            'value'       => $key['id'],
            'label'       => __( $key['name'], 'Hannas' ),
            'src'         => ''
        );
		$i++;
	}
	return $arg;
}
function list_category(){
	global $wpdb;
	$query = "SELECT * FROM ( ";
	for ($i=1; $i <= get_blog_count(); $i++) { 
	 	if($i==1){
	 		$query.="SELECT name  FROM {$wpdb->prefix}terms UNION DISTINCT ";
	 	}else if($i>1 && $i<get_blog_count() ){
	 		$query.="SELECT name FROM {$wpdb->prefix}{$i}_terms UNION DISTINCT ";
	 	}else{
	 		$query.="SELECT name FROM {$wpdb->prefix}{$i}_terms";
	 	}
	}
	$query.=" ) new ORDER BY name ASC";
	$result = $wpdb->get_results($query); 
	$arg = array();
	$i=0;
	foreach ($result as $key) {
		$arg[$i]= array(
            'value'       => $key->name,
            'label'       => __( $key->name, 'Hannas' ),
            'src'         => ''
        );
		$i++;
	}
	return $arg;
}
function list_post($name){
	global $wpdb;
	$original_blog_id = get_current_blog_id();
	$query = "SELECT * FROM ( ";
	for ($i=1; $i <= get_blog_count(); $i++) { 
	 	if($i==1){
	 		$query.="SELECT a.ID AS ID , '{$i}' AS blog_id , post_date FROM {$wpdb->prefix}posts a , {$wpdb->prefix}term_relationships b , {$wpdb->prefix}terms c WHERE ( a.ID = b.object_id AND b.term_taxonomy_id = c.term_id AND c.name='{$name}') UNION ALL ";
	 	}else if($i>1 && $i<get_blog_count() ){
	 		$query.="SELECT a.ID AS ID , '{$i}' AS blog_id , post_date FROM {$wpdb->prefix}{$i}_posts a , {$wpdb->prefix}{$i}_term_relationships b , {$wpdb->prefix}{$i}_terms c WHERE ( a.ID = b.object_id AND b.term_taxonomy_id = c.term_id AND c.name='{$name}') UNION ALL ";
	 	}else{
	 		$query.="SELECT a.ID AS ID , '{$i}' AS blog_id , post_date FROM {$wpdb->prefix}{$i}_posts a , {$wpdb->prefix}{$i}_term_relationships b , {$wpdb->prefix}{$i}_terms c WHERE ( a.ID = b.object_id AND b.term_taxonomy_id = c.term_id AND c.name='{$name}')";
	 	}
	}
	$query.=" ) new ORDER BY post_date DESC LIMIT 8";
	$result = $wpdb->get_results($query); 
	?>
	<div class="pick">
	<?php 
	foreach ($result as $key) {
		switch_to_blog($key->blog_id);
		$post = get_post($key->ID);
		$attachments = get_children(array('post_parent'=>$post->ID));
		$nbImg = count($attachments);
		?>
		<div class="thumbnail-image-pick">
			<a href="<?php echo get_permalink( $post->ID ) ?>" title="<?php echo $post->post_title;?>">
				<?php 
					if ( has_post_thumbnail($post->ID)) {
						echo get_the_post_thumbnail($post->ID, 'full'); 
					}else{
						echo '<img src=\''.IMAGES.'/pick1.jpg'.'\'>';
					}	
				?>
				<div class="hover-area">
					<div class="count"><?php echo $nbImg ?></div>
					<div class="text-area">
						<div class="title"><?php echo $post->post_title;?></div>
						<div class="author">BY: <?php echo get_userdata($post->post_author)->display_name;?></div>
					</div>
				</div>
			</a>
		</div>
		<?php
		switch_to_blog( $original_blog_id );
	}
	?>
	</div>
	<?php 
}

function latest_post(){
	global $wpdb;
	$original_blog_id = get_current_blog_id();
	$query = "SELECT * FROM ( ";
	for ($i=1; $i <= get_blog_count(); $i++) { 
	 	if($i==1){
	 		$query.="SELECT ID , '{$i}' AS blog_id , post_date FROM {$wpdb->prefix}posts WHERE post_status = 'publish' AND post_type = 'post' UNION ALL ";
	 	}else if($i>1 && $i<get_blog_count() ){
	 		$query.="SELECT ID , '{$i}' AS blog_id , post_date FROM {$wpdb->prefix}{$i}_posts WHERE post_status = 'publish' AND post_type = 'post' UNION ALL  ";
	 	}else{
	 		$query.="SELECT ID , '{$i}' AS blog_id , post_date FROM {$wpdb->prefix}{$i}_posts WHERE post_status = 'publish' AND post_type = 'post' ";
	 	}
	}
	$query.=" ) new ORDER BY post_date DESC LIMIT 8";
	$result = $wpdb->get_results($query); 
	?>
	<div class="pick">
	<?php 
	foreach ($result as $key) {
		switch_to_blog($key->blog_id);
		$post = get_post($key->ID);
		$attachments = get_children(array('post_parent'=>$post->ID));
		$nbImg = count($attachments);
		?>
		<div class="thumbnail-image-pick">
			<a href="<?php echo get_permalink( $post->ID ) ?>" title="<?php echo $post->post_title;?>">
				<?php 
					if ( has_post_thumbnail($post->ID)) {
						echo get_the_post_thumbnail($post->ID, 'full'); 
					}else{
						echo '<img src=\''.IMAGES.'/pick1.jpg'.'\'>';
					}	
				?>
				<div class="hover-area">
					<div class="count"><?php echo $nbImg ?></div>
					<div class="text-area">
						<div class="title"><?php echo $post->post_title;?></div>
						<div class="author">BY: <?php echo get_userdata($post->post_author)->display_name;?></div>
					</div>
				</div>
			</a>
		</div>
		<?php
		switch_to_blog( $original_blog_id );
	}
	?>
	</div>
	<?php 
}

function featured_post($post_id,$blog_id){
	$original_blog_id = get_current_blog_id();
	if($blog_id){
		switch_to_blog($blog_id); //switched to blog with blog_id $bid
	}
	if($post_id){
    	$post = get_post($post_id);
	}
	$attachments = get_children(array('post_parent'=>$post->ID));
	$nbImg = count($attachments);
	?>
	<div class="featured">
		<a href="<?php echo get_permalink( $post->ID ) ?>" title="<?php echo $post->post_title;?>">
			<?php 
				if ( has_post_thumbnail($post->ID)) {
					echo get_the_post_thumbnail($post->ID, 'full'); 
				}else{
					echo '<img src=\''.IMAGES.'/byus.jpg'.'\'>';
				}	
			?>
			<div class="hover-area">
				<div class="count"><?php echo $nbImg ?></div>
				<div class="text-area">
					<div class="title"><?php echo $post->post_title;?></div>
					<div class="author">BY: <?php echo get_userdata($post->post_author)->display_name;?></div>
				</div>
			</div>
		</a>
	</div>
	<?php
	switch_to_blog( $original_blog_id ); //switched back to current blog
} 

function selected_site($blog_id){
	$original_blog_id = get_current_blog_id();
	if($blog_id){
		switch_to_blog($blog_id); //switched to blog with blog_id $bid
	}
    $args = array(
		'posts_per_page'   => 5,
		'offset'           => 0,
		'category'         => '',
		'orderby'          => 'post_date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'post',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true );
    $posts = get_posts($arg);
    ?>
	<div class="latest">
		<?php 
			$i=1; 
			$lenght=count($posts);
			foreach($posts as $post){
		    setup_postdata( $post );
		    $attachments = get_children(array('post_parent'=>$post->ID));
			$nbImg = count($attachments);
		?>
			<?php if($i==1 || $i==2) { ?><div class="col"><?php } ?>
			<?php if($i==1) { ?><div class="thumbnail-image-large"> <?php } if($i>1) { ?><div class="thumbnail-image-small"><?php } ?>
					<a href="<?php echo get_permalink( $post->ID ) ?>" title="<?php the_title();?>">
						<?php 
							if ( has_post_thumbnail($post->ID)) {
								echo get_the_post_thumbnail($post->ID, 'full'); 
							}else{
								echo '<img src=\''.IMAGES.'/blog1.jpg'.'\'>';
							}	
						?>
						<div class="hover-area">
							<div class="count"><?php echo $nbImg ?></div>
							<div class="text-area">
								<div class="title"><?php echo $post->post_title;?></div>
								<div class="author">BY: <?php echo get_userdata($post->post_author)->display_name;?></div>
							</div>
						</div>
					</a>
				</div>
			<?php if($i==1 || $i==$lenght) { ?> </div><?php } ?>
		<?php 
			$i++;}
		?>
	</div>
	<?php
		switch_to_blog( $original_blog_id ); //switched back to current blog
}