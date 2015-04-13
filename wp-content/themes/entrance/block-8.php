<?php
global $g7_builder_query, $g7_block_class, $g7_cat;
$cat = get_category($g7_cat);
$block_counter = 1;
list($image_w, $image_h) = g7_image_sizes('grid');
list($image_w2, $image_h2) = g7_image_sizes('thumb');
?>
<div class="col-sm-3 block block-custom block-8 <?php echo $g7_block_class.' '.$cat->slug; ?>">
	<header>
		<?php get_template_part('block', 'header'); ?>
	</header>
	<ul>
		<?php while ($g7_builder_query->have_posts()) : $g7_builder_query->the_post(); ?>
			<li class="post">
				<?php if ($block_counter == 1) : ?>
					<?php if (has_post_thumbnail()) : ?>
						<div class="block-top">
							<?php echo g7_image(240, 200); ?>
							<div class="block-content block-content-1">
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
							<div class="block-content block-content-alt block-content-2">
								<h3 class="block-heading">
									<a href="<?php the_permalink(); ?>">
										<?php
										$some_string = get_the_title();
										if(strlen($some_string) > 60) {
											$some_string = substr($some_string,0,60)."...";
										}

										echo $some_string;
										?>
									</a>
								</h3>
								<div class="block-meta">
									<?php echo g7_date_meta(); ?>
									<?php echo g7_comments_meta(); ?>
								</div>
							</div>
							<div class="block-content block-content-alt block-content-3">
								<h3 class="block-heading">
									<a href="<?php the_permalink(); ?>">
										<?php
										$some_string = get_the_title();
										if(strlen($some_string) > 45) {
											$some_string = substr($some_string,0,45)."...";
										}

										echo $some_string;
										?>
									</a>
								</h3>
								<div class="block-meta">
									<?php echo g7_date_meta(); ?>
									<?php echo g7_comments_meta(); ?>
								</div>
							</div>
							<div class="block-content block-content-alt block-content-4">
								<h3 class="block-heading">
									<a href="<?php the_permalink(); ?>">
										<?php
										$some_string = get_the_title();
										if(strlen($some_string) > 27) {
											$some_string = substr($some_string,0,27)."...";
										}

										echo $some_string;
										?>
									</a>
								</h3>
								<div class="block-meta">
									<?php echo g7_date_meta(); ?>
									<?php echo g7_comments_meta(); ?>
								</div>
							</div>
							<div class="block-content block-content-alt block-content-5">
								<h3 class="block-heading">
									<a href="<?php the_permalink(); ?>">
										<?php
										$some_string = get_the_title();
										if(strlen($some_string) > 70) {
											$some_string = substr($some_string,0,70)."...";
										}

										echo $some_string;
										?>
									</a>
								</h3>
								<div class="block-meta">
									<?php echo g7_date_meta(); ?>
									<?php echo g7_comments_meta(); ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php else : ?>
					<div class="block-content">
						<h4 class="block-heading">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h4>
						<div class="block-meta">
							<?php echo g7_date_meta(); ?>
						</div>
					</div>
					<div class="clear"></div>
				<?php endif; ?>
			</li>
			<?php $block_counter++; endwhile; ?>
		</ul>
	</div>
