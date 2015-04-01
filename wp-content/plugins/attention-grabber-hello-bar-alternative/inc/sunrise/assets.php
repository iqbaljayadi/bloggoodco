<?php

	// Enqueue backend assets
	if ( is_admin() ) {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( $this->slug . '-backend', $this->assets( 'js', 'fia-backend.js' ), array( 'jquery' ), $this->version, false );
	}

	// Enqueue frontend assets
	else {
		wp_enqueue_style( $this->slug . '-frontend', $this->assets( 'css', 'frontend.css' ), false, $this->version, 'all' );
		wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jqueryui', $this->assets('js', 'jquery-ui.js'), array( 'jquery' ), '1.10.3', true );
        wp_enqueue_script( 'jquery-cookie', $this->assets('js', 'jquery.cookie.js'), array( 'jquery' ), '1.3.1', true );
		wp_enqueue_script( $this->slug . '-frontend', $this->assets( 'js', 'frontend.js' ), array( 'jquery' ), $this->version, true );
	}
?>