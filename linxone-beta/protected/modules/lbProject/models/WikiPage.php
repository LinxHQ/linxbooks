<?php

/**
 * This is the model class for table "wiki_pages".
 *
 * The followings are the available columns in table 'wiki_pages':
 * @property integer $wiki_page_id
 * @property integer $account_subscription_id
 * @property integer $project_id
 * @property string $wiki_page_title
 * @property integer $wiki_page_parent_id
 * @property string $wiki_page_content
 * @property string $wiki_page_tags
 * @property string $wiki_page_date
 * @property integer $wiki_page_updated_by
 * @property integer $wiki_page_creator_id
 * @property integer $wiki_page_is_category
 * @property integer $wiki_page_is_template
 * @property integer $wiki_page_summary
 * @property integer $wiki_page_order
 * @property integer $wiki_page_is_home
 */
class WikiPage extends CActiveRecord
{
	// Attributes for xupload
	public $file;
	public $mime_type;
	public $size;
	public $name;
	public $filename;
	
	/**
	 * @var boolean dictates whether to use sha1 to hash the file names
	 * along with time and the user id to make it much harder for malicious users
	 * to attempt to delete another user's file
	 */
	public $secureFileNames = false;
	// End attributes for xupload
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WikiPage the static model class
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
		return 'lb_project_wiki_pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_subscription_id, wiki_page_title, wiki_page_creator_id, wiki_page_content, wiki_page_date, wiki_page_updated_by', 'required'),
			array('account_subscription_id, wiki_page_creator_id, wiki_page_is_category, wiki_page_is_template, project_id, wiki_page_parent_id, wiki_page_updated_by', 'numerical', 'integerOnly'=>true),
			array('wiki_page_title, wiki_page_tags', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('wiki_page_id, account_subscription_id, project_id, wiki_page_title, wiki_page_parent_id, wiki_page_content, wiki_page_tags, wiki_page_date, wiki_page_updated_by, wiki_page_is_template, wiki_page_is_home', 'safe', 'on'=>'search'),
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
			'wiki_page_id' => 'Wiki Page',
			'account_subscription_id' => 'Account Subscription',
			'project_id' => 'Project',
			'wiki_page_title' => 'Title',
			'wiki_page_parent_id' => 'Parent Page',
			'wiki_page_content' => 'Content',
			'wiki_page_tags' => 'Tags',
			'wiki_page_date' => 'Wiki Page Date',
			'wiki_page_updated_by' => 'Wiki Page Updated By',
			'wiki_page_is_category' => 'Category',
            'wiki_page_is_home'=>'Wiki Home',
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

		$criteria->compare('wiki_page_id',$this->wiki_page_id);
		$criteria->compare('account_subscription_id',$this->account_subscription_id);
		$criteria->compare('project_id',$this->project_id);
		$criteria->compare('wiki_page_title',$this->wiki_page_title,true);
		$criteria->compare('wiki_page_parent_id',$this->wiki_page_parent_id);
		$criteria->compare('wiki_page_content',$this->wiki_page_content,true);
		$criteria->compare('wiki_page_tags',$this->wiki_page_tags,true);
		$criteria->compare('wiki_page_date',$this->wiki_page_date,true);
		$criteria->compare('wiki_page_updated_by',$this->wiki_page_updated_by);
		$criteria->compare('wiki_page_is_category',$this->wiki_page_is_category);
		$criteria->compare('wiki_page_is_template',$this->wiki_page_is_template);
        $criteria->compare('wiki_page_is_home', $this->wiki_page_is_home);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                            'pageSize'=>50,
                        ),
		));
	}
	
	/**
	 * search for wiki pages by keyword
	 * @param string $keyword
	 * @return array Array of WikiPage models found.
	 */
	public function searchByKeyword($keyword)
	{
		$keyword = strtolower($keyword); // convert to lower case
		$results = array();
		
		// get all wiki pages that this user is allowed to see
		// this doesn't load wiki_page_content in its result
		$wiki_pages = $this->getProjectWikiPages(0, -1, 'wiki_page_date DESC', true);
		
		foreach ($wiki_pages as $page)
		{
			if ($page->wiki_page_is_category != 1 && 
					$page->wiki_page_is_template != 1)
			{
				// reload page from database to include content in result
				$page = $page->findByPk($page->wiki_page_id);
				
				// gather those that match by title, content or tag
				if (mb_strpos(strtolower($page->wiki_page_title), $keyword) !== false
						|| mb_strpos(strtolower($page->wiki_page_content), $keyword) !== false
						|| mb_strpos(strtolower($page->wiki_page_tags), $keyword) !== false) 
				{
					$results[] = $page;
				}
			}
		}
		
		return $results;
	}
	
	/**
	 * count number of occurences of a $needle in this wiki page
	 * 
	 * @param string $needle
	 * @param number $wiki_page_id
	 */
	public function countMatches($needle, $wiki_page_id = 0)
	{
		$needle = strtolower($needle);
		$wiki = $this;
		if ($wiki_page_id > 0)
		{
			$wiki = $this->findByPk($wiki_page_id);
		}
		
		$count = 0;
		$count += substr_count(strtolower($wiki->wiki_page_title), $needle);
		$count += substr_count(strtolower($wiki->wiki_page_content), $needle);
		$count += substr_count(strtolower($wiki->wiki_page_tags), $needle);
		
		return $count;
	}
	
	public function save($runValidation=true, $attributes=NULL)
	{
		$this->wiki_page_updated_by = Yii::app()->user->id;
		$this->wiki_page_date = date('Y-m-d H:i:s');
		
		// check permission for adding category
		if ($this->wiki_page_is_category == YES && $this->isNewRecord)
		{
			if (!Permission::checkPermission($this, PERMISSION_WIKI_CATEGORY_CREATE))
				return false;
		}
		
		// if parent id and is_category are given, always remove category
		if ($this->wiki_page_is_category == YES && $this->wiki_page_parent_id > 0)
		{
			$this->wiki_page_is_category = NO;
		}
		
		// default parent id if not set
		if (!isset($this->wiki_page_parent_id))
		{
			$this->wiki_page_parent_id = 0;
		}
		// else if parent is set, assign this wiki page to the same project as the parent's
		if (isset($this->wiki_page_parent_id) && $this->wiki_page_parent_id > 0)
		{
			$parentPage = WikiPage::model()->findByPk($this->wiki_page_parent_id);
			if ($parentPage)
			{
				$this->project_id = $parentPage->project_id;
			}
		}
		
		// adding page
		if ($this->wiki_page_id == 0 || $this->wiki_page_id === null)
		{
			// check permission
			if (!Permission::checkPermission($this, PERMISSION_WIKI_PAGE_CREATE))
				return false;
			
			$this->wiki_page_creator_id = Yii::app()->user->id;
		} else {
			// update page
			// check permission
			if (!Permission::checkPermission($this, PERMISSION_WIKI_PAGE_UPDATE))
				return false;
		}
		
		// get summary
		$this->wiki_page_summary = preg_replace('/\s+?(\S+)?$/', '', substr($this->wiki_page_content, 0, 100));
		
		// remove dashes from title because it's a special char for this module
		// dash is use for formatting wiki tree. See function formatTitleForWikiTree()
		$this->wiki_page_title = str_replace('-', ' ', $this->wiki_page_title);
                
                // save to current subscription
                $this->account_subscription_id = Utilities::getCurrentlySelectedSubscription();
		
		return parent::save($runValidation, $attributes);
	}
	
	public function delete()
	{
		if (!Permission::checkPermission($this, PERMISSION_WIKI_PAGE_DELETE))
			return false;
		
		$this_page_id = $this->wiki_page_id;
		
		$result = parent::delete();
		
		// if successfully deleted
		// delete attached documents
		// delete children pages too
		if ($result)
		{
			// delete attached doc
			$documents = Documents::model()->findAllWikiPageAttachments($this_page_id);
			foreach ($documents as $doc)
			{
				$doc->delete();
			}
			
			// delete sub pages
			$sub_pages = $this->getSubPages();
			foreach ($sub_pages as $page)
			{
				$page->delete();
			}
		}
		
		return $result;
		
	}

    /**
     * Find wiki page of this project
     * If none present, create one
     *
     * @param $project_id
     * @return CActiveRecord
     */
    public function getProjectWikiHome($project_id)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('wiki_page_is_home', 1);
        $criteria->compare('project_id', $project_id);

        $home = WikiPage::model()->find($criteria);
        if ($home === null)
        {
            $project = Project::model()->findByPk($project_id);
            if ($project !== null)
            {
                $home = new WikiPage();
                $home->project_id = $project_id;
                $home->wiki_page_is_home = 1;
                $home->account_subscription_id = $project->account_subscription_id;
                $home->wiki_page_title = $project->project_name . ' - Wiki Home';
                $home->wiki_page_content = 'Home page of ' . $project->project_name;
                $home->wiki_page_is_template = 0;
                $home->sort = 0;
                if ($home->save())
                    return $home;
            }
        }

        return $home;
    }
	
	/**
	 * Get CActiveDataProvider that contains all wiki of category type, of a project
	 * @param unknown $project_id
	 * @param string $get_data default to false, if true, return array of model instead of CActiveDataProvider
	 */
	public function getProjectWikiCategories($project_id, $get_data = false)
	{
                $selected_subscription_id = Utilities::getCurrentlySelectedSubscription();
                
		$criteria = array(
				'select' => 'wiki_page_id, wiki_page_title',
				'condition' => "account_subscription_id = $selected_subscription_id AND project_id = $project_id AND wiki_page_is_category = " . YES,
				'order' => 'wiki_page_order ASC, wiki_page_date DESC',
		);
		$dataProvider = new CActiveDataProvider('WikiPage');
		$dataProvider->setCriteria($criteria);
		
		if ($get_data === true)
		{
			$dataProvider->setPagination(false);
			return $dataProvider->getData();
		}
		
		return $dataProvider;
	}
	
	/**
	 * Get CActiveDataProvider that contains all wiki (normal page), of a project
	 * @param integer $project_id
	 * @param integer $parent_id default = -1 (all)
	 * @param string $order	order of result, default  'wiki_page_date DESC'
	 * @param string $get_data default to false, if true, return array of model instead of CActiveDataProvider
	 */
	public function getProjectWikiPages($project_id, $parent_id = -1, 
			$order = 'sort DESC, wiki_page_title ASC, wiki_page_date DESC', $get_data = false)
	{
		$subscriptions_ids = array();
		// if currently selected sub is available
		// only load its wikis
		if (Utilities::getCurrentlySelectedSubscription())
		{
			$subscriptions_ids[]=Utilities::getCurrentlySelectedSubscription();
		} else {
			// find subscription
			$subscriptions = AccountSubscription::model()->findSubscriptions(Yii::app()->user->id);
			if (count($subscriptions) < 1) return;
			
			foreach ($subscriptions as $sub_id => $sub)
			{
				$subscriptions_ids[] = $sub_id;
		}
		}
		
		// only show wiki under this subscription.
		$condition = " account_subscription_id in (". implode(',', $subscriptions_ids) .") 
				AND wiki_page_is_template = 0 ";
		
		if ($project_id > 0)
		{
			$condition .= " AND project_id = $project_id";// AND wiki_page_is_category = " . NO;
		}
		
		if ($parent_id != -1)
		{
			$condition .= " AND wiki_page_parent_id = $parent_id";
		}
		
		$criteria = array(
				'select' => 'wiki_page_id, wiki_page_title, wiki_page_summary, wiki_page_creator_id, wiki_page_updated_by, wiki_page_tags, account_subscription_id, project_id',
				'condition' =>  $condition ,
				'order' => $order,
		);
		$dataProvider = new CActiveDataProvider('WikiPage');
		$dataProvider->setCriteria($criteria);
	
		if ($get_data == true)
		{
			$dataProvider->setPagination(false);
			return $dataProvider->getData();
		}
	
		return $dataProvider;
	}
	
	/**
	 * Get short title of wiki page
	 * @return Ambigous <string, mixed>
	 */
	public function shortTitle()
	{
		// short title with no word wrap, word may be cut off
		//$short_title = substr($this->wiki_page_title, 0, 40);
		// short title with word wrap
		$short_title_wr = preg_replace('/\s+?(\S+)?$/', '', substr($this->wiki_page_title, 0, 50));
		if (strlen($this->wiki_page_title) > strlen($short_title_wr)) 
		{
			$short_title_wr .= '...';
		}
		
		return $short_title_wr;
	}
	
	public function hasSubPage()
	{
		$condition = "wiki_page_parent_id = {$this->wiki_page_id} ";
		
		$criteria = array(
				'select' => 'wiki_page_id',
				'condition' =>  $condition ,
		);
		$dataProvider = new CActiveDataProvider('WikiPage');
		$dataProvider->setCriteria($criteria);
		
		$dataProvider->setPagination(false);
		$data = $dataProvider->getData();
		
		if (count($data) > 0)
		{
			return true;
		}
		
		return false;
	}
	
	/**
	 * Get subpages
	 * @param unknown $wiki_page_id
	 * @return array list of sub pages models
	 */
	public function getSubPages($wiki_page_id = 0)
	{
		$wikiPage = $this;
		if ($wiki_page_id > 0)
			$wikiPage = WikiPage::model()->findByPk($wiki_page_id);
		
		$sub_pages = $wikiPage->findAll('wiki_page_parent_id = :wiki_page_parent_id',
				array(':wiki_page_parent_id' => $wikiPage->wiki_page_id));
		
		return $sub_pages;
	}
	
	/**
	 * Get page of the same immediate parent. 
	 * This is a wrapper method for getProjectWikiPages
	 * 
	 * @param number $wiki_page_id
	 * @param array	array of wiki pages
	 */
	public function getPeerPages($wiki_page_id = 0)
	{
		$wikiPage = $this;
		if ($wiki_page_id > 0)
			$wikiPage = WikiPage::model()->findByPk($wiki_page_id);
		
		$peer_pages = $wikiPage->getProjectWikiPages(0, $wikiPage->wiki_page_parent_id,
				'sort DESC, wiki_page_title ASC, wiki_page_date ASC', true);
		
		return $peer_pages;
	}
	
	/**
	 * Get all wiki pages that are of type template.
	 * 
	 * @param unknown $account_subscription_id
	 */
	public function getTemplates($account_subscription_id)
	{
		return $this->findAll('account_subscription_id = :account_subscription_id 
				AND wiki_page_is_template = :wiki_page_is_template', 
				array(':account_subscription_id' => $account_subscription_id, ':wiki_page_is_template' => YES));
	}
	
	/**
	public function getWikiPageURL($wiki_page_id = 0)
	{
		if ($wiki_page_id == 0)
		{
			$wiki_page_id = $this->wiki_page_id;
		}
		
		return array('wikiPage/view', 'id' => $wiki_page_id);
	}**/
	
	/**
	 * get URL of a Wiki Page
	 *
	 * @param number $wiki_page_id
	 */
	public function getWikiPageURL($wiki_page_id = 0)
	{
		$wiki = $this;
		if ($wiki_page_id > 0)
		{
			$wiki = WikiPage::model()->findByPk($wiki_page_id);
		}
	
		$current_subscription = Utilities::getCurrentlySelectedSubscription();
		
		// wiki page with project, should have a different url?
		if ($wiki->project_id && ($project = Project::model()->findByPk($wiki->project_id)))
		{
			
			return array("$current_subscription/project/{$wiki->project_id}-"
				. $project->getURLEncodedProjectName()
				."/wiki/{$wiki->wiki_page_id}-"
				.$this->getURLEncodedWikiPageTitle());
		} else {
			return array("$current_subscription/wiki/{$wiki->wiki_page_id}-"
				.$this->getURLEncodedWikiPageTitle());
		}
	}

	public function getURLEncodedWikiPageTitle($wiki_page_id = 0)
	{
		$wiki = $this;
		if ($wiki_page_id > 0)
		{
			$wiki = WikiPage::model()->findByPk($wiki_page_id);
		}

		$wiki_title = str_replace(' ','-', $wiki->wiki_page_title);
		$wiki_title = preg_replace('/[^A-Za-z0-9\-]/', '', $wiki_title);
		return urlencode($wiki_title);
	}
	
	/**
	 * As a security measure
	 * This helps check if this wiki is matched with currently viewed subscription.
	 *
	 * @return boolean
	 */
	public function matchedCurrentSubscription()
	{
		$current_subscription = Utilities::getCurrentlySelectedSubscription();
	
		if ($current_subscription == $this->account_subscription_id)
			return true;
	
		return false;
	}

	/**
	 * Get the whole wiki tree, root pages include category as well as pages without parents
	 * 
	 * @param unknown $project_id
	 * @return multitype:NULL
	 */
	public function getProjectWikiTree($project_id)
	{		
		$root_pages = $this->getProjectWikiPages($project_id, 0, 'wiki_page_order ASC', true);
		
		$results = array();
		// for each root page, find it sub page(s)
		foreach ($root_pages as $page)
		{
			$results[$page->wiki_page_id] = $page->wiki_page_title;
			$results = $page->iterWikiTree($project_id, $results);
		}
		
		return $results;
	}
	
	/**
	 * Build the wiki tree with this current wiki as its parent.
	 * 
	 * @param unknown $project_id
	 * @param unknown $result
	 * @param number $depth
	 * @return array	array of tree leaves. items when shown in dropdown shall look like this:
	 * 						wiki page 1
	 * 						--wiki page 1.1
	 * 						--wiki page 1.2
	 * 						----wiki page 1.2.1
	 * 						wiki page 2
	 * 						--wiki page 2.1 
	 */
	public function iterWikiTree($project_id, $result, $depth = 0)
	{
		$sub_pages = $this->getProjectWikiPages($project_id, $this->wiki_page_id, 'wiki_page_title DESC', true);
	
		if (count($sub_pages) == 0)
		{
			return $result;
		} else {
			$depth++;
			foreach ($sub_pages as $p)
			{
				$label = '';
				for ($i = 0; $i < $depth; $i++) {
					$label .= '--';
				}
				$label .= $p->wiki_page_title;
				$result[$p->wiki_page_id] = $label;
				$result = $p->iterWikiTree($project_id, $result, $depth);
			}
				
			return $result;
		}
	}
	
	/**
	 * Sub pages are preceeded with dashes for displaying in dropdown
	 * But when display in wiki tree, we want to remove dashes, replaced them with spaces
	 * And the link should only start from the actual page title.
	 * But we also want to make sure we only process preceeding dashes, NOT dashes that are part of the title
	 * 
	 * @param string $needle		In this case, it's the char used to shift title (ie '-')
	 * @param string $replace		Replace with space or other character
	 * @return array formattedName	array($preceeding_spaces, 'actual_title', )
	 */
	public function formatTitleForWikiTree($needle = '-', $replace = '&nbsp;&nbsp;')
	{
		$page_title = $this->wiki_page_title;
		$preceeding_spaces = '';
		$title = '';
		for ($i = 0, $j = strlen($page_title); $i < $j; $i++) {
			$char = $page_title[$i];
			if ($char == $needle){
				// only process preceeding dashes
				$preceeding_spaces .= $replace;
			} else {
				// once we reach something else, stop. it's the start of the title
				$title .= $char;
			}
		}
		
		return array($preceeding_spaces, $title);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CModel::behaviors()
	 */
	public function behaviors()
	{
		return array(
				'sortable' => array(
						'class' => 'ext.sortable.SortableBehavior',
				)
		);
	}
}