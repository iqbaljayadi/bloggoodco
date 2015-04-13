<?php
global $g7_builder_query, $g7_block_class;
?>
<div class="col-sm-12 block block-custom block-7 <?php echo $g7_block_class; ?>">
	<div class="row custom-row">
		<div class="col-sm-6">
			<div class="row custom-row">
				<header class="col-sm-12">
					<?php get_template_part('block', 'header'); ?>
				</header>
				<ul>
					<?php while ($g7_builder_query->have_posts()) : $g7_builder_query->the_post(); ?>
						<li class="post col-sm-6 custom-list">
							<h4 class="block-heading">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h4>
							<div class="block-meta">
								<?php echo g7_date_meta(); ?>
							</div>
							<div class="clear"></div>
						</li>
					<?php endwhile; ?>
				</ul>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="row custom-row">
				<?php dynamic_sidebar('homepage-sidebar'); ?> 
			</div>
		</div>
	</div>
</div>
