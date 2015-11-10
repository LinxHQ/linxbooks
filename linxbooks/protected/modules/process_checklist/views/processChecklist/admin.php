<?php
/* @var $this ProcessChecklistController */
/* @var $model ProcessChecklist */
?>

<h1>Process Check List <a href="<?php echo $this->createUrl('create'); ?>" style="text-decoration: none;">+</a></h1>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'process-checklist-grid',
	'dataProvider'=>$model,
        'type' => 'striped bordered condensed',
	'columns'=>array(
                array(
                    'name'=>'pc_name',
                    'type'=>'raw',
                    'value'=>function($data){
                        $link = $this->createUrl('processChecklistDefault/admin',array('pc_id'=>$data->pc_id));
                        return '<a href="'.$link.'">'.$data->pc_name.'</a>';
                    }
                ),
		array(
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'template'=>"{update}{delete}",
                    'htmlOptions'=>array('width'=>'70','style'=>'text-align:center'),
		),
	),
)); ?>
