                    <div class="comments">
                        <?php if (post_password_required()) { ?>
                            
                        <?php } else { ?>
                            <?php if (have_comments()) { ?>
                                <div class="comments-title-wrap">

                                    <?php

                                    $num_comments = get_comments_number(); // get_comments_number returns only a numeric value
                                    if ( $num_comments == 0 ) {
                                        $td_comments_no_text = __td('No replies');
                                    } elseif ( $num_comments > 1 ) {
                                        $td_comments_no_text = $num_comments . ' ' . __td('replies');
                                    } else {
                                        $td_comments_no_text = __td('1 reply');
                                    }


                                    $td_comments_no_text .= ' ' . __td('to this post');
                                    //echo $td_comments_no_text;


                                    echo td_text_with_title(array('title' => $td_comments_no_text, 'style' => 'style_1', 'class' => 'comment_reply_text'));


                                    //$comment_number_buffer = get_comments_number(__td('No replies', TD_THEME_NAME), __td('1 reply', TD_THEME_NAME), __('% ', TD_THEME_NAME) . __td('replies'));

                                    //_etd('to this post', TD_THEME_NAME);
                                    ?>

                                </div>
                                <ol class="comment-list">
                                    <?php wp_list_comments( array( 'callback' => 'td_comment' ) ); ?>
                                </ol>
                                <div class="comment-pagination">
                                    <?php paginate_comments_links(); ?> 
                                </div>
                            <?php } ?>
                            <?php 
                            
                            
                            
                            $commenter = wp_get_current_commenter();

                            if (empty($aria_req)) {
                                $aria_req = '';
                            }
$fields =  array(
    'author' =>
    '<p class="comment-form-input-wrap">
        <span class="comment-req-wrap"><input id="author" name="author" placeholder="' . __td('Name:', TD_THEME_NAME) . '" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />' . ( $req ? '</span>' : '' ) .
    '</p>',

    'email'  =>
    '<p class="comment-form-input-wrap">
        <span class="comment-req-wrap"><input id="email" name="email" placeholder="' . __td('Email:', TD_THEME_NAME) . '" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />' . ( $req ? '</span>' : '' ) .
    '</p>',

    'url' =>
    '<p class="comment-form-input-wrap">
        <input id="url" name="url" placeholder="' . __td('Website:', TD_THEME_NAME) . '" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />' .
    '</p>',
);

$defaults = array(
 'fields' => apply_filters('comment_form_default_fields', $fields ),
);

$defaults['comment_field'] = '<div class="clearfix"></div><p class="comment-form-input-wrap"><textarea placeholder="' . __td('Comment:', TD_THEME_NAME) . '" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';

$defaults['comment_notes_before'] = '';
$defaults['comment_notes_after'] = '';
$defaults['title_reply'] = __td('Leave a Reply');
$defaults['label_submit'] = __td('Post Comment');
$defaults['cancel_reply_link'] = __td('Cancel reply');

comment_form($defaults);
                            //comment_form(); 
                            
                            ?>
                        <?php } ?>
                    </div> <!-- /.content -->
                    
     
<?php

	/**
	 * Custom callback for outputting comments 
	 *
	 * @return void
	 * @author tagdiv
	 */
	function td_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; 
                
                $td_isPingTrackbackClass = '';
                
                if($comment->comment_type == 'pingback') { 
                    $td_isPingTrackbackClass = 'pingback';
                }
                
                if($comment->comment_type == 'trackback') { 
                    $td_isPingTrackbackClass = 'trackback';
                }
                
		?>
		<?php if ( $comment->comment_approved == '1' ) { ?>	
                    <li class="comment <?php echo $td_isPingTrackbackClass ?>" id="li-comment-<?php comment_ID() ?>">
                        <article>
                            <footer>
                                <?php echo get_avatar( $comment ); ?>
                                <cite><?php comment_author_link() ?></cite>
                                <div class="comment-meta" id="comment-<?php comment_ID() ?>">
                                    <a class="comment-link" href="#li-comment-<?php comment_ID() ?>">
                                        <time pubdate=""><?php comment_date() ?> at <?php comment_time() ?></time>
                                    </a>
                                    <?php comment_reply_link(array_merge( $args, array(
                                        'depth' => $depth, 
                                        'max_depth' => $args['max_depth'], 
                                        'reply_text' => __td('Reply', TD_THEME_NAME),
                                        'login_text' =>  __td('Log in to leave a comment', TD_THEME_NAME)
                                        ))) ?> 

                                </div>
                            </footer>
                            <div class="comment-content">
                                <?php comment_text() ?>
                            </div>
                        </article>
                    </li>    
                    

		<?php  
                }
	}
?>
