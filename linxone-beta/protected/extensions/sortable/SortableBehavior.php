<?php

/**
 * @author Troy <troytft@gmail.com>
 */
class SortableBehavior extends CActiveRecordBehavior
{

    /**
     * @var string  Field to store sorting
     */
    public $column = 'sort';

    public function beforeFind($event)
    {
        $criteria = $this->owner->getDbCriteria();
        if (!$criteria->order)
            $criteria->order = "`{$this->column}` DESC";

        parent::beforeFind($event);
    }


    public function beforeSave($event)
    {
        $model = $this->getOwner();
        $column = $this->column;
        if ($model->isNewRecord)
            $model->$column = Yii::app()->db->createCommand("SELECT MAX({$this->column}) FROM " . $model->tableName())->queryScalar() + 1;

        parent::beforeSave($event);
    }


    public function savePositions($ids, $start)
    {
        $priorities = array();
        foreach ($ids as $id)
            $priorities[$id] = $start--;

        Yii::app()->db->createCommand("UPDATE " . $this->getOwner()->tableName() . " SET {$this->column} = " . $this->_generateCase($priorities) . " WHERE wiki_page_id IN(" . implode(', ', $ids) . ")")->execute();
    }


    /**
     * Prepare table
     */
    public function prepareTable()
    {
        Yii::app()->db->createCommand("UPDATE " . $this->getOwner()->tableName() . " SET {$this->column} = wiki_page_id")->execute();
    }


    private function _generateCase($priorities)
    {
        $result = 'CASE `wiki_page_id`';
        foreach ($priorities as $k => $v)
            $result .= ' when "' . $k . '" then "' . $v . '"';
        return $result . ' END';
    }


}
