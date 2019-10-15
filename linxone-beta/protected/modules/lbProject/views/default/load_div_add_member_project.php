<?php 

	echo "
		<div style='width: 300px; border: 1px solid #CCCCCC; padding: 10px; border-radius: 5px; margin-top: 10px;'>";
			echo '<strong>'.YII::t('lang','Project Manager').':</strong> ';
			echo '<div style="display: inline">';
            $this->widget('editable.EditableField', array(
                'type' => 'checklist',
                'model' => $model,
                'attribute' => 'project_id',
                'placement' => 'right',
                'emptytext' => YII::t('lang','Update'),
                'params' => array('ajax_id' => 'bootstrap-x-editable'),
                'options' => array(),
            ));
            echo '</div>';
            echo "<hr />";
			echo '<strong>'.YII::t('lang','Project Member').':</strong> ';
			echo '<div style="display: inline">';
            $this->widget('editable.EditableField', array(
                'type' => 'checklist',
                'model' => $model,
                'attribute' => 'project_id',
                'placement' => 'right',
                'emptytext' => YII::t('lang','Update'),
                'params' => array('ajax_id' => 'bootstrap-x-editable'),
                'options' => array(),
            ));
    echo "</div>";
?>