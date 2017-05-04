<?php
    $post_format      = get_post_format();
    $post_format_icon = '';
    $blog_layout      =  get_post_meta( get_the_ID(), '_ht_blog_layout', true );

    switch ($post_format) {
        case 'video':
            $post_format_icon = 'icon_film';
            break;

        case 'audio':
            $post_format_icon = 'icon_headphones';
            break;

        case 'link':
            $post_format_icon = 'icon_link';
            $ex_link   = get_post_meta($post->ID, '_ht_link_post_format', TRUE);
            $permalink = ( !empty($ex_link) ) ? $ex_link :  get_permalink();

            break;

        case 'quote':
            $post_format_icon = 'icon_quotations';
            break;

        case '':
            $post_format_icon = 'icon_pencil';
            break;

        default:
            $post_format_icon = 'icon_pencil';
            break;
    }
?>
<div class="meta_box">
    <div class="post_format"><i class="<?php echo $post_format_icon;?>"></i></div>
    <h3> <a title="<?php the_title_attribute();?>" href="<?php if(!empty($permalink)) echo $permalink ;else the_permalink();?>"><?php the_title();?></a></h3>
    <div class="post_meta">
        <span><i class="icon_profile"></i> <?php the_author_posts_link(); ?></span>
        <span><i class="icon_clock_alt"></i> <?php the_time(get_option('date_format'));?></span>
        <span class="post_category"><i class="icon_link_alt"></i> <?php _e("in", "highthemes");?> <?php the_category(", ");?></span>
        <span class="post_comments"> <a href="<?php the_permalink();?>#comments"><i class="icon_comment_alt"></i> <?php comments_number( __('0', 'highthemes'),  __('1', 'highthemes'),  __('%', 'highthemes') ); ?></a></span>
    </div><!-- meta more -->
</div><!-- meta box -->