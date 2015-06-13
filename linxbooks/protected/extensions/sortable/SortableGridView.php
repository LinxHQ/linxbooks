<?php
Yii::import('zii.widgets.grid.CGridView');
Yii::import('bootstrap.widgets.TbGridView');

/**
 * @author Troy <troytft@gmail.com>
 */
class SortableGridView extends TbGridView//CGridView
{

    public $sortable = true;
    public $itemsCssClass = 'items sortable-items';
    public $template = "{clipboard}\n{items}\n{summary}\n{pager}";
    private $_clipboardData;

    public function initColumns()
    {
        if ($this->sortable === true)
        {
            $exists = false;
            foreach ($this->columns as $column)
                if (isset($column['class']) && $column['class'] == 'ext.sortable.SortableColumn')
                    $exists = true;

            if ($exists === false)
                array_push($this->columns, array('class' => 'ext.sortable.SortableColumn'));
        }

        $this->_generateClipboardData();
        $this->_removeData();

        Yii::app()->clientScript->registerScript("sortable-clipboard", "
            $('.sortable-clipboard-area').sortable({
                connectWith : '.sortable-items tbody'
            });
        ", CClientScript::POS_READY);

        parent::initColumns();
    }


    public function renderClipboard()
    {
        echo '<table class="items" style="margin: 10px 0px;"><tbody class="sortable-clipboard-area"><tr class="sortable-clipboard-label"><td colspan="' . count($this->columns) . '">
        		<center>Drag row to sort</center></td></tr>';

        $oldData = $this->dataProvider->getData(true);
        $data = (array) $this->_clipboardData;
        $this->dataProvider->setData($data);

        foreach ($data as $row => $info)
            $this->renderTableRow($row, $info);

        $this->dataProvider->setData($oldData);
        echo '</tbody></table>';
    }


    /**
     * Remove clipboard data from grid
     */
    private function _removeData()
    {
        $name = 'sortable_' . Yii::app()->controller->route;

        if (Yii::app()->user->hasState($name))
        {
            $ids = Yii::app()->user->getState($name);
            $model = $this->dataProvider->model;
            $criteria = $model->getDbCriteria();
            $criteria->addNotInCondition('id', $ids);
            $this->dataProvider->model->setDbCriteria($criteria);

            $criteria = $this->dataProvider->getCriteria();
            $criteria->addNotInCondition('id', $ids);
            $this->dataProvider->setCriteria($criteria);
        }
    }


    /**
     * Generate clipboard data
     */
    private function _generateClipboardData()
    {
        $name = 'sortable_' . Yii::app()->controller->route;

        if (Yii::app()->user->hasState($name))
        {
            $model = $this->dataProvider->model;
            $criteria = $this->dataProvider->model->getDbCriteria();
            $ids = Yii::app()->user->getState($name);
            $criteria->addInCondition('id', $ids);
            $this->_clipboardData = $model->findAll($criteria);
        }
    }


}
