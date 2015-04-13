<?php
global $g7_builder_query, $g7_block_class;
list($image_w, $image_h) = g7_image_sizes('grid');
$counter = 1;
?>
<div class="col-sm-12 block block-custom block-9 <?php echo $g7_block_class.' '.$cat->slug; ?>">
	<header>
		<?php get_template_part('block', 'header'); ?>
	</header>
	<div class="row custom-row">
		<ul>
			<?php while ($g7_builder_query->have_posts()) : $g7_builder_query->the_post();
			if($counter == 1)
				{ $col = 6;}
			else { $col = 3;} 
			?>
			<li class="col-sm-<?php echo $col ?> post">
				<?php if (has_post_thumbnail()) : ?>
					<div class="block-top">
						<?php
						if($counter == 1) {
							$image_w = 510;
							$image_w_alt = 240;
							$imgwide = 'imgwide';
							$imgalt = 'imgalt';
						}
						else {
							$image_w = 240;
						}
						?>
						<div class="<?php
						if($counter == 1) {
							echo $imgwide;
						}
						?>">
						<?php echo g7_image($image_w, 200); ?>
					</div>
					<?php if($counter == 1) { ?>
					<div class="<?php echo $imgalt ?>">
						<?php echo g7_image($image_w_alt, 200); ?>
					</div>
					<?php } ?>

					<?php if($counter == 1) { ?>
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
					<?php }
					else { ?>
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
					<?php }
					?>


				</div>
			<?php endif; ?>
		</li>
		<?php $counter++;
		endwhile; ?>
	</ul>
</div>
</div>