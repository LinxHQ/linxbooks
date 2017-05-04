<?php
class sidebar_generator {
	
	function sidebar_generator(){
		add_action('init',array(&$this,'init'));
		add_action('admin_menu',array(&$this,'admin_menu'));
		add_action('admin_enqueue_scripts', array(&$this,'admin_enqueue_scripts'));
		add_action('admin_print_scripts', array(&$this,'admin_print_scripts'));
		add_action('wp_ajax_add_sidebar', array(&$this,'add_sidebar') );
		add_action('wp_ajax_remove_sidebar', array(&$this,'remove_sidebar') );
			
	}
	
	function init(){
		//go through each sidebar and register it
	    $sidebars = $this->get_sidebars();

	    if(is_array($sidebars)){
			foreach($sidebars as $sidebar){
				$id = sanitize_title($sidebar);
				$sidebar_class = $this->name_to_class($sidebar);
				register_sidebar(array(
					'name'=>$sidebar,
					'id' => 'ht_'.strtolower($sidebar_class),
                    'before_widget' => '<div id="%1$s" class="widget %2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h3 class="widget-title"><span>',
                    'after_title' => '</span></h3>',
		    	));
			}
		}
	}
	
	function admin_enqueue_scripts() {
		wp_enqueue_script( array( 'sack' ));
	}

	function admin_print_scripts(){
		?>
			<script>
				function add_sidebar( sidebar_name )
				{
					
					var mysack = new sack("<?php echo site_url(); ?>/wp-admin/admin-ajax.php" );    
				
				  	mysack.execute = 1;
				  	mysack.method = 'POST';
				  	mysack.setVar( "action", "add_sidebar" );
				  	mysack.setVar( "sidebar_name", sidebar_name );
				  	mysack.encVar( "cookie", document.cookie, false );
				  	mysack.onError = function() { alert('Ajax error. Cannot add sidebar' )};
				  	mysack.runAJAX();
					return true;
				}
				
				function remove_sidebar( sidebar_name,num )
				{
					
					var mysack = new sack("<?php echo site_url(); ?>/wp-admin/admin-ajax.php" );    
				
				  	mysack.execute = 1;
				  	mysack.method = 'POST';
				  	mysack.setVar( "action", "remove_sidebar" );
				  	mysack.setVar( "sidebar_name", sidebar_name );
				  	mysack.setVar( "row_number", num );
				  	mysack.encVar( "cookie", document.cookie, false );
				  	mysack.onError = function() { alert('Ajax error. Cannot remove sidebar' )};
				  	mysack.runAJAX();
					return true;
				}
			</script>
		<?php
	}
	
	function add_sidebar(){
		$sidebars = $this->get_sidebars();
		$name = str_replace(array("\n","\r","\t"),'',$_POST['sidebar_name']);
		$id = $this->name_to_class($name);
		if(isset($sidebars[$id])){
			die("alert('Sidebar already exists, please use a different name.')");
		}
		
		$sidebars[$id] = $name;
		$this->update_sidebars($sidebars);
		
		$js = "
			var tbl = document.getElementById('sbg_table');
			var lastRow = tbl.rows.length;
			// if there's no header row in the table, then iteration = lastRow + 1
			var iteration = lastRow;
			var row = tbl.insertRow(lastRow);
			row.id = 'hts-$id';
			if(lastRow % 2 != 0) {
				row.setAttribute('class', 'alternate', 0);
			}
			
			// left cell
			var cellLeft = row.insertCell(0);
			var textNode = document.createTextNode('$name');
			cellLeft.appendChild(textNode);
			
			//middle cell
			var cellLeft = row.insertCell(1);
			var textNode = document.createTextNode('$id');
			cellLeft.appendChild(textNode);
			
			//var cellLeft = row.insertCell(2);
			//var textNode = document.createTextNode('[<a href=\'javascript:void(0);\' onclick=\'return remove_sidebar_link($name);\'>Remove</a>]');
			//cellLeft.appendChild(textNode)
			
			var cellLeft = row.insertCell(2);
			removeLink = document.createElement('a');
      		linkText = document.createTextNode('remove');
			removeLink.setAttribute('onclick', 'remove_sidebar_link(\'$name\')');
			removeLink.setAttribute('href', 'javascript:void(0)');
        
      		removeLink.appendChild(linkText);
      		cellLeft.appendChild(removeLink);

			
		";
		
		die( "$js");
	}
	
	function remove_sidebar(){
		$sidebars = $this->get_sidebars();
		$name = str_replace(array("\n","\r","\t"),'',$_POST['sidebar_name']);
		$id = $this->name_to_class($name);
		if(!isset($sidebars[$id])){
			die("alert('Sidebar does not exist.')");
		}
		$row_number = $_POST['row_number'];
		unset($sidebars[$id]);
		$this->update_sidebars($sidebars);
		$js = "
			document.getElementById(\"hts-$id\").remove();
		";
		die($js);
	}
	
	function admin_menu(){
		add_theme_page('Sidebars', 'Sidebars', 'edit_theme_options', 'multiple_sidebars', array(&$this,'admin_page'));
		
}
	
	function admin_page(){
		?>
		<script>
			function remove_sidebar_link(name,num){
				answer = confirm("Are you sure you want to remove " + name + "?\nThis will remove any widgets you have assigned to this sidebar.");
				if(answer){
					//alert('AJAX REMOVE');
					remove_sidebar(name,num);
				}else{
					return false;
				}
			}
			function add_sidebar_link(){
				var sidebar_name = prompt("Sidebar Name:","");
				//alert(sidebar_name);
				add_sidebar(sidebar_name);
			}
		</script>
		<div class="wrap">
			<h2><?php _e("Sidebars", "highthemes"); ?></h2>
			<br />
			<table class="widefat page" id="sbg_table" style="width:600px;">
				<tr>
					<th><?php _e("Sidebar Name", "highthemes"); ?></th>
					<th><?php _e("CSS class", "highthemes"); ?></th>
					<th><?php _e("Remove", "highthemes"); ?></th>
				</tr>
				<?php
				$list_of_sidebars = new sidebar_generator();
				$sidebars = $list_of_sidebars->get_sidebars();
				if(is_array($sidebars) && !empty($sidebars)){
					$cnt=0;
					foreach($sidebars as $sidebar){
						$alt = ($cnt%2 == 0 ? 'alternate' : '');
				?>
				<tr id="hts-<?php echo $list_of_sidebars->name_to_class($sidebar); ?>"  class="<?php echo $alt?>">
					<td><?php echo $sidebar; ?></td>
					<td><?php echo $list_of_sidebars->name_to_class($sidebar); ?></td>
					<td><a href="javascript:void(0);" onclick="return remove_sidebar_link('<?php echo $sidebar; ?>',<?php echo $cnt+1; ?>);" title="Remove this sidebar"><?php _e("Remove", "highthemes"); ?></a></td>
				</tr>
				<?php
						$cnt++;
					}
				}else{
					?>
					<tr>
						<td colspan="3"><?php _e("No Sidebars defined", "highthemes"); ?></td>
					</tr>
					<?php
				}
				?>
			</table><br /><br />
            <div class="add_sidebar">
				<a href="javascript:void(0);" onclick="return add_sidebar_link()" title="<?php _e("Add a sidebar", "highthemes"); ?>" class="button-primary">+ <?php _e("Add New Sidebar", "highthemes"); ?></a>

			</div>
			
		</div>
		<?php
	}
	
	/**
	 * for saving the pages/post
	*/
	function save_form($post_id){
		if(isset($_POST['sbg_edit'])){
			$is_saving = $_POST['sbg_edit'];
			if(!empty($is_saving)){
				delete_post_meta($post_id, '_ht_selected_sidebar');
				add_post_meta($post_id, '_ht_selected_sidebar', $_POST['sidebar_generator']);
			}
		}
	}
	
	function edit_form(){
	    global $post;
	    $post_id = $post;
	    if (is_object($post_id)) {
	    	$post_id = $post_id->ID;
	    }
	    $selected_sidebar = get_post_meta($post_id, '_ht_selected_sidebar', true);
	    if(!is_array($selected_sidebar)){
	    	$tmp = $selected_sidebar; 
	    	$selected_sidebar = array(); 
	    	$selected_sidebar[0] = $tmp;
	    }

		?>
	 
	<div id='sbg-sortables' class='meta-box-sortables'>
		<div id="sbg_box" class="postbox " >
			<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span>Sidebar</span></h3>
			<div class="inside">
				<div class="sbg_container">
					<input name="sbg_edit" type="hidden" value="sbg_edit" />
					
					<p>Please select the sidebar you would like to display on this page. <strong>Note:</strong> You must first create the sidebar under Appearance > Sidebars.
					</p>
					<ul>
					<?php 
					global $wp_registered_sidebars;
					//var_dump($wp_registered_sidebars);		
						for($i=0;$i<1;$i++){ ?>
							<li>
							<select name="sidebar_generator[<?php echo $i?>]" style="display: none;">
								<option value="0"<?php if($selected_sidebar[$i] == ''){ echo " selected";} ?>>WP Default Sidebar</option>
							<?php
							$sidebars = $wp_registered_sidebars;// $this->get_sidebars();
							if(is_array($sidebars) && !empty($sidebars)){
								foreach($sidebars as $sidebar){
									if($selected_sidebar[$i] == $sidebar['name']){
										echo "<option value='{$sidebar['name']}' selected>{$sidebar['name']}</option>\n";
									}else{
										echo "<option value='{$sidebar['name']}'>{$sidebar['name']}</option>\n";
									}
								}
							}
							?>
							</select>
							<select name="sidebar_generator_replacement[<?php echo $i?>]">
								<option value="0"<?php if($selected_sidebar_replacement[$i] == ''){ echo " selected";} ?>>None</option>
							<?php
							
							$sidebar_replacements = $wp_registered_sidebars;//$this->get_sidebars();
							if(is_array($sidebar_replacements) && !empty($sidebar_replacements)){
								foreach($sidebar_replacements as $sidebar){
									if($selected_sidebar_replacement[$i] == $sidebar['name']){
										echo "<option value='{$sidebar['name']}' selected>{$sidebar['name']}</option>\n";
									}else{
										echo "<option value='{$sidebar['name']}'>{$sidebar['name']}</option>\n";
									}
								}
							}
							?>
							</select> 
							
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>

		<?php
	}
	
	/**
	 * called by the action get_sidebar. this is what places this into the theme
	*/
	public static function get_sidebar($name="0"){

		if( is_woocommerce_activated() ) {
			if( is_shop() ) {
				$post             = get_post( woocommerce_get_page_id( 'shop' ) );
				$selected_sidebar = get_post_meta( $post->ID, '_ht_selected_sidebar', true);
				if($selected_sidebar != '' && $selected_sidebar != "0" && $selected_sidebar !='default-sidebar'){
					dynamic_sidebar('ht_'.$selected_sidebar);
				} else {
					dynamic_sidebar('shop-sidebar');
				}
				return;
			}
		}


		if( !is_singular() ) {
			if( $name != "0" ) {
				dynamic_sidebar($name);
			}else{
				dynamic_sidebar('default-sidebar');
			}

			return;
		}

		wp_reset_query();
		global $wp_query;
		$post = $wp_query->get_queried_object();
        if (isset($post->ID)) {
            $selected_sidebar = get_post_meta($post->ID, '_ht_selected_sidebar', true);
        } else {
            $selected_sidebar = "";
        }		
		$did_sidebar = false;

		//this page uses a generated sidebar
		if($selected_sidebar != '' && $selected_sidebar != "0" && $selected_sidebar !='default-sidebar'){
			if($name != "0"){
				dynamic_sidebar('ht_'.$selected_sidebar);
			}else{
				dynamic_sidebar('default-sidebar');
			}
			return;			
		}else{
			if($name != "0"){
				dynamic_sidebar($name);
			}else{
				dynamic_sidebar('default-sidebar');
			}
		}
	}
	
	/**
	 * replaces array of sidebar names
	*/
	function update_sidebars($sidebar_array){
		$sidebars = update_option('sbg_sidebars',$sidebar_array);
	}	
	
	/**
	 * gets the generated sidebars
	*/
	public static function get_sidebars(){
		$sidebars = get_option('sbg_sidebars');
		return $sidebars;
	}
	function name_to_class($name){
		return sanitize_title($name);
	}
	
}
$sbg = new sidebar_generator;

function ht_generated_dynamic_sidebar($name='0'){
	global $sbg;
	$sbg->get_sidebar($name);
	return true;
}
?>