<?php
/* @var $this ProductsController */
/* @var $model LbCatalogProducts */
/* @var $form CActiveForm */
$categories = new LbCatalogCategories();
?>

<div class="wide form"id="search-form" >
    <form  class="form-inline" action="<?php echo Yii::app()->createUrl($this->route); ?>">
            <div class="input-prepend input-append">
                <?php echo $categories->menuSelectPage(0, "","", "id='search-category' name ='search-category' multiple='multiple'",true); ?>
                <input type="text" name="LbCatalogProducts[lb_product_name]" id="LbCatalogProducts_lb_product_name" placeholder="<?php echo Yii::t('lang','Enter product name to search');?>" style="width: 300px;">
                <button class="btn" type="submit"><?php echo Yii::t('lang','Search'); ?></button>
                <a href="<?php echo LbCatalogProducts::model()->getActionURLNormalized("product/create")?>" class="btn" type="button"><i class="icon-plus"></i> <?php echo Yii::t('lang','Product'); ?></a>
                <a href="<?php echo LbCatalogProducts::model()->getActionURLNormalized("category/create")?>" class="btn" type="button"><i class="icon-plus"></i> <?php echo Yii::t('lang','Category'); ?></a>
            </div>
      </form>
</div><!-- search-form -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#search-category').treeselect({
            buttontext:'<?php echo YII::t("app","Select category"); ?>'
        });
    })
</script>