<?php
if(!$outputTemplates){
	$limit = (@intval($_GET['limit']) > 0) ? @intval($_GET['limit']) : 10;
	$otype = 'reg';
}else{
	$limit = (@intval($_GET['limit_t']) > 0) ? @intval($_GET['limit_t']) : 10;
	$otype = 'temp';
}

//$limit = 10; // number of rows in page
$total = 0;

if(!$no_sliders){
?>
	<table class='wp-list-table widefat fixed unite_table_items'>
		<thead>
			<tr>
				<th width='20px'><?php _e("ID",REVSLIDER_TEXTDOMAIN)?></th>
				<th width='25%'><?php _e("Name",REVSLIDER_TEXTDOMAIN)?> <a href="?page=revslider&order=asc&ot=name&type=<?php echo $otype; ?>" class="eg-icon-down-dir"></a> <a href="?page=revslider&order=desc&ot=name&type=<?php echo $otype; ?>" class="eg-icon-up-dir"></a></th>
				<?php
				if(!$outputTemplates){
				?>
				<th width='120px'><?php _e("Shortcode",REVSLIDER_TEXTDOMAIN)?> <a href="?page=revslider&order=asc&ot=alias&type=<?php echo $otype; ?>" class="eg-icon-down-dir"></a> <a href="?page=revslider&order=desc&ot=alias&type=<?php echo $otype; ?>" class="eg-icon-up-dir"></a></th>
				<?php }else{
				?><th width='120px'></th><?php
				} ?>
				<th width='100'><?php _e("Source",REVSLIDER_TEXTDOMAIN)?></th>
				<th width='70px'><?php _e("N. Slides",REVSLIDER_TEXTDOMAIN)?></th>						
				<th width='50%'><?php _e("Actions",REVSLIDER_TEXTDOMAIN)?> </th>
			</tr>
		</thead>
		<tbody>
			<?php
			if($outputTemplates){
				$useSliders = $arrSlidersTemplates;
				$pagenum = isset( $_GET['pagenumt'] ) ? absint( $_GET['pagenumt'] ) : 1;
				$offset = ( $pagenum - 1 ) * $limit;
			}else{
				$useSliders = $arrSliders;
				$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
				$offset = ( $pagenum - 1 ) * $limit;
			}
			
			$cur_offset = 0;
			foreach($useSliders as $slider){
				$total++;
				$cur_offset++;
				if($cur_offset <= $offset) continue; //if we are lower then the offset, continue;
				if($cur_offset > $limit + $offset) continue; // if we are higher then the limit + offset, continue
				
				try{
					
					$id = $slider->getID();
					$showTitle = $slider->getShowTitle();
					$title = $slider->getTitle();
					$alias = $slider->getAlias();
					$isFromPosts = $slider->isSlidesFromPosts();
					$strSource = __("Gallery",REVSLIDER_TEXTDOMAIN);
					$preicon = "revicon-picture-1";
					
					if($outputTemplates) $strSource = "Template";
					if ($strSource=="Template") $preicon ="templateicon";
					
					$rowClass = "";					
					if($isFromPosts == true){
						$strSource = __("Posts",REVSLIDER_TEXTDOMAIN);
						$preicon ="revicon-doc";
						$rowClass = "class='row_alt'";
					}
					
					if($outputTemplates){
						$editLink = self::getViewUrl(RevSliderAdmin::VIEW_SLIDER_TEMPLATE,"id=$id");
					}else{
						$editLink = self::getViewUrl(RevSliderAdmin::VIEW_SLIDER,"id=$id");
					}
					$editSlidesLink = self::getViewUrl(RevSliderAdmin::VIEW_SLIDES,"id=$id");
					
					$showTitle = UniteFunctionsRev::getHtmlLink($editLink, $showTitle);
					
					$shortCode = $slider->getShortcode();
					$numSlides = $slider->getNumSlides();
					
					
				}catch(Exception $e){					
					$errorMessage = "ERROR: ".$e->getMessage();
					$strSource = "";
					$numSlides = "";
				}
				
				?>
				<tr <?php echo $rowClass?>>
					<td><?php echo $id?><span id="slider_title_<?php echo $id?>" class="hidden"><?php echo $title?></span></td>								
					<td>
						<?php echo $showTitle?>
						<?php if(!empty($errorMessage)):?>
							<div class='error_message'><?php echo $errorMessage?></div>
						<?php endif?>
					</td>
					<?php
					if(!$outputTemplates){
					?>
					<td><?php echo $shortCode?></td>
					<?php }else{ ?><td></td><?php } ?>
					<td><?php echo "<i class=".$preicon."></i>".$strSource?></td>
					<td><?php echo $numSlides?></td>
					<td>
						<a class="button-primary revgreen" href='<?php echo $editLink ?>' title=""><i class="revicon-cog"></i><?php _e("Settings",REVSLIDER_TEXTDOMAIN)?></a>
						<a class="button-primary revblue" href='<?php echo $editSlidesLink ?>' title=""><i class="revicon-pencil-1"></i><?php _e("Edit Slides",REVSLIDER_TEXTDOMAIN)?></a>
						<a class="button-primary revcarrot export_slider_overview" id="export_slider_<?php echo $id?>" href="javascript:void(0);" title=""><i class="revicon-export"></i><?php _e("Export Slider",REVSLIDER_TEXTDOMAIN)?></a>
						<?php
						$generalSettings = self::getSettings("general");
						$show_dev_export = $generalSettings->getSettingValue("show_dev_export",'off');
						if($show_dev_export == 'on'){
							?>
							<a class="button-primary revpurple export_slider_standalone" id="export_slider_standalone_<?php echo $id?>" href="javascript:void(0);" title=""><i class="revicon-export"></i><?php _e("HTML &LT;/&GT;",REVSLIDER_TEXTDOMAIN)?></a>
							<?php
						}
						?>
						<a class="button-primary revred button_delete_slider"id="button_delete_<?php echo $id?>" href='javascript:void(0)' title="<?php _e("Delete",REVSLIDER_TEXTDOMAIN)?>"><i class="revicon-trash"></i></a>
						<a class="button-primary revyellow button_duplicate_slider" id="button_duplicate_<?php echo $id?>" href='javascript:void(0)' title="<?php _e("Duplicate",REVSLIDER_TEXTDOMAIN)?>"><i class="revicon-picture"></i></a>
						<div id="button_preview_<?php echo $id?>" class="button_slider_preview button-primary revgray" title="<?php _e("Preview",REVSLIDER_TEXTDOMAIN)?>"><i class="revicon-search-1"></i></div>
					</td>
	
				</tr>							
				<?php
			}
			?>
			
		</tbody>		 
	</table>
<?php
}
?>	
	<p>
		<div style="float: left;">
			<?php
			if($outputTemplates){
				?>
				<a class='button-primary revblue' href='<?php echo $addNewTemplateLink?>'><?php _e("Create New Template Slider",REVSLIDER_TEXTDOMAIN)?> </a>
				<?php
			}else{
				?>		
				<a class='button-primary revblue' href='<?php echo $addNewLink?>'><?php _e("Create New Slider",REVSLIDER_TEXTDOMAIN)?> </a>
				<?php
			}
			?>
		</div>
		<?php
		if(!$no_sliders){		
			$num_of_pages = ceil( $total / $limit );
			
			if($outputTemplates)
				$param = 'pagenumt';
			else
				$param = 'pagenum';
			
			
			$page_links = paginate_links( array(
				'base' => add_query_arg( $param, '%#%' ),
				'format' => '',
				'add_args' => array('limit' => $limit),
				'prev_text' => __( '&laquo;', REVSLIDER_TEXTDOMAIN ),
				'next_text' => __( '&raquo;', REVSLIDER_TEXTDOMAIN ),
				'total' => $num_of_pages,
				'current' => $pagenum
			) );

			if ( $page_links ) {
				echo '<div class="rev-pagination-wrap"><div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div></div>';
			}
			
			
			if(!$outputTemplates){
				?>
				<form style="float:left; margin-left:10px" action="?page=revslider&pagenum=1" method="GET">
					<input type="hidden" name="page" value="revslider" />
					<input type="hidden" name="pagenum" value="1" />
					<select name="limit" onchange="this.form.submit()">
						<option <?php echo ($limit == 10) ? 'selected="selected"' : ''; ?> value="10">10</option>
						<option <?php echo ($limit == 25) ? 'selected="selected"' : ''; ?> value="25">25</option>
						<option <?php echo ($limit == 50) ? 'selected="selected"' : ''; ?> value="50">50</option>
						<option <?php echo ($limit == 9999) ? 'selected="selected"' : ''; ?> value="9999"><?php _e('All'); ?></option>
					</select>
				</form>
				<?php
			}else{
				?>
				<form style="float:left; margin-left:10px" action="?page=revslider&pagenumt=1">
					<select name="limit" onchange="this.form.submit()">
						<option <?php echo ($limit == 10) ? 'selected="selected"' : ''; ?> value="10">10</option>
						<option <?php echo ($limit == 25) ? 'selected="selected"' : ''; ?> value="25">25</option>
						<option <?php echo ($limit == 50) ? 'selected="selected"' : ''; ?> value="50">50</option>
						<option <?php echo ($limit == 9999) ? 'selected="selected"' : ''; ?> value="9999"><?php _e('All'); ?></option>
					</select>
				</form>
				<?php
			}
			
		}		
		if(!$outputTemplates){
			?>
			<div style="float: right;"><a id="button_import_slider" class='button-primary float_right revgreen' href='javascript:void(0)'><?php _e("Import Slider",REVSLIDER_TEXTDOMAIN)?> </a></div>
			<?php
		}
		?>
		<div style="clear:both; height:10px"></div>
	</p>
	<?php require_once self::getPathTemplate("dialog_preview_slider");?>


	