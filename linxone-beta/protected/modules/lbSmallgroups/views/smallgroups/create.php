<?php
/* @var $this SmallgroupsController */
/* @var $model LbSmallGroups */
?>
<?php 
	echo '<div id="lb-container-header">';
        echo '<div class="lb-header-right"><h3>'.Yii::t("lang","Small Groups - Create").'</h3></div>';
        echo '<div class="lb-header-left lb-header-left-small-group">';
	        echo '<div id="lb_invoice" class="btn-toolbar" style="margin-top:2px;" >';
	        	?>
			    <div class="input-append">
			    	<a live="false"  href="<?php echo $this->createUrl('/lbSmallgroups/smallgroups/create'); ?>"><i style="margin-top: -9px;margin-right: 10px;" class="icon-plus"></i> </a>
			      <input type="text" placeholder="Enter leader's name..." value="" style="width: 250px;">
			      <div class="btn-group">
			        <button class="btn dropdown-toggle" data-toggle="dropdown">
			          Location
			          <span class="caret"></span>
			        </button>
			        <ul class="dropdown-menu" style="min-width: 100px !important;">
                        <li><a href="#">All</a></li>
                        <?php
                        $small_group_arr=LbSmallGroups::model()->findAll(array(
                            'select'=>'t.lb_group_location',
                            'distinct'=>true,
                        ));
                        foreach ($small_group_arr as $result_small_group_arr) {
                            echo '<li><a href="#">'.$result_small_group_arr['lb_group_location'].'</a></li>';
                        }
                        ?>
	                </ul>
			      </div>
			    </div>
	        	<?php
	        echo '</div>';
        echo '</div>';
	echo '</div>';
 ?>

<div class="lb-empty-15"></div>
<div id="advanced_search" style="width: 100%;height: 30px; display: inline-flex; /*border: 1px solid red;*/">
	<div id="left" style="width: 50%; padding: 5px;">
		<i class="icon-search"></i> Advanced Search
	</div>
	<div id="right" style="width: 50%; padding: 5px;">
		<p style="float: right;"><i class="icon-download-alt"></i> Excel <i class="icon-download-alt"></i> PDF</p>
	</div>
</div>
<div class="lb-empty-15"></div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>