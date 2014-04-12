<?php
/**
 * Initialize the custom theme options.
 */
add_action( 'admin_init', 'custom_theme_options' );

$list_blog = array();
$list_blog = theme_option_list_blog();
/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( 'option_tree_settings', array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array( 
      
    ),
    'sections'        => array( 
      array(
        'id'          => 'theme_settings',
        'title'       => __( 'Theme Settings', 'Hannas' )
      )
    ),
    'settings'        => array( 
         array(
        'id'          => 'first_on_off',
        'label'       => __( 'On/Off', 'Hannas' ),
        'desc'        => sprintf( __("<img src='http://helixsoft.in/hannas/wp-content/themes/Hannas/images/hannas1.jpg'>") ),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'theme_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
         array(
        'id'          => 'first_select',
        'label'       => __( 'Select Latest Post Site', 'Hannas' ),
        'desc'        => __( 'You can select blog post any site', 'Hannas' ),
        'std'         => '',
        'type'        => 'select',
        'section'     => 'theme_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => theme_option_list_blog(),
      ),
         array(
        'id'          => 'featured_on_off',
        'label'       => __( 'On/Off', 'Hannas' ),
        'desc'        => sprintf( __("<img src='http://helixsoft.in/hannas/wp-content/themes/Hannas/images/hannas2.jpg'>") ),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'theme_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
         array(
        'id'          => 'featured_select',
        'label'       => __( 'Select Site', 'Hannas' ),
        'desc'        => __( 'Select Site From where you gona take post ID', 'Hannas' ),
        'std'         => '',
        'type'        => 'select',
        'section'     => 'theme_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => theme_option_list_blog(),
      ),
        array(
        'id'          => 'featured_post_id',
        'label'       => __( 'Post ID', 'Hannas' ),
        'desc'        => __( 'The Post ID from selected site.', 'Hannas' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'theme_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
        array(
        'id'          => 'pick_on_off',
        'label'       => __( 'On/Off', 'Hannas' ),
        'desc'        => sprintf( __("<img src='http://helixsoft.in/hannas/wp-content/themes/Hannas/images/hannas2.jpg'>") ),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'theme_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
        array(
        'id'          => 'pick_type',
        'label'       => __( 'Latest or Category', 'Hannas' ),
        'desc'        => __( 'Latest posts form entire network or you can setect category form entire network', 'Hannas' ),
        'std'         => '',
        'type'        => 'radio',
        'section'     => 'theme_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'yes',
            'label'       => __( 'Latest', 'Hannas' ),
            'src'         => ''
          ),
          array(
            'value'       => 'no',
            'label'       => __( 'Category', 'Hannas' ),
            'src'         => ''
          ),
        )
      ),
        array(
        'id'          => 'pick_category_select',
        'label'       => __( 'Select Category', 'Hannas' ),
        'desc'        => __( 'Select Category From all sites', 'Hannas' ),
        'std'         => '',
        'type'        => 'select',
        'section'     => 'theme_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => list_category(),
      ),
        array(
        'id'          => 'video_on_off',
        'label'       => __( 'On/Off', 'Hannas' ),
        'desc'        => sprintf( __("<img src='http://helixsoft.in/hannas/wp-content/themes/Hannas/images/hannas5.jpg'>") ),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'theme_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
        array(
        'id'          => 'video',
        'label'       => __( 'Video', 'Hannas' ),
        'desc'        => __( 'Put video embed code here', 'Hannas' ),
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'theme_settings',
        'rows'        => '5',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
        array(
        'id'          => 'contributors_on_off',
        'label'       => __( 'On/Off', 'Hannas' ),
        'desc'        => sprintf( __("<img src='http://helixsoft.in/hannas/wp-content/themes/Hannas/images/hannas4.jpg'>") ),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'theme_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
    )
  );
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( 'option_tree_settings_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings ); 
  }
  
}