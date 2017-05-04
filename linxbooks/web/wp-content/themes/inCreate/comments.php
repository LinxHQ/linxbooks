<?php
/**
 * @package WordPress
 */
// Do not delete these lines
    if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        die (__('Please do not load this page directly. Thanks!','highthemes'));

    if ( post_password_required() ) { ?>
        <p class="nocomments"><?php echo __('This post is password protected. Enter the password to view comments.','highthemes');?></p>
    <?php
        return;
    }
?>
<!-- You can start editing here. -->
<?php if ( have_comments() ) : ?>
    <div class="fancy-title">
        <h4 id="comments"><?php comments_number(__('No Comments','highthemes'), __('One Comment','highthemes'), '% '.__('Comments','highthemes') );?></h4>
    </div><!-- .fancy-title  -->
    <div class="navigation">
        <div class="alignleft"><?php previous_comments_link(__(' < Older Comments','highthemes')) ?></div>
        <div class="alignright"><?php next_comments_link(__(' < Newer Comments','highthemes')) ?></div>
    </div><!-- .navigation  -->
    <ul class="showcomments clearfix">
        <?php wp_list_comments(array('avatar_size' => 80, 'callback' => 'custom_comment')); ?>
    </ul><!-- .comment-list  -->
    <?php else : // this is displayed if there are no comments so far ?>

        <?php if ( comments_open() ) : ?>
        <!-- If comments are open, but there are no comments. -->
        <?php else : // comments are closed ?>
        <!-- If comments are closed. -->
        <!--<p class="nocomments">Comments are closed.</p>-->

    <?php endif; ?>
<?php endif; ?>
<?php if ( comments_open() ) : ?>
    <div id="respond" class="clearfix comment-respond">
        <div class="fancy-title">
            <h3 class="col-title">
                <?php comment_form_title( __('Leave a comment','highthemes'), __('Leave a reply','highthemes')  ); ?>
                <span class="cancel-comment-reply">
                    <small><?php cancel_comment_reply_link(__('Cancel reply','highthemes')); ?></small>
                </span>
            </h3>
    </div><!-- .fancy-title  -->

<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
    <p>
        <?php echo __('You must be','highthemes');?> 
        <a href="<?php echo wp_login_url( get_permalink() ); ?>"><?php echo __('logged in','highthemes');?></a> <?php echo __('to post a comment.','highthemes');?>
    </p>
    <br>
<?php else : ?>
    <?php if ( is_user_logged_in() ) : ?>
        <p><?php echo __('Logged in as','highthemes'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php echo __('Log out of this account','highthemes');?>"><?php echo __('Log out','highthemes'); ?> &raquo;</a></p>
        <br>    
    <?php endif; ?>        

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( is_user_logged_in() ) : ?>

<?php else : ?>

<div class="clearfix">
        <div class="clearfix">
            <div class="grid_4 alpha mb">
                <input type="text" placeholder="<?php echo __('Name','highthemes') ?> <?php if ($req) echo "*"; ?>" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
            </div>
            <div class="grid_4 mb">
                <input type="text" placeholder="<?php echo __('Mail','highthemes') ?> <?php if ($req) echo "*"; ?>" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />            
            </div>
            <div class="grid_4 omega mb">
                <input type="text" placeholder="<?php echo __('Website','highthemes') ?> <?php if ($req) echo "*"; ?>" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" />
            </div>
        </div>
</div>

<?php endif; ?>
    <textarea name="comment" rows="8" placeholder="<?php echo __('Your Message','highthemes') ?> <?php if ($req) echo "*"; ?>" required=""></textarea>
    <p class="comment-notes fll">
    <?php echo __('Your email address will not be published. Required fields are marked. <span class="required">*</span>','highthemes'); ?> 
    </p>
    <p>
        <input name="submit" type="submit" class="send-message" value="<?php echo __('Submit Comment','highthemes');?>">
    </p>    
    
<?php comment_id_fields(); ?>

<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>
</div><!-- #respond  -->

<?php endif; // if you delete this the sky will fall on your head ?>