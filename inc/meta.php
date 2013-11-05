<?php

/*
 * Inner meta box content
*/

function rel_inner_custom_box( $post ) {
	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'rel_nonce' );
	// The actual fields for data entry
	// Use get_post_meta to retrieve an existing value from the database and use the value for the form
	echo '<div style="width: 250px; float: left; margin: 10px 10px 0px 0px;><p class="sub"><strong>Pricing</strong></p><table><tbody>';
	$rel_price_sale = get_post_meta( $post->ID, 'rel_price_sale', true );
	echo '<tr><td><label for="rel_price_sale"><small>Sale:</small></label></td><td><input type="text" id="rel_price_sale" name="rel_price_sale" value="'.esc_attr( $rel_price_sale ).'" size="10"/> <small>USD</small></td></tr>';
	$rel_price_long_term = get_post_meta( $post->ID, 'rel_price_long_term', true );
	echo '<tr><td><label for="rel_price_long_term"><small>Long Term:</small></label></td><td><input type="text" id="rel_price_long_term" name="rel_price_long_term" value="'.esc_attr( $rel_price_long_term ).'" size="10"/> <small>USD monthly</small></td></tr>';
	$rel_price_short_term = get_post_meta( $post->ID, 'rel_price_short_term', true );
	echo '<tr><td><label for="rel_price_short_term"><small>Short Term:</small></label></td><td><input type="text" id="rel_price_short_term" name="rel_price_short_term" value="'.esc_attr( $rel_price_short_term ).'" size="10"/> <small>USD daily</small></td></tr>';
	$rel_price_time_share = get_post_meta( $post->ID, 'rel_price_time_share', true );
	echo '<tr><td><label for="rel_price_time_share"><small>Time Share:</small></label></td><td><input type="text" id="rel_price_time_share" name="rel_price_time_share" value="'.esc_attr( $rel_price_time_share ).'" size="10"/> <small>USD</small></td></tr>';
	echo '</tbody></table></div>';

	echo '<div style="width: 250px; float: left; margin: 20px 10px 0px 0px;><p class="sub"><strong>Features</strong></p><table><tbody>';
	$rel_bedrooms = get_post_meta( $post->ID, 'rel_bedrooms', true );
	echo '<tr><td><label for="rel_bedrooms"><small>Bedrooms:</small></label></td><td><input type="text" id="rel_bedrooms" name="rel_bedrooms" value="'.esc_attr( $rel_bedrooms ).'" size="10"/></td></tr>';
	$rel_bathrooms = get_post_meta( $post->ID, 'rel_bathrooms', true );
	echo '<tr><td><label for="rel_bathrooms"><small>Bathrooms:</small></label></td><td><input type="text" id="rel_bathrooms" name="rel_bathrooms" value="'.esc_attr( $rel_bathrooms ).'" size="10"/></td></tr>';
	echo '</tbody></table></div>';

	echo '<div style="width: 250px; float: left; margin: 20px 10px 0px 0px;><p class="sub"><strong>Specifications</strong></p><table><tbody>';
	$rel_price_per_sq_ft = get_post_meta( $post->ID, 'rel_price_per_sq_ft', true );
	echo '<tr><td><label for="rel_price_per_sq_ft"><small>$ Per Sq. Ft.:</small></label></td><td><input type="text" id="rel_price_per_sq_ft" name="rel_price_per_sq_ft" value="'.esc_attr( $rel_price_per_sq_ft ).'" size="10"/> <small>USD</small></td></tr>';
	$rel_lot_size = get_post_meta( $post->ID, 'rel_lot_size', true );
	echo '<tr><td><label for="rel_lot_size"><small>Lot Size:</small></label></td><td><input type="text" id="rel_lot_size" name="rel_lot_size" value="'.esc_attr( $rel_lot_size ).'" size="10"/> <small>Sq. Ft.</small></td></tr>';
	$rel_covered_size = get_post_meta( $post->ID, 'rel_covered_size', true );
	echo '<tr><td><label for="rel_covered_size"><small>Covered Size:</small></label></td><td><input type="text" id="rel_covered_size" name="rel_covered_size" value="'.esc_attr( $rel_covered_size ).'" size="10"/> <small>Sq. Ft.</small></td></tr>';
	echo '</tbody></table></div>';

	echo '<div style="clear: both;"></div>';

}

/* 
 * Define and place the custom meta box on the edit screen
 */

function rel_add_custom_box() {
    $screens = array( 'listings' );
    foreach ($screens as $screen) {
        add_meta_box( 'rel_details', 'Listing Details', 'rel_inner_custom_box', $screen, 'side', 'high' );
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
  $rel_bedrooms = sanitize_text_field( $_POST['rel_bedrooms'] );
  $rel_bathrooms = sanitize_text_field( $_POST['rel_bathrooms'] );
  $rel_price_per_sq_ft = sanitize_text_field( $_POST['rel_price_per_sq_ft'] );
  $rel_lot_size = sanitize_text_field( $_POST['rel_lot_size'] );
  $rel_covered_size = sanitize_text_field( $_POST['rel_covered_size'] );

  // Save
  add_post_meta( $post_ID, 'rel_price_sale', $rel_price_sale, true ) or update_post_meta( $post_ID, 'rel_price_sale', $rel_price_sale );
  add_post_meta( $post_ID, 'rel_price_long_term', $rel_price_long_term, true ) or update_post_meta( $post_ID, 'rel_price_long_term', $rel_price_long_term );
  add_post_meta( $post_ID, 'rel_price_short_term', $rel_price_short_term, true ) or update_post_meta( $post_ID, 'rel_price_short_term', $rel_price_short_term );
  add_post_meta( $post_ID, 'rel_price_time_share', $rel_price_time_share, true ) or update_post_meta( $post_ID, 'rel_price_time_share', $rel_price_time_share );
  add_post_meta( $post_ID, 'rel_bedrooms', $rel_bedrooms, true ) or update_post_meta( $post_ID, 'rel_bedrooms', $rel_bedrooms );
  add_post_meta( $post_ID, 'rel_bathrooms', $rel_bathrooms, true ) or update_post_meta( $post_ID, 'rel_bathrooms', $rel_bathrooms );
  add_post_meta( $post_ID, 'rel_price_per_sq_ft', $rel_price_per_sq_ft, true ) or update_post_meta( $post_ID, 'rel_price_per_sq_ft', $rel_price_per_sq_ft );
  add_post_meta( $post_ID, 'rel_lot_size', $rel_lot_size, true ) or update_post_meta( $post_ID, 'rel_lot_size', $rel_lot_size );
  add_post_meta( $post_ID, 'rel_covered_size', $rel_covered_size, true ) or update_post_meta( $post_ID, 'rel_covered_size', $rel_covered_size );
}
add_action( 'save_post', 'rel_save_postdata' );

?>
