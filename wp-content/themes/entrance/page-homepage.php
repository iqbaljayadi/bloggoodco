<?php
/* Template Name: Homepage */

get_header(); ?>

<?php get_template_part('wrapper', 'start'); ?>

	<?php while (have_posts()) : the_post(); ?>

		<?php get_template_part('content', 'page'); ?>

	<?php endwhile; ?>
<?php get_template_part('wrapper', 'end'); ?>

<?php get_footer(); ?>