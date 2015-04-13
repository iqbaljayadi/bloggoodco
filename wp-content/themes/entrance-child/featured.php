<?php
if (!g7_show_featured()) {
	return;
}
?>

<div id="home_cta_1">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 cta_col">
				<div class="home_cta_content">
					<div class="cta_text">
						Discover your personality!<br />We'll send over the link to download the app.
					</div>
					<link rel="stylesheet" href="http://d3q6uu7asevdsg.cloudfront.net/1.2/css/link_texting.min.css">
					<style type="text/css">
					</style>
					<div class="linkTexting_oq3j39q0 blog_linktexting">
						<div class="linkTextingInner_oq3j39q0 linktexting_input_wrapper">
							<input class="linkTextingInput_oq3j39q0" type="tel" id="numberToText_linkTexting_oq3j39q0_2b772065-d3dd-4cd0-b9f6-2fcaf42cfa36"></input>
							<button class="linkTextingButton_oq3j39q0" type="button" onclick="sendLink_linkTexting_oq3j39q0('2b772065-d3dd-4cd0-b9f6-2fcaf42cfa36')" id="sendButton_linkTexting_oq3j39q0_2b772065-d3dd-4cd0-b9f6-2fcaf42cfa36">Text me the link</button>
							<div class="linkTextingError_oq3j39q0" id="linkTextingError_oq3j39q0_2b772065-d3dd-4cd0-b9f6-2fcaf42cfa36" style="display:none;"></div>
						</div>
					</div>
					<script type="text/javascript" src="//d3q6uu7asevdsg.cloudfront.net/1.2/js/link_texting.min.js"></script>
				</div>
			</div>
			<div class="col-sm-6 cta_col">

			</div>
		</div>
	</div>
</div>

<?php $flayout       = get_theme_mod('featured_layout', 1);
$limit         = $flayout == 2 ? get_theme_mod('slider_limit', 3) : 5;
$featured_tags = explode(',', get_theme_mod('featured_tags', 'featured'));
$tags          = array();
$have_posts    = false;

if (!empty($_GET['slider'])) {
	$flayout = 2;
}

foreach ((array)$featured_tags as $tag) {
	$tags[] = trim($tag);
}

if (!empty($tags)) {
	$featured = new WP_Query(array(
		'posts_per_page'      => $limit,
		'tag_slug__in'        => $tags,
		'ignore_sticky_posts' => 1,
		));
	if ($featured->have_posts()) {
		$have_posts = true;
	}
}

if (!$have_posts) {
	$featured = new WP_Query(array(
		'posts_per_page'      => $limit,
		'post__in'            => get_option('sticky_posts'),
		'ignore_sticky_posts' => 1,
		));
	if ($featured->have_posts()) {
		$have_posts = true;
	}
}

list($image_w, $image_h)   = g7_image_sizes('full');
list($image_w1, $image_h1) = g7_image_sizes('featured1');
list($image_w2, $image_h2) = g7_image_sizes('featured2');

$i = 1;
?>

<?php if ($have_posts) : ?>

	<?php if ($flayout == 2) : ?>
		<div class="container" style="padding-top:0">
			<div class="flexslider featured">
				<ul class="slides">
					<?php while ($featured->have_posts()) : $featured->the_post(); ?>
						<li class="post cat-<?php echo get_the_first_category_ID(); ?>">
							<a href="<?php the_permalink(); ?>">
								<?php echo g7_image($image_w, $image_h, false); ?>
							</a>
							<header>
								<span class="entry-category">
									<?php echo get_the_first_category(); ?>
								</span>
								<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							</header>
						</li>
					<?php endwhile; ?>
				</ul>
			</div>
		</div>

	<?php else : ?>
		<div class="container" style="padding-top:0">
			<div class="row featured">
				<?php while ($featured->have_posts()) : $featured->the_post(); ?>
					<?php if ($i == 1) : ?>
						<div class="most-featured post col-sm-6 cat-<?php echo get_the_first_category_ID(); ?>">
							<span class="entry-category">
								<?php echo get_the_first_category(); ?>
							</span>
							<a href="<?php the_permalink(); ?>">
								<?php echo g7_image($image_w1, $image_h1, false); ?>
							</a>
							<header>
								<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
							</header>
						</div>
					<?php else : ?>
						<div class="post col-sm-3 col-xs-6 cat-<?php echo get_the_first_category_ID(); ?>">
							<a href="<?php the_permalink(); ?>">
								<?php echo g7_image($image_w2, $image_h2, false); ?>
							</a>
							<header>
								<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							</header>
						</div>
					<?php endif; ?>
					<?php $i++; endwhile; ?>
				</div>
			</div>

		<?php endif; ?>

	<?php endif; ?>
