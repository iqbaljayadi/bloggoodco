<?php
add_action('init', 'wp_insert_syntax_highlighting_admin_scripts');
function wp_insert_syntax_highlighting_admin_scripts() {
	$options = get_option('wp_insert_syntax_highlighting_options');
	if($options) {
		if($options['editor']['status']) {
			add_action('admin_enqueue_scripts', 'wp_insert_syntax_highlighting_admin_enqueue_scripts');
			
			add_action('admin_footer', 'wp_insert_syntax_highlighting_admin_footer');
		}
		
		if($options['content']['status']) {
			wp_enqueue_script('editarea', WP_INSERT_URL.'/includes/syntax-highlighting/editarea/edit_area_full.js');
			add_action('wp_footer', 'wp_insert_syntax_highlighting_wp_footer');
			add_shortcode('code', 'wp_insert_syntax_highlighting_shortcode_code');
		}
	}
}

function wp_insert_syntax_highlighting_admin_enqueue_scripts($page) {
	if(('theme-editor.php' == $page) || ('plugin-editor.php' == $page)) {
		wp_enqueue_script('editarea', WP_INSERT_URL.'/includes/syntax-highlighting/editarea/edit_area_full.js');
	}
}

function wp_insert_syntax_highlighting_shortcode_code($atts, $content = null) {
	extract(shortcode_atts(array('language' => 'php', 'custom' => ''), $atts));
	$random = rand(0,999999);
	if($custom != '') {
		global $post;
		return '<textarea title="'.$language.'" class="codeSnippet" name="codeSnippet" id="codeSnippet_'.$random.'">'.get_post_meta($post->ID, $custom, true).'</textarea>';
	} else {
		return '<textarea title="'.$language.'" class="codeSnippet" name="codeSnippet" id="codeSnippet_'.$random.'">'.$content.'</textarea>';
	}
}

function wp_insert_syntax_highlighting_wp_footer() {
	echo '<script type="text/javascript">';
	echo 'try {';
		echo 'var codeBlocks = document.getElementsByName("codeSnippet");';
			echo 'for(var i = 0; i < codeBlocks.length; i++) {';
				echo 'editAreaLoader.init({';
					echo 'id: codeBlocks[i].id, start_highlight: true, allow_resize: "y", allow_toggle: false, toolbar: "go_to_line, |, select_font, |, syntax_selection, |, highlight, reset_highlight, |, word_wrap", is_editable: true, word_wrap: true, syntax: codeBlocks[i].title';
				echo '});';
			echo '}';
	echo '} catch (e) { void(0); }';
	echo '</script>';
}

function wp_insert_syntax_highlighting_admin_footer() {
	if(basename($_SERVER['SCRIPT_NAME']) == 'plugin-editor.php' || basename($_SERVER['SCRIPT_NAME']) == 'theme-editor.php') {
		global $file;
		$ext = strstr(basename($file),'.');
		switch($ext) {
			case '.php':
				$ext = 'php';
				break;
			case '.css':
				$ext = 'css';
				break;
			case '.js':
				$ext = 'js';
				break;
			case '.html':
			case '.htm':
				$ext = 'html';
				break;
			default:
				$ext = '';
				break;
		}
		echo '<script type="text/javascript">';
		echo 'try {';
			echo 'editAreaLoader.init({';
				echo 'id: "newcontent", start_highlight: true ,allow_resize: "y", allow_toggle: true, toolbar: "search, go_to_line, |, undo, redo, |, select_font, |, syntax_selection, |, change_smooth_selection, highlight, reset_highlight, |, word_wrap, help", syntax_selection_allow: "css,html,js,php,xml", word_wrap: true, syntax: "'.$ext.'"';
			echo '});';
		echo '} catch (e) { void(0); }';
		echo '</script>';
	}
}
?>