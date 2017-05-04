function InsertShortcodes() {

    var tagtext;
    var style       = document.getElementById('general');
    var current_tab = jQuery('.tab-titles').find('.current').data("id");

    /*************** General Style Shortcodes ****************/

    if (current_tab =='general') {

        var styleid     = document.getElementById('style_shortcode').value;
        var accentcolor = document.getElementById('style_shortcode').title;

        if (styleid != 0 ) {
            tagtext = "["+ styleid + "]Insert your text here[/" + styleid + "]";
        }

        if (styleid != 0 && styleid=='ht_fancy_title') {
            tagtext = '[ht_fancy_title size="1-6" type="liner, double, doublepress, dotted, dashed, inside_liner, inside_pat, dotted_line, dashed_line, line_line" align="left" color="#444"]Header Title [/ht_fancy_title]';
        }

        if ( styleid != 0 && styleid=='ht_pricing_2col' ){
/*
red, yellow, blue, brown, orange, pink, green, black, grey, magenta
*/
            tagtext = '[ht_pricing_table cols="2"] \
[ht_pricing_col btn_title="Button Title" btn_link="#" title="Title" interval="Per Month" price="99.99" special="no" special_reason=""]\
<ul>\
    <li>24/7 Lorem Ipsum</li>\
    <li>Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li>1GB sit</li>\
    <li>Something amet</li>\
    <li>25 Email Address</li>\
</ul>\
[/ht_pricing_col]\
[ht_pricing_col btn_title="title" btn_link="#" title="Title" interval="Per Month" price="99.99" special="yes" special_reason="Most Popular"]\
<ul>\
    <li>24/7 Lorem Ipsum</li>\
    <li>Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li>1GB sit</li>\
    <li>Something amet</li>\
    <li>25 Email Address</li>\
</ul>\
[/ht_pricing_col]\
[/ht_pricing_table]\
';
        }

        if ( styleid != 0 && styleid=='ht_pricing_3col' ){
/*
red, yellow, blue, brown, orange, pink, green, black, grey, magenta
*/
            tagtext = '[ht_pricing_table cols="3"] [ht_pricing_col btn_title="title" btn_link="#" title="Title" interval="Per Month" price="99.99" special="no" special_reason=""]\
<ul>\
    <li>24/7 Lorem Ipsum</li>\
    <li>Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li>1GB sit</li>\
    <li>Something amet</li>\
    <li>25 Email Address</li>\
</ul>\
[/ht_pricing_col]\
[ht_pricing_col btn_title="title" btn_link="#" title="Title" interval="Per Month" price="99.99" special="yes" special_reason="Most Popular"]\
<ul>\
    <li>24/7 Lorem Ipsum</li>\
    <li>Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li>1GB sit</li>\
    <li>Something amet</li>\
    <li>25 Email Address</li>\
</ul>\
[/ht_pricing_col]\
[ht_pricing_col btn_title="title" btn_link="#" title="Title" interval="Per Month" price="99.99" special="no"]\
<ul>\
    <li>24/7 Lorem Ipsum</li>\
    <li>Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li>1GB sit</li>\
    <li>Something amet</li>\
    <li>25 Email Address</li>\
</ul>\
[/ht_pricing_col]\
[/ht_pricing_table]\
';
        }

        if ( styleid != 0 && styleid=='ht_pricing_4col' ){

            tagtext = '[ht_pricing_table cols="4"] [ht_pricing_col btn_title="title" btn_link="#" title="Title" interval="Per Month" price="99.99" special="no"]\
<ul>\
    <li>24/7 Lorem Ipsum</li>\
    <li>Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li>1GB sit</li>\
    <li>Something amet</li>\
    <li>25 Email Address</li>\
</ul>\
[/ht_pricing_col]\
[ht_pricing_col btn_title="title" btn_link="#" title="Title" interval="Per Month" price="99.99" special="yes" special_reason="Most Popular"]\
<ul>\
    <li>24/7 Lorem Ipsum</li>\
    <li>Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li>1GB sit</li>\
    <li>Something amet</li>\
    <li>25 Email Address</li>\
</ul>\
[/ht_pricing_col]\
[ht_pricing_col btn_title="title" btn_link="#" title="Title" bg_color="green" interval="Per Month" price="99.99" special="no" special_reson=""]\
<ul>\
    <li>24/7 Lorem Ipsum</li>\
    <li>Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li>1GB sit</li>\
    <li>Something amet</li>\
    <li>25 Email Address</li>\
</ul>\
[/ht_pricing_col]\
[ht_pricing_col btn_title="title" btn_link="#" title="Title" bg_color="green" interval="Per Month" price="99.99" special="no"]\
<ul>\
    <li>24/7 Lorem Ipsum</li>\
    <li>Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li>1GB sit</li>\
    <li>Something amet</li>\
    <li>25 Email Address</li>\
</ul>\
[/ht_pricing_col]\
[/ht_pricing_table]\
';
        }

        if (styleid != 0 && styleid == 'ht_tooltip'){
            tagtext = '\
[ht_tooltip trigger="Tooltip Text Goes Here..." ]Lorem Ipsum dolor sit[/ht_tooltip]\
';
        }

        if (styleid != 0 && styleid == 'ht_dashed_list'){
            tagtext = "[ht_list type=\"dashed-list\" decimal=\"yes,no\"]<ul>\r<li>Item #1</li>\r<li>Item #2</li>\r<li>Item #3</li>\r</ul>[/ht_list]";
        }

        if (styleid != 0 && styleid == 'ht_dotted_list'){
            tagtext = "[ht_list type=\"dotted-list\" decimal=\"yes,no\"]<ul>\r<li>Item #1</li>\r<li>Item #2</li>\r<li>Item #3</li>\r</ul>[/ht_list]";
        }

        if (styleid != 0 && styleid == 'ht_line_list'){
            tagtext = "[ht_list type=\"line-list\" decimal=\"yes,no\"]<ul>\r<li>Item #1</li>\r<li>Item #2</li>\r<li>Item #3</li>\r</ul>[/ht_list]";
        }

        if (styleid != 0 && styleid == 'ht_icon_list'){
            tagtext = "[ht_list_icon icon=\"fa-heart\" icon_color=\"custom,accent\" custom_icon_color=\"#FF0088\"]<ul>\r<li>Item #1</li>\r<li>Item #2</li>\r<li>Item #3</li>\r</ul>[/ht_list_icon]";
        }
        
        if (styleid != 0 && styleid == 'ht_video'){
            tagtext = "["+ styleid + " splash_image=\"Path to splash preview image (only for hosted video)\" url=\"Vimeo, youtube, dailymotion \" mp4=\"\" ogv=\"\" webm=\"\" flv=\"\"  /]";
        }

        if (styleid != 0 && styleid == 'ht_highlight' ){
            tagtext = '\
[ht_highlight text_color="#FFF" bg_color="' + accentcolor + '"]Lorem ipsum[/ht_highlight]\
';
        }

        if (styleid != 0 && styleid == 'ht_lightbox'){
            tagtext = "["+ styleid + " type=\"image,video\" big_image_url=\"Insert Bigger Image's URL here\" video_url=\"Insert Video URL here\" align=\"left\"]Insert the Full URL of the image.[/" + styleid + "]";
        }
        if (styleid != 0 && styleid == 'ht_dropcap_with_background' ){
            tagtext = '\
[ht_dropcap type="with-background" color="accent, #333" radius="square, rounded1, rounded2, circular"]A[/ht_dropcap]\
';
        }
        if (styleid != 0 && styleid == 'ht_dropcap_text_only' ){
            tagtext = '\
[ht_dropcap type="text-only" color="accent, #333" radius="square, rounded1, rounded2, circular"]A[/ht_dropcap]\
';
        }
        if (styleid != 0 && styleid == 'ht_dropcap_bordered' ){
            tagtext = '\
[ht_dropcap type="bordered" color="accent, #333" radius="square, rounded1, rounded2, circular"]A[/ht_dropcap]\
';
        }

        if (styleid != 0 && styleid == 'ht_pullquote' ){
            tagtext = "["+ styleid + "]Insert the quote here.[/" + styleid + "]";
        }

        if (styleid != 0 && styleid == 'ht_callout_right' ){
            tagtext = "["+ styleid + "]Insert the quote here.[/" + styleid + "]";
        }

        if (styleid != 0 && styleid == 'ht_callout_left' ){
            tagtext = "["+ styleid + "]Insert the quote here.[/" + styleid + "]";
        }

        if ( styleid == 0 ){
            tinyMCEPopup.close();
        }
    }

    /*************** Icon Shortcode ****************/
    if (current_tab =='icon') {
        var icon_name    = document.getElementById('icon_class').value;
        var color        = document.getElementById('icon_color').value;
        var custom_color = document.getElementById('icon_custom_color').value;
        var tooltip      = document.getElementById('icon_tooltip').value;
        var link         = document.getElementById('icon_link').value;
        var target       = document.getElementById('icon_target').checked;

        if (target == true) target = '_blank'; else target = '_self';
        tagtext = '[ht_icon icon_name="' + icon_name + '" color="' + color + '" custom_color="' + custom_color + '" tooltip="' + tooltip + '" link="' + link + '" target="' + target + '"][/ht_icon]';
    }

    /*************** Button Shortcode ****************/
    if (current_tab =='button') {
        var title        = document.getElementById('button_title').value;
        var color        = document.getElementById('button_color').value;
        var custom_color = document.getElementById('button_custom_color').value;
        var type         = document.getElementById('button_type').value;
        var size         = document.getElementById('button_size').value;
        var icon_name    = document.getElementById('icon_class').value;
        var link         = document.getElementById('button_link').value;
        var target       = document.getElementById('button_target').checked;
        if (target == true) target = '_blank'; else target = '_self';
        tagtext = '[ht_button title="' + title + '" color="' + color + '" custom_color="' + custom_color + '" size="' + size + '" type="' + type + '" icon_name="' + icon_name + '" link="' + link + '" target="' + target + '"][/ht_button]';
    }

    if(window.tinyMCE) {
        tinyMCE.activeEditor.selection.setContent(tagtext);
        tb_remove();
    }
    return;
}