<?php 

// Include and instantiate the class.
require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;

add_action( 'wp_enqueue_scripts', 'script_enqueues', 100 );
function script_enqueues()
{
    /* wp_dequeue_script( 'parent_theme_script_handle' ); */
    /*wp_enqueue_script( 'child_theme_iosslider_handle', get_stylesheet_directory_uri() . '/js/jquery.iosslider.min.js', array( 'jquery' ) );*/
    wp_enqueue_script( 'simpel-zoom', get_stylesheet_directory_uri() . '/js/vicinity-simple-zoom.js' );
}

/*wp_register_style('woocommerce', get_stylesheet_directory_uri() . 'woocommerceSalientOverride.css');*/
/*wp_register_style('woocommerce', get_stylesheet_directory_uri() . 'woocommerceOverride.css');*/

/*wp_enqueue_style('woocommerce_css', plugins_url() .'../../plugins/woocommerce/assets/css/woocommerce.css');*/
/*wp_enqueue_style('woocommerce_custom_css', get_template_directory_uri() .'woocustom.css');*/

add_filter('woocommerce_product_variable_add_to_cart_text', 'woo_custom_variable_button_text');
function woo_custom_variable_button_text() {
	return __( 'My Button Text', 'woocommerce' );
}

add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );    // 2.1 +
function woo_custom_cart_button_text() {
	return __( 'My Button Text', 'woocommerce' );
}

add_filter( 'woocommerce_product_add_to_cart_text', 'woo_archive_custom_cart_button_text' );    // 2.1 +
function woo_archive_custom_cart_button_text() {
	return __( 'My Button Text', 'woocommerce' );
}

add_filter( 'woocommerce_get_availability', 'custom_get_availability', 1, 2);
function custom_get_availability( $availability, $_product ) {
	//change text “In Stock’ to ‘ ’
	if ( $_product->is_in_stock() ) $availability['availability'] = __(' ', 'woocommerce');

	//change text “Out of Stock’ to ‘SOLD OUT’
	if ( !$_product->is_in_stock() ) $availability['availability'] = __('SOLD OUT', 'woocommerce');
	return $availability;
}


if( !$detect->isMobile() || $detect->isTablet() ){
	// REMOVE IOS SLIDER ONLY ON DESKTOP AND TABLET :
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
} else {
	/* Move Product Title ONLY ON MOBILE PHONE 
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_title', 5 );
	
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
	add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_price', 10 );
	*/
}

/** woocommerce: hide rating / meta / sharing on all platforms **/
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );


/** woocommerce: change position of add-to-cart on single product**/
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 19 );

// hide coupon field on cart page
add_filter( 'woocommerce_coupons_enabled', 'hide_coupon_field_on_cart' );
function hide_coupon_field_on_cart( $enabled ) {
	if ( is_cart() ) {
		$enabled = false;
	}
	return $enabled;
}


// hide coupon field on checkout page
add_filter( 'woocommerce_coupons_enabled', 'hide_coupon_field_on_checkout' );
function hide_coupon_field_on_checkout( $enabled ) {
	if ( is_checkout() ) {
		$enabled = false;
	}
	return $enabled;
}

/* End of file functions.php */