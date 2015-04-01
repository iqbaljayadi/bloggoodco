<?php
function wp_insert_admin_page($pageTitle, $sectionName, $optionName) { ?>
    <div class="wrap wp-insert">
		<a href="http://www.wp-insert.smartlogix.co.in"><img src="<?php echo WP_INSERT_URL; ?>/includes/common/images/logo.png" /></a>
		<form method="post" action="options.php" name="wp_auto_commenter_form" id="wp_insert_form">
			<?php settings_fields($optionName); ?>
			<div id="poststuff" class="metabox-holder has-right-sidebar wp-insert-plugin">
				<div id="side-info-column" class="inner-sidebar">
					<?php do_settings_sections('wp-insert-support'); ?>
				</div>
				<div id="post-body" class="has-sidebar">				
					<div id="post-body-content" class="has-sidebar-content">
						<?php do_settings_sections($sectionName); ?>
					</div>
				</div>
				<br class="clear"/>			
			</div>
			<?php
			wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
			wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);
			?>
			<script type="text/javascript">
			jQuery(document).ready( function($) {
				jQuery('.if-js-closed').removeClass('if-js-closed').addClass('closed');
				postboxes.add_postbox_toggles('<?php echo $sectionName; ?>');
			});
			
			function wpInsertChitikaPopUpHandler(sender) {
				jQuery.colorbox({overlayClose: false, scrolling: false, transition: "elastic", innerWidth: "577px", innerHeight: "402px", iframe: true, href: "<?php echo WP_INSERT_URL; ?>/includes/common/popups/chitika.php?target="+sender});
				return false;
			}
			</script>
		</form>
    </div>
<?php
}
?>