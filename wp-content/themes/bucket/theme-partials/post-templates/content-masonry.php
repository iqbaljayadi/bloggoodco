<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 */
?>
<article <?php post_class('article  article--grid'); ?>>
	<?php get_template_part('theme-partials/post-templates/header-blog', get_post_format()); ?>
    <div class="article--grid__body">
        <div class="article__content">
            <?php echo wpgrade_better_excerpt(); ?>
        </div>
    </div>
    <div class="article__meta  article--grid__meta">
        <div class="split">
            <div class="split__title  article__category">
                <?php
                    $categories = get_the_category();
                    if ($categories) {
                        $category = $categories[0];
                        echo '<a class="small-link" href="'. get_category_link($category->term_id) .'" title="'. esc_attr(sprintf(__("View all posts in %s", wpgrade::textdomain()), $category->name)) .'">'. $category->cat_name.'</a>';
                    }
                ?>
            </div>
			<ul class="nav  article__meta-links">
				<li class="xpost_date"><i class="icon-time"></i> <?php the_time('j M') ?></li>
				<?php get_template_part('theme-partials/post-templates/social-numbers','update'); ?>
			</ul>
        </div>
    </div>

</article><!-- .article -->