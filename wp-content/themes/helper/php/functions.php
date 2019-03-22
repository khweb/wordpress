<?php
/**
 * Child theme functions
 *
 * Functions file for child theme, enqueues parent and child stylesheets by default.
 *
 * @since   1.0.0
 * @package aa
 */
  

// Скрипты и стили
add_action( 'wp_enqueue_scripts', 'theme_scripts' );
function theme_scripts() {

wp_enqueue_script( 'main-js', get_stylesheet_directory_uri().'/js/main.js', array( 'jquery' ));
wp_enqueue_script( 'bpopup-js', get_stylesheet_directory_uri().'/js/jquery.bpopup.min.js', array( 'jquery' ));
wp_enqueue_script( 'owl', get_stylesheet_directory_uri().'/js/owl.carousel.min.js' );
wp_enqueue_script( 'maskedinput', get_stylesheet_directory_uri().'/js/jquery.maskedinput.min.js' , array( 'jquery' ) );


wp_enqueue_style('styles-child', get_stylesheet_directory_uri() .'/style.css', array( 'polestar-style' ) );
wp_enqueue_style('owl-css', get_stylesheet_directory_uri() .'/css/owl.carousel.min.css' );

}

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Контактные данные',
		'menu_title'	=> 'Контактные данные',
		'menu_slug' 	=> 'sait-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

}



function js_variables(){
    $variables = array (
    'ajax_url' => admin_url('admin-ajax.php'), );
    echo '<script>window.wp_data = ' . json_encode($variables) . ';</script>';
}
add_action('wp_head','js_variables');


add_action('wp_ajax_get_product', 'get_product_per_page'); 
add_action('wp_ajax_nopriv_get_product', 'get_product_per_page');


function get_product_per_page() {

global $post;
global $wp_query;

$cur_ID = $_POST['page_id'];
$per_page = $_POST['per_page'];
$key = $_POST['key'];

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 

$args = array(
  'post_type' => 'ustroistva', 
  'post_status' => 'publish', 
  'order' => 'DESC', 
  'orderby' => 'date', 
  'posts_per_page' => $per_page, 
  'paged' => $paged, 
  'meta_query'		=> array(
	array(
		'key' => $key,
		'value' => '"'. $cur_ID . '"',
		'compare' => 'LIKE'
		)
	)
);



// WP_Query
$eq_query = new WP_Query( $args );
if ($eq_query->have_posts()) : // The Loop
	
	$single_item .= "";

	while ($eq_query->have_posts()): $eq_query->the_post();
	
	$single_item .= '<div class="device-single white-box-shadow">';
	$single_item .= '<div class="dev-title">'. get_the_title() .'</div>';
	$single_item .= '<div class="art">'. get_field( 'art' ) .'</div>';
	if ( has_post_thumbnail() ) { 
	     $single_item .= get_the_post_thumbnail( $post->ID, 'eq-thumbnail');
	}
		
	$single_item .= '<div class="text">'. get_the_excerpt() .'</div>';
	$brend = get_field( 'brend' ); 
	if ( $brend ) { 
	$single_item .= '<img src="'. $brend['url'].'" alt="' . $brend['alt'].'" />';
	} 
	$single_item .= '</div>';

	
	
	endwhile; wp_reset_query(); 
	endif;

	echo $single_item;
wp_die();
}



add_filter( 'body_class', 'wpse15850_body_class', 10, 2 );

function wpse15850_body_class( $wp_classes, $extra_classes ) {

    # List tag to delete
    $class_delete = array('page-layout-full-width-no-sidebar', 'overlap-light', 'no-header-margin', 'no-footer-margin');

    # Verify if exist the class of WP in $class_delete
    foreach ($wp_classes as $class_css_key => $class_css) {
        if (in_array($class_css, $class_delete)) {
            unset($wp_classes[$class_css_key]);
        }
    }

    // Add the extra classes back untouched
    return array_merge( $wp_classes, (array) $extra_classes );
}

add_filter( 'body_class','halfhalf_body_class' );
function halfhalf_body_class( $classes ) {
 
    // if ( is_single() ) {
        $classes[] = 'page-layout-full-width-no-sidebar';
        $classes[] = 'overlap-light';
        $classes[] = 'no-header-margin';
        $classes[] = 'no-footer-margin';
    // }
     
    return $classes;
}

add_filter( 'get_the_archive_title', 'artabr_remove_name_cat' );
function artabr_remove_name_cat( $title ){
if ( is_category() ) {
$title = single_cat_title( '', false );
} elseif ( is_tag() ) {
$title = single_tag_title( '', false );
}
return $title;
}



add_action('wp_footer', 'wpmidia_activate_masked_input');
function wpmidia_activate_masked_input(){
?>
<script>
jQuery( function($){
$(".f_tel").mask("8(099)999-99-99");
});
</script>
<?php
}


function my_acf_init() {
	
	acf_update_setting('google_api_key', 'AIzaSyAG5STIfLPVbfF0QhUqqjtcurxzUoZ6Idc');
}

add_action('acf/init', 'my_acf_init');








