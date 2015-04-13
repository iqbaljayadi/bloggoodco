<?php
global $g7_builder_query, $g7_block_class;
list($image_w, $image_h) = g7_image_sizes('grid');
$counter = 1;
?>
<div class="block block-custom block-10 col-lg-12 <?php echo $g7_block_class; ?>">
	<header>
		<?php get_template_part('block', 'header'); ?>
	</header>
	<div class="row custom-row">
	<ul>
		<?php while ($g7_builder_query->have_posts()) : $g7_builder_query->the_post(); ?>
			<li class="col-sm-3 col-xs-6 post">
				<?php if (has_post_thumbnail()) : ?>
					<div class="block-top">
						<?php echo g7_image(240, 200); ?>
						<div class="block-content">
							<h3 class="block-heading">
								<a href="<?php the_permalink(); ?>">
									<?php the_title(); ?>
								</a>
							</h3>
							<div class="block-meta">
								<?php echo g7_date_meta(); ?>
								<?php echo g7_comments_meta(); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</li>
			<?php $counter++;
			endwhile; ?>
		</ul>
		</div>
	</div>
