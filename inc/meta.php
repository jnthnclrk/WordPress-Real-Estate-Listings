<?php

/*
 * Inner meta box content
*/

function rel_inner_custom_box( $post ) {
	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'rel_nonce' );
	// The actual fields for data entry
	// Use get_post_meta to retrieve an existing value from the database and use the value for the form
	$rel_price_sale = get_post_meta( $post->ID, 'rel_price_sale', true );
	echo '<label for="rel_price_sale"><small>Sale:</small></label> <input type="text" id="rel_price_sale" name="rel_price_sale" value="'.esc_attr($rel_price_sale).'" size="10"/> <small>USD</small><br>';
	$rel_price_long_term = get_post_meta( $post->ID, 'rel_price_long_term', true );
	echo '<label for="rel_price_long_term"><small>Long Term:</small></label> <input type="text" id="rel_price_long_term" name="rel_price_long_term" value="'.esc_attr($rel_price_long_term).'" size="10"/> <small>USD monthly</small><br>';
	$rel_price_short_term = get_post_meta( $post->ID, 'rel_price_short_term', true );
	echo '<label for="rel_price_short_term"><small>Short Term:</small></label> <input type="text" id="rel_price_short_term" name="rel_price_short_term" value="'.esc_attr($rel_price_short_term).'" size="10"/> <small>USD daily</small><br>';
	$rel_price_time_share = get_post_meta( $post->ID, 'rel_price_time_share', true );
	echo '<label for="rel_price_time_share"><small>Time Share:</small></label> <input type="text" id="rel_price_time_share" name="rel_price_time_share" value="'.esc_attr($rel_price_time_share).'" size="10"/> <small>USD</small><br>';
}

/* 
 * Define and place the custom meta box on the edit screen
 */

function rel_add_custom_box() {
    $screens = array( 'listings' );
    foreach ($screens as $screen) {
        add_meta_box( 'rel_details', 'Details', 'rel_inner_custom_box', $screen, 'side', 'high' );
    }
}
add_action( 'add_meta_boxes', 'rel_add_custom_box' );


/* 
 * Do something with the data entered 
 */

function rel_save_postdata( $post_id ) {

  // First we need to check if the current user is authorised to do this action. 
  if ( 'page' == $_REQUEST['post_type'] ) {
    if ( ! current_user_can( 'edit_page', $post_id ) )
        return;
  } else {
    if ( ! current_user_can( 'edit_post', $post_id ) )
        return;
  }

  // Secondly we need to check if the user intended to change this value.
  if ( ! isset( $_POST['rel_nonce'] ) || ! wp_verify_nonce( $_POST['rel_nonce'], plugin_basename( __FILE__ ) ) )
      return;
  // Thirdly we can save the value to the database

  // If saving in a custom table, get post_ID
  $post_ID = $_POST['post_ID'];

  // Sanitize user input
  $rel_price_sale = sanitize_text_field( $_POST['rel_price_sale'] );
  $rel_price_long_term = sanitize_text_field( $_POST['rel_price_long_term'] );
  $rel_price_short_term = sanitize_text_field( $_POST['rel_price_short_term'] );
  $rel_price_time_share = sanitize_text_field( $_POST['rel_price_time_share'] );

  // Save
  add_post_meta( $post_ID, 'rel_price_sale', $rel_price_sale, true ) or update_post_meta( $post_ID, 'rel_price_sale', $rel_price_sale );
  add_post_meta( $post_ID, 'rel_price_long_term', $rel_price_long_term, true ) or update_post_meta( $post_ID, 'rel_price_long_term', $rel_price_long_term );
  add_post_meta( $post_ID, 'rel_price_short_term', $rel_price_short_term, true ) or update_post_meta( $post_ID, 'rel_price_short_term', $rel_price_short_term );
  add_post_meta( $post_ID, 'rel_price_time_share', $rel_price_time_share, true ) or update_post_meta( $post_ID, 'rel_price_time_share', $rel_price_time_share );
}
add_action( 'save_post', 'rel_save_postdata' );
?>
