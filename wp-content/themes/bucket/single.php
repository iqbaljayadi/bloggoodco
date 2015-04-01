<?php get_header(); ?>

<?php get_template_part('wrapper', 'start'); ?>
	
	<?php while (have_posts()) : the_post(); ?>
		 
		<div class="other"><div class="addthis_sharing_toolbox"></div> <?php get_template_part('content', 'single'); ?> </div>             
		<!-- Go to www.addthis.com/dashboard to customize your tools -->		 
		<?php comments_template(); ?>

	<?php endwhile; ?>

<?php get_template_part('wrapper', 'end'); ?>

<?php get_footer(); ?>