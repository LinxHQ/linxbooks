<?php

/**
 * This is the model class for table "wiki_page_revisions".
 *
 * The followings are the available columns in table 'wiki_page_revisions':
 * @property integer $wiki_page_revision_id
 * @property integer $wiki_page_id
 * @property string $wiki_page_revision_content
 * @property string $wiki_page_revision_date
 * @property integer $wiki_page_revision_updated_by
 */
class WikiPageRevision extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WikiPageRevision the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_project_wiki_page_revisions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wiki_page_id, wiki_page_revision_content, wiki_page_revision_date, wiki_page_revision_updated_by', 'required'),
			array('wiki_page_id, wiki_page_revision_updated_by', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('wiki_page_revision_id, wiki_page_id, wiki_page_revision_content, wiki_page_revision_date, wiki_page_revision_updated_by', 'safe', 'on'=>'search'),
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
			'wiki_page_revision_id' => 'Wiki Page Revision',
			'wiki_page_id' => 'Wiki Page',
			'wiki_page_revision_content' => 'Wiki Page Revision Content',
			'wiki_page_revision_date' => 'Wiki Page Revision Date',
			'wiki_page_revision_updated_by' => 'Wiki Page Revision Updated By',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('wiki_page_revision_id',$this->wiki_page_revision_id);
		$criteria->compare('wiki_page_id',$this->wiki_page_id);
		$criteria->compare('wiki_page_revision_content',$this->wiki_page_revision_content,true);
		$criteria->compare('wiki_page_revision_date',$this->wiki_page_revision_date,true);
		$criteria->compare('wiki_page_revision_updated_by',$this->wiki_page_revision_updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Get revisions of a wiki page
	 * @param integer $wiki_page_id
	 * @param boolean $get_data default to false to return DataProvider, true to return array of Models
	 * @return CActiveDataProvider or Array
	 */
	public function getRevisions($wiki_page_id, $get_data = false)
	{
		$this->unsetAttributes();
		$this->wiki_page_id = $wiki_page_id;
		
		$criteria=new CDbCriteria;		
		$criteria->compare('wiki_page_id',$this->wiki_page_id);
		$criteria->order = 'wiki_page_revision_date DESC';
		
		$dataProvider = new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
		
		// return array of models
		if ($get_data)
		{
			$dataProvider->setPagination(false);
			return $dataProvider->getData();
		}
		
		// return DP
		return $dataProvider;
	}
	
	/**
	 * Restore this revision to the current page.
	 * 
	 * @param number $wiki_page_revision_id
	 */
	public function restore($wiki_page_revision_id = 0)
	{
		// load this revision
		$model = $this;
		if ($wiki_page_revision_id > 0)
		{
			$model = WikiPageRevision::model()->findByPk($wiki_page_revision_id);
		}
		
		// load its latest page (ie the current wiki page)
		$currentWikiPage = WikiPage::model()->findByPk($model->wiki_page_id);
		// get content of current wiki page
		$current_content = $currentWikiPage->wiki_page_content;
		
		// add that content as new revision
		$newRevision = new WikiPageRevision();
		$newRevision->wiki_page_revision_content = $current_content;
		$newRevision->wiki_page_revision_date = date('Y-m-d H:i:s');
		$newRevision->wiki_page_id = $currentWikiPage->wiki_page_id;
		$newRevision->wiki_page_revision_updated_by = $currentWikiPage->wiki_page_creator_id;
		if ($newRevision->save())
		{
			// update current page with this revision's (the rev to be restored) content.
			$currentWikiPage->wiki_page_content = $model->wiki_page_revision_content;
			$currentWikiPage->wiki_page_creator_id = Yii::app()->user->id;
			$currentWikiPage->wiki_page_date = date('Y-m-d H:i:s');
			return $currentWikiPage->save();
		}
		
		return false;
	}
}