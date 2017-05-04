<?php
if(!class_exists('simple_breadcrumb'))
{
    class simple_breadcrumb
    {
        var $options;

        function simple_breadcrumb($options = ""){

            $this->options = array(
                'before' => '<li>',
                'after' => ' ',
                'delimiter' => ''
            );

            if(is_array($options))
            {
                $this->options = array_merge($this->options, $options);
            }


            $markup = $this->options['before'].$this->options['delimiter'].$this->options['after'];

            global $post;
            echo '<div class="breadcrumbIn">
                    <ul>
                        <li>
                        <a href="'.get_bloginfo('url').'"><i class="icon_house_alt mi"></i> '.__("Home", "highthemes").' </a>
                        </li>';
            if(!is_front_page()){echo $markup;}

            $output = $this->simple_breadcrumb_case($post);
            //echo "<span class='current_crumb'>";
            if ( is_page() || is_single()) {
                the_title();
            }else{
                echo $output;
            }
            echo "</li> </ul></div>";
        }

        function simple_breadcrumb_case($der_post)
        {
            global $post;

            $markup = $this->options['before'].$this->options['delimiter'].$this->options['after'];
            if (is_page()){
                if($der_post->post_parent) {
                    $my_query = get_post($der_post->post_parent);
                    $this->simple_breadcrumb_case($my_query);
                    $link = '<a href="';
                    $link .= get_permalink($my_query->ID);
                    $link .= '">';
                    $link .= ''. get_the_title($my_query->ID) . '</a>'. $markup;
                    echo $link;
                }
                return;
            }

            if(is_single())
            {
                $category = get_the_category();
                if (is_attachment()){

                    $my_query = get_post($der_post->post_parent);
                    $category = get_the_category($my_query->ID);

                    if(isset($category[0]))
                    {
                        $ID = $category[0]->cat_ID;
                        $parents = get_category_parents($ID, TRUE, $markup, FALSE );
                        if(!is_object($parents)) echo $parents;
                        previous_post_link("%link $markup");
                    }

                }else{

                    $postType = get_post_type();

                    if($postType == 'post')
                    {
                        $ID = $category[0]->cat_ID;
                        echo get_category_parents($ID, TRUE, $markup, FALSE );
                    }
                    else if($postType == 'portfolio')
                    {
                        $terms = get_the_term_list( $post->ID, 'portfolio-category', '', '$$$', '' );
                        $terms = explode('$$$',$terms);
                        $term_s = "";
                        $terms_count = count($terms);
                        if($terms_count > 1){
                            for($i=0;$i<$terms_count;$i++){
                                $term_s .= ($i==$terms_count-1)? $terms[$i] : $terms[$i] .", ";

                            }
                            echo $term_s.$markup;

                        } else {
                            echo $terms[0].$markup;
                        }

                    }
                }
                return;
            }

            if(is_tax()){
                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                return $term->name;

            }


            if(is_category()){
                $category = get_the_category();
                $i = $category[0]->cat_ID;
                $parent = $category[0]-> category_parent;

                if($parent > 0 && $category[0]->cat_name == single_cat_title("", false)){
                    echo get_category_parents($parent, TRUE, $markup, FALSE);
                }
                return single_cat_title('',FALSE);
            }


            if(is_author()){
                $curauth = get_user_by('id', get_query_var('author'));
                return __("Author", "highthemes") . ": ".$curauth->nickname;
            }
            if(is_tag()){ return __("Tag", "highthemes") . ": ".single_tag_title('',FALSE); }

            if(is_404()){ return _e("404 - Page not Found",'highthemes'); }

            if(is_search()){ return _e("Search",'highthemes');}

            if(is_year()){ return get_the_time('Y'); }

            if(is_month()){
                $k_year = get_the_time('Y');
                echo "<a href='".get_year_link($k_year)."'>".$k_year."</a>".$markup;
                return get_the_time('F'); }

            if(is_day() || is_time()){
                $k_year = get_the_time('Y');
                $k_month = get_the_time('m');
                $k_month_display = get_the_time('F');
                echo "<a href='".get_year_link($k_year)."'>".$k_year."</a>".$markup;
                echo "<a href='".get_month_link($k_year, $k_month)."'>".$k_month_display."</a>".$markup;

                return get_the_time('jS (l)'); }

        }

    }
}


