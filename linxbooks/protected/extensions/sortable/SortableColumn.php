<?php

/**
 * @author Troy <troytft@gmail.com>
 */
class SortableColumn extends CDataColumn
{

    public $name = 'sort';
    public $value = '';
    public $url = null;
    public $filter = false;
    private $_assetsPath;

    public function init()
    {
        if ($this->url == null)
            $this->url = Yii::app()->getBaseUrl() . '/index.php/' . preg_replace('#' . Yii::app()->controller->action->id . '$#', 'sortable', Yii::app()->controller->route);
        $this->registerScripts();

        parent::init();
    }


    public function registerScripts()
    {
        $name = "sortable_" . Yii::app()->controller->route;
        $id = $this->grid->getId();
        $this->_assetsPath = Yii::app()->assetManager->publish(dirname(__FILE__) . '/assets');
        $cs = Yii::app()->clientScript;
        $cs->registerCssFile($this->_assetsPath . '/styles.css');
        $cs->registerCoreScript('jqueryui');
        $cs->registerScript("sortable-grid-{$id}", "
            $('#{$id} .sortable-items tbody').sortable({
                connectWith: '.sortable-clipboard-area',
                axis : 'y',
                update : function (event, ui) {
                    var ids = [];
                    $('#{$id} .sortable-items .sortable-column').each(function(i) {
                        ids[i] = $(this).data('id');
                    });

                    var clipboard = [];
                    $('.sortable-clipboard-area .sortable-column').each(function(i) {
                        clipboard[i] = $(this).data('id');
                    });

                    $.ajax({
                        url : '{$this->url}',
                        type : 'POST',
                        data : ({'ids' : ids, 'clipboard' : clipboard, 'name' : '{$name}'}),
                    });
                }
            });", CClientScript::POS_READY);
    }


    public function renderDataCellContent($row, $data)
    {
        echo CHtml::image($this->_assetsPath . '/icon.png', '', array('class' => 'sortable-column-handler', 'style' => 'cursor: move;'));
    }


    public function renderDataCell($row)
    {
        $data = $this->grid->dataProvider->data[$row];
        $options = $this->htmlOptions;
        $options['class'] = 'sortable-column';
        $options['data-id'] = $data->primaryKey;
        echo CHtml::openTag('td', $options);
        $this->renderDataCellContent($row, $data);
        echo CHtml::closeTag('td');
    }


}
