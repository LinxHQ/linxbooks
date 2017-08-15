<?php
$this->widget('bootstrap.widgets.TbGridView', array(
		'id'=>'wiki-template-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'columns'=>array(
				'wiki_page_title',
				/**'wiki_page_content',
                                array(
                                    'name'=>'wiki_page_content',
                                    'type'=>'raw',
                                    'value'=>' ',
                                ),**/
				array(
						'class'=>'CButtonColumn',
				),
		),
));