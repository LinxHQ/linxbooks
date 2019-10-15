<?php
/* @var $this CategoryController */
/* @var $model LbCatalogCategories */

$this->breadcrumbs=array(
	'Lb Catalog Categories'=>array('index'),
	'Create',
);

echo '<div id="lb-view-header" style="margin: -20px -20px 17px; padding: 4px 20px;">';
echo '<div class="lb-right-header" ><h3><a href="'.LbInvoice::model()->getActionURLNormalized("dashboard").'" style="color: #fff !important;">'.Yii::t('lang','Create Category').'</a></h3></div>';
echo '<div class="lb-header-left" >';
echo LBApplicationUI::backButton(LbCatalogCategories::model()->getActionURLNormalized('category/admin'));
echo '</div>';
echo '</div>';

?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>