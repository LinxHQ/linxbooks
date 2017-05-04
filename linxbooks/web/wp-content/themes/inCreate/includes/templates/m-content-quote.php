<?php global $ht_options; ?>
<div <?php post_class('clearfix post'); ?>>
    <?php get_template_part('includes/templates/content-meta');?>
    <div class="blockquote-post">
        <i class="icon-quote-left icon-4x pull-left icon-muted"></i>
        <blockquote><?php the_content() ;?></blockquote>
        <?php
            $quote_caption = get_post_meta( get_the_ID(), '_ht_format_quote_source_name', true );
            $quote_url     = get_post_meta( get_the_ID(), '_ht_format_quote_source_url', true );

            if ( '' !== $quote_caption && '' !== $quote_url )
                $quote_caption = sprintf( "<a href=\"%s\">&mdash;&nbsp;%s</a>",
                    esc_url( $quote_url ),
                    esc_html( $quote_caption )
                );

            if ( '' !== $quote_caption )
                echo '<span class="quote-caption">' . $quote_caption . '</span>';
        ?>        
    </div>    
</div><!-- .post -->