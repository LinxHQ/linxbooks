<div class="search-box">
    <form method="get" action="<?php echo home_url(); ?>/">
        <fieldset>
        	<button type="submit"><i class="fa-search"></i></button>
            <input type="text" size="15" class="search-field" name="s" id="s" value="<?php _e('Search...','highthemes'); ?>" onfocus="if(this.value == '<?php _e('Search...','highthemes'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Search...','highthemes'); ?>';}"/>
        </fieldset>
    </form>
</div><!-- .search-box -->