<?php

/**
 * This is the model class for table "lb_catalog_categories".
 *
 * The followings are the available columns in table 'lb_catalog_categories':
 * @property integer $lb_record_primary_key
 * @property string $lb_category_name
 * @property string $lb_category_description
 * @property integer $lb_category_status
 * @property string $lb_category_created_date
 * @property integer $lb_category_created_by
 * @property integer $lb_category_parent
 */
class LbCatalogCategories extends CLBActiveRecord
{
    var $module_name = 'lbCatalog';
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_catalog_categories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lb_category_name, lb_category_created_date, lb_category_created_by', 'required'),
			array('lb_category_status, lb_category_created_by, lb_category_parent', 'numerical', 'integerOnly'=>true),
			array('lb_category_name', 'length', 'max'=>100),
			array('lb_category_description', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, lb_category_name, lb_category_description, lb_category_status, lb_category_created_date, lb_category_created_by, lb_category_parent', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lb_record_primary_key' => 'Lb Record Primary Key',
			'lb_category_name' => Yii::t('lang','Name'),
			'lb_category_description' => Yii::t('lang','Description'),
			'lb_category_status' => Yii::t('lang','Status'),
			'lb_category_created_date' => Yii::t('lang','Created Date'),
			'lb_category_created_by' => Yii::t('lang','Created By'),
			'lb_category_parent' => Yii::t('lang','Parent'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search($user_id=false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lb_record_primary_key',$this->lb_record_primary_key);
		$criteria->compare('lb_category_name',$this->lb_category_name,true);
		$criteria->compare('lb_category_description',$this->lb_category_description,true);
		$criteria->compare('lb_category_status',$this->lb_category_status);
		$criteria->compare('lb_category_created_date',$this->lb_category_created_date,true);
		$criteria->compare('lb_category_created_by',$this->lb_category_created_by);
		$criteria->compare('lb_category_parent',$this->lb_category_parent);

		$dataProvider = $this->getFullRecordsDataProvider($criteria,null,20,$user_id);
                
                return $dataProvider;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LbCatalogCategories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
/**
     * MENU đệ quy lấy theo select
     * @param type $menus
     * @param type $parrent
     */
    public function menuSelectPage($parrent = 0,$space="",$selected_id="",$event="",$tree=false) 
    {
        $pages=$this->model()->search()->data;
        
        $select='<select '.$event.' id="LbCatalogCategories_lb_category_parent" name="LbCatalogCategories[lb_category_parent]" >';
            if(!$tree)
                $select.='<option value="0">Select category</option>' ;
            $select.=$this->SelectOptions($pages,$parrent,$space,$selected_id,0,$tree);
        $select.='</select>';
        return $select;
    }
    
    public function SelectOptions($array,$parrent = 0,$space="",$selected_id="",$root_parent=0,$tree) 
    {
        $option="";$selected="";
        foreach ($array as $item) 
        {
            if ($item->lb_category_parent == $parrent) 
            {
                $data_parent = "";
                if($root_parent!=0)
                    $data_parent = 'data-parent='.$root_parent;
                if($selected_id == $item->lb_record_primary_key)
                    $selected = "selected";
                $pages=$this->model()->findAll('lb_category_parent='.intval($item->lb_record_primary_key));
                $option.='<option value="'.$item->lb_record_primary_key.'" '.$selected.' '.$data_parent.'>';
                    if($tree)
                        $option.=$item->lb_category_name;
                    else
                        $option.=$space.' '.$item->lb_category_name;
                $option.='</option>';
                $option.=$this->SelectOptions($pages, $item->lb_record_primary_key,$space.'--',$selected_id,$root_parent+1,$tree);
            }
            
        }
        return $option;
    }
    
/**
     * MENU đệ quy lấy theo ul
     * @param type $menus
     * @param type $parrent
     */
    public function menuUlCategory($parrent = 0,$checked_id_arr=false) 
    {
        $pages=new LbCatalogCategories('search');
	$pages->unsetAttributes();  // clear any default values
        $pages->lb_category_parent = $parrent;
        $select='<ul>';
        foreach ($pages->search()->data as $item) 
        {
                $checked="";
                if(in_array($item->lb_record_primary_key, $checked_id_arr))
                    $checked = "checked";
                $select.='<li>';
                    $select.='<input type="checkbox" name="category[]" value="'.$item->lb_record_primary_key.'" '.$checked.' > '.$item->lb_category_name;
                    $select.=$this->menuUlCategory($item->lb_record_primary_key,$checked_id_arr);
                $select.='</li>';
        }
        $select.='</ul>';
        return $select;
    }
    
    public function UlliCategoty($array,$parrent = 0,$checked_id_arr=false) 
    {
        if(!$checked_id_arr)
            $checked_id_arr  = array();
            $option = "";
            if($parrent!=0)
                $option='<ul>';
            foreach ($array as $item) 
            {
                if ($item->lb_category_parent == $parrent) 
                {
                    $checked="";
                    if(in_array($item->lb_record_primary_key, $checked_id_arr))
                        $checked = "checked";
                    $pages=$this->model()->findAll('lb_category_parent='.intval($item->lb_record_primary_key));
                    $option.='<li>';
                        $option.='<input type="checkbox" name="category[]" value="'.$item->lb_record_primary_key.'" '.$checked.' > '.$item->lb_category_name;
                    $option.='</li>';
                    $option.=$this->UlliCategoty($pages, $item->lb_record_primary_key,$checked_id_arr);
                }
            }
            $option.="</ul>";
        return $option;
    }
    
    public function isCanDetete(){
        $product = LbCatalogCategoryProduct::model()->findAll('lb_category_id='.intval($this->lb_record_primary_key));
        if(count($product)>0)
            return false;
        return true;
    }
    
    public function delete() {
        $result = false;
        if($this->isCanDetete())
            $result = parent::delete();
        return $result;
    }

}
