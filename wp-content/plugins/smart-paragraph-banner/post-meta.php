<?php

/**
 * Adds a meta box to the post type = post
 */

function spb_custom_meta() {
    add_meta_box( 'spb_meta', 'Smart Paragraph Banner', 'spb_meta_callback', 'post' );
}

add_action( 'add_meta_boxes', 'spb_custom_meta' );

/**
 * Outputs the content of the meta box
 */
function spb_meta_callback( $post ) {

    wp_nonce_field( basename( __FILE__ ), 'spb_nonce' );

    $spb_stored_meta = get_post_meta( $post->ID,'spb_active',true );

    ?>
 
    <p>
        <label for="spb_active" class="spb-row-title">Disable Smart Banner</label>

        <?php

        	$arrayValue = array('no'=>'No','yes'=>'Yes');
        	echo "<select name='spb_active'>";
        	foreach ($arrayValue as $key => $value) {
        		
        		$selected = 'true';

        		if($key==$spb_stored_meta)
        			$selected='selected';

        		echo "<option value='{$key}' $selected>{$value}</option>";

        	}
        	echo "</select>";

        ?>

    </p>
 
    <?php
}

/**
 * Saves the custom meta input
 */
function spb_meta_save( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );

    $is_valid_nonce = ( isset( $_POST[ 'spb_nonce' ] ) && wp_verify_nonce( $_POST[ 'spb_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'spb_active' ] ) ) {
        update_post_meta( $post_id, 'spb_active', sanitize_text_field( $_POST[ 'spb_active' ] ) );
    }
 
}
add_action( 'save_post', 'spb_meta_save' );