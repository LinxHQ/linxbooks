<?php

// PROJECT
define('PERMISSION_PROJECT_CREATE', 'project_create');
define('PERMISSION_PROJECT_VIEW', 'project_view');
define('PERMISSION_PROJECT_LIST', 'project_list');
define('PERMISSION_PROJECT_UPDATE_MEMBER', 'project_update_member');
define('PERMISSION_PROJECT_UPDATE_MANAGER', 'project_update_manager');
define('PERMISSION_PROJECT_ARCHIVE', 'project_archive');
define('PERMISSION_PROJECT_DELETE', 'project_delete');
define('PERMISSION_PROJECT_UPDATE_GENERAL_INFO', 'project_update_general_info');
define('PERMISSION_PROJECT_UPDATE_OTHERS', 'project_update_others');

// TASK
define('PERMISSION_TASK_VIEW', 'task_view');
define('PERMISSION_TASK_LIST', 'task_list');
define('PERMISSION_TASK_CREATE', 'task_create');
define('PERMISSION_TASK_UPDATE_MEMBER', 'task_update_member');
define('PERMISSION_TASK_UPDATE_GENERAL_INFO', 'task_update_general_info');
define('PERMISSION_TASK_UPDATE_STATUS', 'task_update_status');
define('PERMISSION_TASK_UPDATE_OTHERS', 'task_update_others');
define('PERMISSION_TASK_DELETE', 'task_delete');
define('PERMISSION_TASK_COMMENT_ADD', 'task_comment_add');
define('PERMISSION_TASK_COMMENT_UPDATE', 'task_comment_update');
define('PERMISSION_TASK_COMMENT_DELETE', 'task_comment_delete');
define('PERMISSION_TASK_MILESTONES_UPDATE', 'task_milestones_update');

// ISSUE
define('PERMISSION_ISSUE_VIEW', 'issue_view');
define('PERMISSION_ISSUE_LIST', 'issue_list');
define('PERMISSION_ISSUE_CREATE', 'issue_create');
define('PERMISSION_ISSUE_UPDATE_MEMBER', 'issue_update_member');
define('PERMISSION_ISSUE_UPDATE_GENERAL_INFO', 'issue_update_general_info');
define('PERMISSION_ISSUE_UPDATE_STATUS', 'issue_update_status');
define('PERMISSION_ISSUE_UPDATE_PRIORITY', 'issue_update_priority');
define('PERMISSION_ISSUE_DELETE', 'issue_delete');
define('PERMISSION_ISSUE_COMMENT_ADD', 'issue_comment_add');
define('PERMISSION_ISSUE_COMMENT_UPDATE', 'issue_comment_update');
define('PERMISSION_ISSUE_COMMENT_DELETE', 'issue_comment_delete');

// IMPLEMENTATION
define('PERMISSION_IMPLEMENTATION_CREATE', 'implementation_create');
define('PERMISSION_IMPLEMENTATION_VIEW', 'implementation_view');
define('PERMISSION_IMPLEMENTATION_LIST', 'implementation_list');
define('PERMISSION_IMPLEMENTATION_DELETE', 'implementation_delete');
define('PERMISSION_IMPLEMENTATION_UPDATE_MEMBER', 'implementation_update_member');
define('PERMISSION_IMPLEMENTATION_COMMENT_ADD', 'implementation_comment_add');
define('PERMISSION_IMPLEMENTATION_COMMENT_DELETE', 'implementation_comment_delete');
define('PERMISSION_IMPLEMENTATION_UPDATE_GENERAL_INFO', 'implementation_update_general_info');
define('PERMISSION_IMPLEMENTATION_UPDATE_STATUS', 'implementation_update_status');
define('PERMISSION_IMPLEMENTATION_ENTITY_ASSIGN', 'implementation_entity_assign');

define('PERMISSION_WIKI_CATEGORY_CREATE', 'wiki_category_create');
define('PERMISSION_WIKI_PAGE_CREATE', 'wiki_page_create');
define('PERMISSION_WIKI_PAGE_UPDATE', 'wiki_page_update');
define('PERMISSION_WIKI_PAGE_DELETE', 'wiki_page_delete');
define('PERMISSION_WIKI_PAGE_LIST', 'wiki_page_list');
define('PERMISSION_WIKI_PAGE_VIEW', 'wiki_page_view');
define('PERMISSION_WIKI_PUBLIC_PAGE_VIEW', 'wiki_public_page_view');

// DOCUMENT
define('PERMISSION_DOCUMENT_DELETE', 'document_delete');
define('PERMISSION_DOCUMENT_VIEW', 'document_view');
define('PERMISSION_DOCUMENT_CREATE', 'document_create');
define('PERMISSION_DOCUMENT_UPDATE', 'document_update');

// Account
define('PERMISSION_ACCOUNT_VIEW', 'account_view');
define('PERMISSION_ACCOUNT_UPDATE', 'account_update');
define('PERMISSION_ACCOUNT_PROFILE_UPDATE', 'account_profile_update');
define('PERMISSION_ACCOUNT_PROFILE_VIEW', 'account_profile_view');
define('PERMISSION_ACCOUNT_SUBSCRIPTION_VIEW', 'account_subscription_view');
define('PERMISSION_ACCOUNT_TEAM_MEMBER_CREATE', 'account_team_member_create');
define('PERMISSION_ACCOUNT_TEAM_MEMBER_UPDATE', 'account_team_member_update');
define('PERMISSION_ACCOUNT_TEAM_MEMBER_DELETE', 'account_team_member_delete');

// Milestone
define('PERMISSION_MILESTONE_CREATE', 'milestone_create');
define('PERMISSION_MILESTONE_UPDATE', 'milestone_update');
define('PERMISSION_MILESTONE_LIST', 'milestone_list');

class Permission
{
	const PERMISSION_RESOURCE_LINK_CREATE = 'resource_link_create';
	const PERMISSION_RESOURCE_LINK_UPDATE = 'resource_link_update';
	const PERMISSION_RESOURCE_LINK_DELETE = 'resource_link_delete';
	const PERMISSION_RESOURCE_LINK_VIEW = 'resource_link_list_view';
	const PERMISSION_RESOURCE_LINK_LIST_CREATE = 'resource_link_list_create';
	const PERMISSION_RESOURCE_LINK_LIST_UPDATE = 'resource_link_list_update';
	const PERMISSION_RESOURCE_LINK_LIST_DELETE = 'resource_link_list_delete';
	const PERMISSION_RESOURCE_LINK_LIST_VIEW = 'resource_link_list_view';
	
	/**
	 * 
	 * 
	 * @param CActiveModel $model	related entity, ie project model, task model ...
	 * @param string $perm		name of permission
	 */
	public static function checkPermission($model, $perm)
	{
		if ($model == null)
			return false;
		
                // admin account can do all
                if (Yii::app()->user->id == 1)
                {
                    return true;
                }
                
		// Master account can do everything
		$subscription_id = 0;
		if (isset($model->account_subscription_id))
			$subscription_id = $model->account_subscription_id;
		else if (isset($model->project_id) && $model->project_id > 0)
		{
			$project = Project::model()->findByPk($model->project_id);
			$subscription_id = $project->account_subscription_id;
		}
		if (Account::model()->isMasterAccount($subscription_id))
			return true;
		// end check for master account
		
		// regular check
		$perm_function = "checkPermission_$perm";
		if(method_exists(new Permission, $perm_function))
		{
			return Permission::$perm_function($model);
		}
		// end regular check
		
		return false;
	}
	
	private static function checkPermission_project_create($model)
	{
		if(AccountTeamMember::model()->isAcountAdmin(false, YII::app()->user->id))
                    return true;
		return false;
	}
	
	private static function checkPermission_project_view($model)
	{
		// allow project manager
		if (ProjectMember::model()->isProjectManager($model->project_id, Yii::app()->user->id))
			return true;
		
		// allow project member
		if (ProjectMember::model()->isValidMember($model->project_id, Yii::app()->user->id))
			return true;
		
		return false;
	}
	
	private static function checkPermission_project_list($model)
	{
		// listing of projects
		// this is handled in specific controller code
	}
	
	private static function checkPermission_project_update_others($model)
	{
		// allow member
		if (ProjectMember::model()->isValidMember($model->project_id, Yii::app()->user->id)
					&& !$model->isArchived())
		{
			return true;
		}
		
		return false;
	}
	
	private static function checkPermission_project_update_member($model)
	{
		// allow project manager
		if (ProjectMember::model()->isProjectManager($model->project_id, Yii::app()->user->id))
			return true;
		
		return false;
	}
	
	private static function checkPermission_project_update_manager($model)
	{
		// allow only master account to do this
	
		return false;
	}
	
	private static function checkPermission_project_archive($model)
	{
		// allow project manager
		if (ProjectMember::model()->isProjectManager($model->project_id, Yii::app()->user->id))
			return true;
		
		return false;
	}
	
	private static function checkPermission_project_delete($model)
	{
		return false;
	}
	
	private static function checkPermission_project_update_general_info($model)
	{
		// allow project manager
		if (ProjectMember::model()->isProjectManager($model->project_id, Yii::app()->user->id))
			return true;
		
		return false;
	}
	
	private static function checkPermission_task_create($task)
	{		
		$project = Project::model()->findByPk($task->project_id);
		
		if ($project)
		{
			if (ProjectMember::model()->isValidMember($task->project_id, Yii::app()->user->id)
					&& !$project->isArchived())
			{
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * Project has to be active:
	 * Allow project manager
	 * 
	 * @param unknown $task
	 * @return boolean
	 */
	private static function checkPermission_task_update_member($task)
	{
		$project = Project::model()->findByPk($task->project_id);
		
		/**
		// ALlow project manager
		if ($project && ProjectMember::model()->isProjectManager($project->project_id, Yii::app()->user->id)
				&& !$project->isArchived())
		{
			return true;
		}**/
		
		// Allow non-customer account
		if ($project->project_id > 0 
				&& ProjectMember::model()->isValidMember($project->project_id, Yii::app()->user->id)
				//&& !AccountTeamMember::model()->isCustomer($project->findProjectMasterAccount(), Yii::app()->user->id) 
				&& !$project->isArchived())
		{
			return true;
		}
		
		return false;
	}
	
	private static function checkPermission_task_update_general_info($task)
	{
		$project = Project::model()->findByPk($task->project_id);
		
		// deny if this is a customer account (relative to this project)
		if ($project 
				&& AccountTeamMember::model()->isCustomer($project->findProjectMasterAccount(), Yii::app()->user->id))
			return false;
		
		// project not locked && user is PM
		if ($project && ProjectMember::model()->isProjectManager($project->project_id, Yii::app()->user->id)
				&& !$project->isArchived())
		{
			return true;
		}
		
		// project not locked && usr is assigned
		if ($project && TaskAssignee::model()->isValidMember($task->task_id, Yii::app()->user->id)
				&& !$project->isArchived())
		{
			return true;
		}
		
		return false;
	}
	
	private static function checkPermission_task_update_status($task)
	{
		$project = Project::model()->findByPk($task->project_id);
		
		// project not locked && user is PM or member
		if ($project && !$project->isArchived())
		{
                    if (ProjectMember::model()->isValidMember($project->project_id, Yii::app()->user->id))
			return true;
		}
		
		return false;
	}
	
	private static function checkPermission_task_update_others($task)
	{
		$project = Project::model()->findByPk($task->project_id);
	
		// project not locked && usr is assigned
		if ($project && TaskAssignee::model()->isValidMember($task->task_id, Yii::app()->user->id)
				&& !$project->isArchived())
		{
			return true;
		}
	
		return false;
	}
	
	private static function checkPermission_task_delete($task)
	{
		$project = Project::model()->findByPk($task->project_id);
		
		// project not locked && user is PM
		if ($project && ProjectMember::model()->isProjectManager($project->project_id, Yii::app()->user->id)
				&& !$project->isArchived())
		{
			return true;
		}
		
		return false;
	}
	
	private static function checkPermission_task_view($task)
	{
		$project = Project::model()->findByPk($task->project_id);
		
		if ($project == null)
			return false;
		
		// user is PM or user is a valid member of this task
		if (ProjectMember::model()->isProjectManager($project->project_id, Yii::app()->user->id)
				|| TaskAssignee::model()->isValidMember($task->task_id, Yii::app()->user->id))
		{
			return true;
		}
		
		return true;
	}
	
	/**
	 * check if its correct subscription
	 * if project is available, if this is a team member
	 * 
	 * @param unknown $resource
	 */
	private static function checkPermission_resource_link_create($resource)
	{
		$account_id = Yii::app()->user->id;
		$master_account_id = AccountSubscription::model()->getSubscriptionOwnerID($resource->account_subscription_id);
		
		// correct match of subscription
		if (AccountTeamMember::model()->isValidMember($master_account_id, Yii::app()->user->id))
		{
			// if project is available, must be correct project
			if ($resource->project_id)
			{
				if (!ProjectMember::model()->isValidMember($resource->project_id, $account_id))
					return false;
			}
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * check if its correct subscription
	 * if project is available, if this is a team member, and if this is the owner
	 *
	 * @param unknown $resource
	 */
	private static function checkPermission_resource_link_update($resource)
	{
		$account_id = Yii::app()->user->id;
		$master_account_id = AccountSubscription::model()->getSubscriptionOwnerID($resource->account_subscription_id);
	
		// correct match of subscription
		if (AccountTeamMember::model()->isValidMember($master_account_id, Yii::app()->user->id))
		{
			// if project is available, must be correct project
			if ($resource->project_id)
			{
				if (!ProjectMember::model()->isValidMember($resource->project_id, $account_id))
					return false;
				
				if ($resource->resource_created_by != $account_id
						&& !ProjectMember::model()->isProjectManager($resource->project_id, $account_id))
					return false;
			}
			
			// if not owner, return false
			if ($resource->resource_created_by != $account_id)
				return false;
			
			return true;
		}
	
		return false;
	}
	
	/**
	 * check if its correct subscription
	 * if project is available, if this is a team member, and if this is the owner
	 *
	 * @param unknown $resource
	 */
	private static function checkPermission_resource_link_delete($resource)
	{
		$account_id = Yii::app()->user->id;
		$master_account_id = AccountSubscription::model()->getSubscriptionOwnerID($resource->account_subscription_id);
	
		// correct match of subscription
		if (AccountTeamMember::model()->isValidMember($master_account_id, Yii::app()->user->id))
		{
			// if project is available, must be correct project
			if ($resource->project_id)
			{
				if (!ProjectMember::model()->isValidMember($resource->project_id, $account_id))
					return false;
	
				if ($resource->resource_created_by != $account_id)
				{
					if(!ProjectMember::model()->isProjectManager($resource->project_id, $account_id))
						return false;
				}
			}
				
			// if not owner, return false
			if ($resource->resource_created_by != $account_id)
				return false;
				
			return true;
		}
	
		return false;
	}
	
	/**
	 * check if its correct subscription
	 * if project is available, if this is a team member, and if this is the owner
	 *
	 * @param unknown $resource
	 */
	private static function checkPermission_resource_link_view($resource)
	{
		$account_id = Yii::app()->user->id;
		$master_account_id = AccountSubscription::model()->getSubscriptionOwnerID($resource->account_subscription_id);
	
		// correct match of subscription
		if (AccountTeamMember::model()->isValidMember($master_account_id, Yii::app()->user->id))
		{
			// if project is available, must be correct project
			if ($resource->project_id)
			{
				if (!ProjectMember::model()->isValidMember($resource->project_id, $account_id))
					return false;
			}
	
			return true;
		}
	
		return false;
	}
	
	/**
	 * check if its correct subscription
	 * if project is available, if this is a team member
	 *
	 * @param ResourceUserList $resource
	 */
	private static function checkPermission_resource_link_list_create($list)
	{
		$account_id = Yii::app()->user->id;
		$master_account_id = AccountSubscription::model()->getSubscriptionOwnerID($list->account_subscription_id);
	
		// correct match of subscription
		if (AccountTeamMember::model()->isValidMember($master_account_id, Yii::app()->user->id))
		{
			return true;
		}
	
		return false;
	}
	
	/**
	 * check if its correct subscription
	 * if project is available, if this is a team member, and if this is the owner
	 *
	 * @param ResourceUserList $resource
	 */
	private static function checkPermission_resource_link_list_update($list)
	{
		$account_id = Yii::app()->user->id;
		$master_account_id = AccountSubscription::model()->getSubscriptionOwnerID($list->account_subscription_id);
	
		// correct match of subscription
		if (AccountTeamMember::model()->isValidMember($master_account_id, Yii::app()->user->id))
		{
			// if not owner, return false
			if ($list->resource_created_by != $account_id)
				return false;
				
			return true;
		}
	
		return false;
	}
	
	/**
	 * check if its correct subscription
	 * if project is available, if this is a team member, and if this is the owner
	 *
	 * @param ResourceUserList $resource
	 */
	private static function checkPermission_resource_link_list_delete($list)
	{
		$account_id = Yii::app()->user->id;
		$master_account_id = AccountSubscription::model()->getSubscriptionOwnerID($list->account_subscription_id);
	
		// correct match of subscription
		if (AccountTeamMember::model()->isValidMember($master_account_id, Yii::app()->user->id))
		{	
			// if not owner, return false
			if ($list->resource_user_list_created_by != $account_id)
				return false;
	
			return true;
		}
	
		return false;
	}
	
	/**
	 * check if its correct subscription
	 * if project is available, if this is a team member, and if this is the owner
	 *
	 * @param ResourceUserList $list
	 */
	private static function checkPermission_resource_link_list_view($list)
	{
		$account_id = Yii::app()->user->id;
		$master_account_id = AccountSubscription::model()->getSubscriptionOwnerID($list->account_subscription_id);
	
		// correct match of subscription
		if (AccountTeamMember::model()->isValidMember($master_account_id, Yii::app()->user->id))
		{	
			return true;
		}
	
		return false;
	}
	
	private static function checkPermission_task_comment_add($task)
	{
		$project = Project::model()->findByPk($task->project_id);
		
		if ($project == null)
			return false;
		
		if ($project->isArchived())
			return false;
		
		if ($task->task_status == TASK_STATUS_COMPLETED)
			return false;
		
		// user is PM or user is a valid member of this task
		if (ProjectMember::model()->isProjectManager($project->project_id, Yii::app()->user->id)
				|| TaskAssignee::model()->isValidMember($task->task_id, Yii::app()->user->id))
		{
			return true;
		}
	}
	
	private static function checkPermission_task_comment_update($comment)
	{
		$task = Task::model()->findByPk($comment->task_id);
		$project = Project::model()->findByPk($task->project_id);
		
		// master account is allowed
		// has to check at this level because root level doesn't have direct access to subscription data
		$subscription_id = $project->account_subscription_id;
		if (Account::model()->isMasterAccount($subscription_id))
			return true;
		
		if ($comment->task_comment_owner_id != Yii::app()->user->id)
			return false;
		
		if ($task == null || $project == null
				|| $task->task_status == TASK_STATUS_COMPLETED
				|| $project->isArchived())
			return false;
		
		// don't allow update if it's older than 1 day
		$one_day = 24*60*60*1000;
		if ($comment->getAgeInDays() > $one_day)
			return false;
		
		// user is PM or user is a valid member of this task
		if (ProjectMember::model()->isProjectManager($project->project_id, Yii::app()->user->id)
				|| TaskAssignee::model()->isValidMember($task->task_id, Yii::app()->user->id))
		{
			return true;
		}
		
		return false;
	}
	
	private static function checkPermission_task_comment_delete($comment)
	{
		$task = Task::model()->findByPk($comment->task_id);
		$project = Project::model()->findByPk($task->project_id);
		
		// master account is allowed
		// has to check at this level because root level doesn't have direct access to subscription data
		$subscription_id = $project->account_subscription_id;
		if (Account::model()->isMasterAccount($subscription_id))
			return true;
		
		if ($comment->task_comment_owner_id != Yii::app()->user->id)
			return false;		
		
		if ($task == null || $project == null
				|| $task->task_status == TASK_STATUS_COMPLETED
				|| $project->isArchived())
			return false;
		
		// don't allow update if it's older than 1 day
		if ($comment->getAgeInDays() > 1)
			return false;
		
		// user is PM or user is a valid member of this task
		if (ProjectMember::model()->isProjectManager($project->project_id, Yii::app()->user->id)
				|| TaskAssignee::model()->isValidMember($task->task_id, Yii::app()->user->id))
		{
			return true;
		}
		
		return false;
	}
        
        private static function checkPermission_task_milestones_update($task)
        {
            $project = Project::model()->findByPk($task->project_id);
            if ($project === null)
                return false;
            
            // if not a valid member of the task or PM, don't allow
            if (!TaskAssignee::model()->isValidMember($task->task_id, Yii::app()->user->id)
                    && !ProjectMember::model()->isProjectManager($task->project_id, Yii::app()->user->id))
            {
                return false;
            }
            
            return true;
        }
	
	private static function checkPermission_issue_view($issue)
	{
		// allow project manager, assigned user, or creator
		if (ProjectMember::model()->isProjectManager($issue->project_id, Yii::app()->user->id)
				|| IssueAssignee::model()->isValidMember($issue->issue_id, Yii::app()->user->id)
				|| $issue->issue_reported_by == Yii::app()->user->id)
		{
			return true;
		}
		
		return false;
	}
	
	private static function checkPermission_issue_update_member($issue)
	{
		$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id, $issue->project_id);
		// deny if customer
		if (AccountTeamMember::model()->isCustomer($master_account_id, Yii::app()->user->id))
			return false;
		
		// allow project manager, assigned user, or creator, or project member
		if (ProjectMember::model()->isProjectManager($issue->project_id, Yii::app()->user->id)
				|| IssueAssignee::model()->isValidMember($issue->issue_id, Yii::app()->user->id)
				|| $issue->issue_reported_by == Yii::app()->user->id
				|| ProjectMember::model()->isValidMember($issue->project_id, Yii::app()->user->id))
		{
			return true;
		}
		
		return false;
	}
	
	private static function checkPermission_issue_update_general_info($issue)
	{
		// allow project manager, assigned user, or creator
		if (ProjectMember::model()->isProjectManager($issue->project_id, Yii::app()->user->id)
				|| IssueAssignee::model()->isValidMember($issue->issue_id, Yii::app()->user->id)
				|| $issue->issue_reported_by == Yii::app()->user->id)
		{
			return true;
		}
		
		return false;
	}
	
	private static function checkPermission_issue_delete($issue)
	{
		// allow project manager, 
		if (ProjectMember::model()->isProjectManager($issue->project_id, Yii::app()->user->id))
				return true;
		
		return false;
	}
	
	private static function checkPermission_issue_comment_add($issue)
	{
		// allow project manager, project member, or creator
		if (ProjectMember::model()->isProjectManager($issue->project_id, Yii::app()->user->id)
				|| ProjectMember::model()->isValidMember($issue->project_id, Yii::app()->user->id)
				|| $issue->issue_reported_by == Yii::app()->user->id)
		{
			return true;
		}
		
		return false;
	}
	
	private static function checkPermission_issue_comment_update($comment)
	{
		$issue = Issue::model()->findByPk($comment->issue_id);
		$project = Project::model()->findByPk($issue->project_id);
		
		// master account is allowed
		// has to check at this level because root level doesn't have direct access to subscription data
		$subscription_id = $project->account_subscription_id;
		if (Account::model()->isMasterAccount($subscription_id))
			return true;
		
		// don't allow if not the owner 
		if ($comment->issue_comment_owner_id != Yii::app()->user->id)
			return false;
		
		// deny if task done or project archived
		$completedStatus = SystemListItem::model()->getItemByCode(ISSUE_OPEN);
		if ($issue == null || $project == null
				|| $issue->issue_status != $completedStatus->system_list_item_id 
				|| $project->isArchived())
			return false;
		
		// don't allow update if it's older than 1 day
		$one_day = 24*60*60*1000;
		if ($comment->getAgeInDays() > $one_day)
			return false;
		
		// user is PM or user is a valid member of this issue
		if (ProjectMember::model()->isProjectManager($project->project_id, Yii::app()->user->id)
				|| IssueAssignee::model()->isValidMember($issue->issue_id, Yii::app()->user->id))
		{
			return true;
		}
		
		return false;
		
	}
	
	private static function checkPermission_issue_comment_delete($comment)
	{
		$issue = Issue::model()->findByPk($comment->issue_id);
		$project = Project::model()->findByPk($issue->project_id);
		
		// master account is allowed
		// has to check at this level because root level doesn't have direct access to subscription data
		$subscription_id = $project->account_subscription_id;
		if (Account::model()->isMasterAccount($subscription_id))
			return true;
		
		// don't allow if not the owner
		if ($comment->issue_comment_owner_id != Yii::app()->user->id)
			return false;		
		
		// deny if task done or project archived
		$completedStatus = SystemListItem::model()->getItemByCode(ISSUE_OPEN);
		if ($issue == null || $project == null
				|| $issue->issue_status != $completedStatus->system_list_item_id
				|| $project->isArchived())
			return false;

		// don't allow update if it's older than 1 day
		$one_day = 24*60*60*1000;
		if ($comment->getAgeInDays() > $one_day)
			return false;

		// user is PM or user is a valid member of this task
		if (ProjectMember::model()->isProjectManager($project->project_id, Yii::app()->user->id)
				|| IssueAssignee::model()->isValidMember($issue->issue_id, Yii::app()->user->id))
		{
			return true;
		}

		return false;

	}
	
	private static function checkPermission_implementation_create($implementation)
	{
		// dont allow customer to create implementation
		$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id, $implementation->project_id);
		if (AccountTeamMember::model()->isCustomer($master_account_id, Yii::app()->user->id))
			return false;
		
		// allow project member (this should include PM as well)
		if (ProjectMember::model()->isValidMember($implementation->project_id, Yii::app()->user->id))
		{
			return true;
		}
		
		return false;
	}
	
	private static function checkPermission_implementation_view($implementation)
	{	
		// allow project member (this should include PM as well)
		if (ProjectMember::model()->isValidMember($implementation->project_id, Yii::app()->user->id))
		{
			return true;
		}
	
		return false;
	}
	
	private static function checkPermission_implementation_delete($implementation)
	{
		// deny if customer
		$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id, $implementation->project_id);
		if (AccountTeamMember::model()->isCustomer($master_account_id, Yii::app()->user->id))
			return false;
		
		// deny if status is not pending
		$status = SystemListItem::model()->getItemByCode(IMPLEMENTATION_STATUS_PENDING);
		if ($implementation->implementation_status != $status->system_list_item_id)
			return false;
		
		// allow project manager & assigned member of implementation
		if (ProjectMember::model()->isProjectManager($implementation->project_id, Yii::app()->user->id)
				|| ImplementationAssignee::model()->isValidMember($implementation->implementation_id, Yii::app()->user->id))
		{
			return true;
		}
	
		return false;
	}
	
	private static function checkPermission_implementation_update_member($implementation)
	{
		// deny if customer
		$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id, $implementation->project_id);
		if (AccountTeamMember::model()->isCustomer($master_account_id, Yii::app()->user->id))
			return false;
		
		// deny if status is not pending
		$status = SystemListItem::model()->getItemByCode(IMPLEMENTATION_STATUS_PENDING);
		if ($implementation->implementation_status != $status->system_list_item_id)
			return false;
		
		// allow project manager & assigned member of implementation
		if (ProjectMember::model()->isProjectManager($implementation->project_id, Yii::app()->user->id)
				|| ImplementationAssignee::model()->isValidMember($implementation->implementation_id, Yii::app()->user->id))
		{
			return true;
		}
		
		// allow creator
		if ($implementation->implementation_created_by == Yii::app()->user->id)
			return true;
		
		return false;
	}
	
	private static function checkPermission_implementation_update_general_info($implementation)
	{
		// deny if customer
		$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id, $implementation->project_id);
		if (AccountTeamMember::model()->isCustomer($master_account_id, Yii::app()->user->id))
			return false;
		
		// deny if status is not pending
		$status = SystemListItem::model()->getItemByCode(IMPLEMENTATION_STATUS_PENDING);
		if ($implementation->implementation_status != $status->system_list_item_id)
		{
			// DO NOT check this. Otherwise cannot update status unless using master account
			//return false;
		}
		
		// allow project manager & assigned member of implementation
		if (ProjectMember::model()->isProjectManager($implementation->project_id, Yii::app()->user->id)
				|| ImplementationAssignee::model()->isValidMember($implementation->implementation_id, Yii::app()->user->id))
		{
			return true;
		}
		
		return false;
	}
	
	private static function checkPermission_implementation_update_status($implementation)
	{
		// deny if customer
		$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id, $implementation->project_id);
		if (AccountTeamMember::model()->isCustomer($master_account_id, Yii::app()->user->id))
			return false;
	
		// allow project manager & assigned member of implementation
		if (ProjectMember::model()->isProjectManager($implementation->project_id, Yii::app()->user->id)
				|| ImplementationAssignee::model()->isValidMember($implementation->implementation_id, Yii::app()->user->id))
		{
			return true;
		}
	
		return false;
	}
	
	private static function checkPermission_implementation_comment_add($implementation)
	{
		$project = Project::model()->findByPk($implementation->project_id);
		
		// master account is allowed
		// has to check at this level because root level doesn't have direct access to subscription data
		$subscription_id = $project->account_subscription_id;
		if (Account::model()->isMasterAccount($subscription_id))
			return true;
		
		// deny if status is not pending
		$status = SystemListItem::model()->getItemByCode(IMPLEMENTATION_STATUS_PENDING);
		if ($implementation->implementation_status != $status->system_list_item_id)
			return false;
		
		// allow project manager & assigned member of implementation
		if (ProjectMember::model()->isProjectManager($implementation->project_id, Yii::app()->user->id)
				|| ImplementationAssignee::model()->isValidMember($implementation->implementation_id, Yii::app()->user->id))
		{
			return true;
		}
		
		return false;
	}
	
	private static function checkPermission_implementation_comment_delete($implementation_comment)
	{
		$implementation = Implementation::model()->findByPk($implementation_comment->implementation_id);
		// deny if status is not pending
		$status = SystemListItem::model()->getItemByCode(IMPLEMENTATION_STATUS_PENDING);
		if ($implementation->implementation_status != $status->system_list_item_id)
			return false;
		
		// check ownership and age
		if ($implementation_comment->implementation_comment_by != Yii::app()->user->id
				|| $implementation_comment->getAgeInDays() > 1)
			return false;
	
		// allow project manager & assigned member of implementation
		if (ProjectMember::model()->isProjectManager($implementation->project_id, Yii::app()->user->id)
				|| ImplementationAssignee::model()->isValidMember($implementation->implementation_id, Yii::app()->user->id))
		{
			return true;
		}
	
		return false;
	}
	
	private static function checkPermission_wiki_category_create($wiki)
	{
		// only master account can create category
		return false;
	}
	
	private static function checkPermission_wiki_page_create($wiki)
	{
		$account_id = Yii::app()->user->id;

		// allow team member
		if ($wiki->project_id <= 0)
		{
			$master_account_id = AccountSubscription::model()->getSubscriptionOwnerID($wiki->account_subscription_id);
			
			// correct match of subscription
			if (AccountTeamMember::model()->isValidMember($master_account_id, $account_id))
			{
				return true;
			}
			;//return false;// ALLOW
		}
		
		// deny if customer
		if ($wiki->project_id > 0)
		{
			$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id, $wiki->project_id);
		} else {
			$master_account_id = AccountSubscription::model()->getSubscriptionOwnerID($wiki->account_subscription_id);
		}
		
		/**
		if (AccountTeamMember::model()->isCustomer($master_account_id, Yii::app()->user->id))
			return false;
		**/
		
		// allow PM and  member
		if ($wiki->project_id > 0 
				&& ProjectMember::model()->isValidMember($wiki->project_id, Yii::app()->user->id))
			return true;
		
		// allow team member
		if (AccountTeamMember::model()->isValidMember($master_account_id, Yii::app()->user->id))
			return true;
	}
	
	private static function checkPermission_wiki_page_update($wiki)
	{
		// deny if customer
		$thisSubscription = AccountSubscription::model()->findByPk($wiki->account_subscription_id);
		$master_account_id = $thisSubscription->account_id;
		if (AccountTeamMember::model()->isCustomer($master_account_id, Yii::app()->user->id))
			return false;		
		
		// if not part of a project, allow all members of this master account that this wiki belongs to
		if ($wiki->project_id <= 0 || $wiki->project_id === null)
		{
			if (AccountTeamMember::model()->isValidMember($master_account_id, Yii::app()->user->id)
					&& AccountTeamMember::model()->isActive($master_account_id, Yii::app()->user->id))
				return true;
		} else {
			// if part of project, only allow project members
			// allow PM and non-customer member
			if (ProjectMember::model()->isValidMember($wiki->project_id, Yii::app()->user->id))
				return true;
		}
		
		return false;
	}
	
	private static function checkPermission_wiki_page_delete($wiki)
	{
		// no one except master account is allowed to delete.
		return false;
	}
	
	private static function checkPermission_wiki_page_view($wiki)
	{
		// deny if subscription doesn't exist any more
		$thisSubscription = AccountSubscription::model()->findByPk($wiki->account_subscription_id);
		if (!$thisSubscription)
			return false;
		$master_account_id = $thisSubscription->account_id;
                
		// if not part of a project, allow all members of this master account that this wiki belongs to
		if ($wiki->project_id <= 0 || $wiki->project_id === null)
		{
                        // don't allow customers to see non-project wiki
                        if (AccountTeamMember::model()->isCustomer($master_account_id, Yii::app()->user->id))
                            return false;
                
			if (AccountTeamMember::model()->isValidMember($master_account_id, Yii::app()->user->id)
					&& AccountTeamMember::model()->isActive($master_account_id, Yii::app()->user->id))
				return true;
		} else {
			// if part of project, only allow project members
			// allow PM and non-customer member
			if (ProjectMember::model()->isValidMember($wiki->project_id, Yii::app()->user->id))
				return true;
		}
		
		return false;
	}
	
	/**
	 * 
	 * @param unknown $doc
	 */
	private static function checkPermission_document_create($doc)
	{
		$doc_type = $doc->document_parent_type;
		$owner_id = $doc->document_owner_id;
		$account_id = Yii::app()->user->id;
		
		switch($doc_type)
		{
			case DOCUMENT_PARENT_TYPE_TASK_COMMENT:
				// get comment
				$taskComment = TaskComment::model()->findByPk($doc->document_parent_id);
				// get task
				$task = Task::model()->findByPk($taskComment->task_id);
		
				//allow if master account of project
				$project = Project::model()->findByPk($task->project_id);
				if ($project->isOfMasterAccount($account_id))
					return true;
				
				// if deactivated user, deny
				$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id
						, $task->project_id);
				if (!AccountTeamMember::model()->isActive($master_account_id, Yii::app()->user->id))
					return false;
		
				// if user is PM of project, allow
				if (ProjectMember::model()->isProjectManager($task->project_id, $account_id))
					return true;
		
				// if user is still valid member
				if (TaskAssignee::model()->isValidMember($task->task_id, $account_id))
					return true;
				break;
		
			case DOCUMENT_PARENT_TYPE_ISSUE_COMMENT:
				// get comment
				$issueComment = IssueComment::model()->findByPk($doc->document_parent_id);
				// get issue
				$issue = Issue::model()->findByPk($issueComment->issue_id);
		
				//allow if master account of project
				$project = Project::model()->findByPk($issue->project_id);
				if ($project->isOfMasterAccount($account_id))
					return true;
				
				// if deactivated user, deny
				$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id
						, $issue->project_id);
				if (!AccountTeamMember::model()->isActive($master_account_id, Yii::app()->user->id))
					return false;
		
				// if user is PM of project, allow
				if (ProjectMember::model()->isProjectManager($issue->project_id, $account_id))
					return true;
		
				// if user is still valid member , allow
				if (IssueAssignee::model()->isValidMember($issue->issue_id, $account_id))
					return true;
				break;
		
			case DOCUMENT_PARENT_TYPE_IMPLEMENTATION:
				// get implementation
				$impl = Implementation::model()->findByPk($doc->document_parent_id);
		
				//allow if master account of project
				$project = Project::model()->findByPk($impl->project_id);
				if ($project->isOfMasterAccount($account_id))
					return true;
				
				// if deactivated user, deny
				$master_account_id = AccountTeamMember::model()->getMasterAccountIDs($account_id
						, $impl->project_id);
				if (!AccountTeamMember::model()->isActive($master_account_id, $account_id))
					return false;
		
				// if user is PM of project, allow
				if (ProjectMember::model()->isProjectManager($impl->project_id, $account_id))
					return true;
		
				// if user is still valid member, allow
				if (ImplementationAssignee::model()->isValidMember($impl->implementation_id, $account_id))
					return true;
				break;
		
			case DOCUMENT_PARENT_TYPE_PROJECT:
				// get project
				$project = Project::model()->findByPk($doc->document_parent_id);
		
				//allow if master account of project
				if ($project->isOfMasterAccount($account_id))
					return true;
				
				// if deactivated user, deny
				$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id
						, $project->project_id);
				if (!AccountTeamMember::model()->isActive($master_account_id, Yii::app()->user->id))
					return false;
		
				// if user is PM of project, allow
				if (ProjectMember::model()->isProjectManager($project->project_id, $account_id))
					return true;
		
				// if user is still valid member  allow
				if (ProjectMember::model()->isValidMember($project->project_id, $account_id))
					return true;
				break;
		
			case DOCUMENT_PARENT_TYPE_WIKI_PAGE:
				// get wiki
				$wiki = WikiPage::model()->findByPk($doc->document_parent_id);
		
				// deny customer account
				$subscription = AccountSubscription::model()->findByPk( $wiki->account_subscription_id );
				$master_account_id = $subscription->account_id;
				if (AccountTeamMember::model()->isCustomer($master_account_id, $account_id))
					return false;
		
				// if deactivated user, deny
				if (!AccountTeamMember::model()->isActive($master_account_id, $account_id))
					return false;
		
				// if wiki is part of a project
				if ($wiki->project_id > 0)
				{
					// get project
					$project = Project::model()->findByPk($wiki->project_id);
		
					// if user is PM of project, allow
					if (ProjectMember::model()->isProjectManager($project->project_id, $account_id))
						return true;
		
					// if user is still valid member, allow
					if (ProjectMember::model()->isValidMember($project->project_id, $account_id))
						return true;
				}
		
				// else has to account team member
				if (AccountTeamMember::model()->isValidMember($master_account_id, $account_id))
				{
					return true;
				}
		
				break;
		
			default:
				break;
		}
		
		return false;
	} // end document_Create
	
	private static function checkPermission_document_update($doc)
	{
		
		$doc_type = $doc->document_parent_type;
		$owner_id = $doc->document_owner_id;
		$account_id = Yii::app()->user->id;
		
		switch($doc_type)
		{
			case DOCUMENT_PARENT_TYPE_TASK_COMMENT:
				// get comment
				$taskComment = TaskComment::model()->findByPk($doc->document_parent_id);
				// get task
				$task = Task::model()->findByPk($taskComment->task_id);
		
				//allow if master account of project
				$project = Project::model()->findByPk($task->project_id);
				if ($project->isOfMasterAccount($account_id))
					return true;
				
				// if deactivated user, deny
				$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id
						, $task->project_id);
				if (!AccountTeamMember::model()->isActive($master_account_id, Yii::app()->user->id))
					return false;
		
				// if user is PM of project, allow
				if (ProjectMember::model()->isProjectManager($task->project_id, $account_id))
					return true;
		
				// if user is still valid member
				if (TaskAssignee::model()->isValidMember($task->task_id, $account_id))
					return true;
				break;
		
			case DOCUMENT_PARENT_TYPE_ISSUE_COMMENT:
				// get comment
				$issueComment = IssueComment::model()->findByPk($doc->document_parent_id);
				// get issue
				$issue = Issue::model()->findByPk($issueComment->issue_id);
		
				//allow if master account of project
				$project = Project::model()->findByPk($issue->project_id);
				if ($project->isOfMasterAccount($account_id))
					return true;
				
				// if deactivated user, deny
				$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id
						, $issue->project_id);
				if (!AccountTeamMember::model()->isActive($master_account_id, Yii::app()->user->id))
					return false;
		
				// if user is PM of project, allow
				if (ProjectMember::model()->isProjectManager($issue->project_id, $account_id))
					return true;
		
				// if user is still valid member , allow
				if (IssueAssignee::model()->isValidMember($issue->issue_id, $account_id))
					return true;
				break;
		
			case DOCUMENT_PARENT_TYPE_IMPLEMENTATION:
				// get implementation
				$impl = Implementation::model()->findByPk($doc->document_parent_id);
		
				//allow if master account of project
				$project = Project::model()->findByPk($impl->project_id);
				if ($project->isOfMasterAccount($account_id))
					return true;
				
				// if deactivated user, deny
				$master_account_id = AccountTeamMember::model()->getMasterAccountIDs($account_id
						, $impl->project_id);
				if (!AccountTeamMember::model()->isActive($master_account_id, $account_id))
					return false;
		
				// if user is PM of project, allow
				if (ProjectMember::model()->isProjectManager($impl->project_id, $account_id))
					return true;
		
				// if user is still valid member, allow
				if (ImplementationAssignee::model()->isValidMember($impl->implementation_id, $account_id))
					return true;
				break;
		
			case DOCUMENT_PARENT_TYPE_PROJECT:
				// get project
				$project = Project::model()->findByPk($doc->document_parent_id);
		
				//allow if master account of project
				if ($project->isOfMasterAccount($account_id))
					return true;
				
				// if deactivated user, deny
				$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id
						, $project->project_id);
				if (!AccountTeamMember::model()->isActive($master_account_id, Yii::app()->user->id))
					return false;
		
				// if user is PM of project, allow
				if (ProjectMember::model()->isProjectManager($project->project_id, $account_id))
					return true;
		
				// if user is still valid member  allow
				if (ProjectMember::model()->isValidMember($project->project_id, $account_id))
					return true;
				break;
		
			case DOCUMENT_PARENT_TYPE_WIKI_PAGE:
				// get wiki
				$wiki = WikiPage::model()->findByPk($doc->document_parent_id);
		
				// deny customer account
				$subscription = AccountSubscription::model()->findByPk( $wiki->account_subscription_id );
				$master_account_id = $subscription->account_id;
				if (AccountTeamMember::model()->isCustomer($master_account_id, $account_id))
					return false;
		
				// if deactivated user, deny
				if (!AccountTeamMember::model()->isActive($master_account_id, $account_id))
					return false;
		
				// if wiki is part of a project
				if ($wiki->project_id > 0)
				{
					// get project
					$project = Project::model()->findByPk($wiki->project_id);
		
					// if user is PM of project, allow
					if (ProjectMember::model()->isProjectManager($project->project_id, $account_id))
						return true;
		
					// if user is still valid member, allow
					if (ProjectMember::model()->isValidMember($project->project_id, $account_id))
						return true;
				}
		
				// else has to account team member
				if (AccountTeamMember::model()->isValidMember($master_account_id, $account_id))
				{
					return true;
				}
		
				break;
		
			default:
				break;
		}
		
		return false;
	} // end document update
	
	private static function checkPermission_document_view($doc)
	{
		$doc_type = $doc->document_parent_type;
		$owner_id = $doc->document_owner_id;
		$account_id = Yii::app()->user->id;
		
		switch($doc_type)
		{
			case DOCUMENT_PARENT_TYPE_TASK_COMMENT:
				// get comment
				$taskComment = TaskComment::model()->findByPk($doc->document_parent_id);
				// get task
				$task = Task::model()->findByPk($taskComment->task_id);
		
				//allow if master account of project
				$project = Project::model()->findByPk($task->project_id);
				if ($project->isOfMasterAccount($account_id))
					return true;
				
				// if deactivated user, deny
				$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id
						, $task->project_id);
				if (!AccountTeamMember::model()->isActive($master_account_id, Yii::app()->user->id))
					return false;
		
				// if user is PM of project, allow
				if (ProjectMember::model()->isProjectManager($task->project_id, $account_id))
					return true;
		
				// if user is still valid member 
				if (TaskAssignee::model()->isValidMember($task->task_id, $account_id))
					return true;
                                // if user is a vaid project member
                                if (ProjectMember::model()->isValidMember($task->project_id, $account_id))
                                        return true;
                                
				break;
		
			case DOCUMENT_PARENT_TYPE_ISSUE_COMMENT:
				// get comment
				$issueComment = IssueComment::model()->findByPk($doc->document_parent_id);
				// get issue
				$issue = Issue::model()->findByPk($issueComment->issue_id);
		
				//allow if master account of project
				$project = Project::model()->findByPk($issue->project_id);
				if ($project->isOfMasterAccount($account_id))
					return true;
				
				// if deactivated user, deny
				$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id
						, $issue->project_id);
				if (!AccountTeamMember::model()->isActive($master_account_id, Yii::app()->user->id))
					return false;
		
				// if user is PM of project, allow
				if (ProjectMember::model()->isProjectManager($issue->project_id, $account_id))
					return true;
		
				// if user is still valid member & owner of the doc, allow
				if (IssueAssignee::model()->isValidMember($issue->issue_id, $account_id))
					return true;
                                // if user is a vaid project member
                                if (ProjectMember::model()->isValidMember($issue->project_id, $account_id))
                                        return true;
				break;
		
			case DOCUMENT_PARENT_TYPE_IMPLEMENTATION:
				// get implementation
				$impl = Implementation::model()->findByPk($doc->document_parent_id);

				//allow if master account of project
				$project = Project::model()->findByPk($impl->project_id);
				if ($project->isOfMasterAccount($account_id))
					return true;
				
				// if deactivated user, deny
				$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id
						, $impl->project_id);
				if (!AccountTeamMember::model()->isActive($master_account_id, Yii::app()->user->id))
					return false;
		
				// if user is PM of project, allow
				if (ProjectMember::model()->isProjectManager($impl->project_id, $account_id))
					return true;
		
				// if user is still valid member, allow
				if (ImplementationAssignee::model()->isValidMember($impl->implementation_id, $account_id))
					return true;
				break;
		
			case DOCUMENT_PARENT_TYPE_PROJECT:
				// get project
				$project = Project::model()->findByPk($doc->document_parent_id);
		
				//allow if master account of project
				if ($project->isOfMasterAccount($account_id))
					return true;
				
				// if deactivated user, deny
				$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id
						, $project->project_id);
				if (!AccountTeamMember::model()->isActive($master_account_id, Yii::app()->user->id))
					return false;
		
				// if user is PM of project, allow
				if (ProjectMember::model()->isProjectManager($project->project_id, $account_id))
					return true;
		
				// if user is still valid member  allow
				if (ProjectMember::model()->isValidMember($project->project_id, $account_id))
					return true;
				break;
		
			case DOCUMENT_PARENT_TYPE_WIKI_PAGE:
				// get wiki
				$wiki = WikiPage::model()->findByPk($doc->document_parent_id);
		
				// deny customer account
				$subscription = AccountSubscription::model()->findByPk( $wiki->account_subscription_id );
				$master_account_id = $subscription->account_id;
				if (AccountTeamMember::model()->isCustomer($master_account_id, $account_id))
					return false;
		
				// if deactivated user, deny
				if (!AccountTeamMember::model()->isActive($master_account_id, Yii::app()->user->id))
					return false;
		
				// if wiki is part of a project
				if ($wiki->project_id > 0)
				{
					// get project
					$project = Project::model()->findByPk($wiki->project_id);
		
					// if user is PM of project, allow
					if (ProjectMember::model()->isProjectManager($project->project_id, $account_id))
						return true;
						
					// if user is still valid member, allow
					if (ProjectMember::model()->isValidMember($project->project_id, $account_id))
						return true;
				}
		
				// owner
				if ($owner_id == $account_id)
				{
					return true;
				}
                                
                                // same subscription team can see, and same as wiki's subscription
                                // if not the same team, reject right away
                                $this_user_subscriptions = AccountSubscription::model()->findSubscriptions($account_id);
                                //if (AccountTeamMember::model()->isMyTeamMember($account_id, $owner_id->account_id)
                                if (isset($this_user_subscriptions[$wiki->account_subscription_id])
                                        && $this_user_subscriptions[$wiki->account_subscription_id] != '')
                                        return true;
		
				break;
		
			default:
				break;
		}
		
		return false;
	}
	
	private static function checkPermission_document_delete($doc)
	{
		$doc_type = $doc->document_parent_type;
		$owner_id = $doc->document_owner_id;
		$account_id = Yii::app()->user->id;
		
		switch($doc_type)
		{
			case DOCUMENT_PARENT_TYPE_TASK_COMMENT:
				// get comment
				$taskComment = TaskComment::model()->findByPk($doc->document_parent_id);
				// get task
				$task = Task::model()->findByPk($taskComment->task_id);
				
				//allow if master account of project
				$project = Project::model()->findByPk($task->project_id);
				if ($project->isOfMasterAccount($account_id))
					return true;
				
				// if task is done, deny delete
				if ($task->task_status == TASK_STATUS_COMPLETED)
					return false;
				
				// if deactivated user, deny
				$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id
						, $task->project_id);
				if (!AccountTeamMember::model()->isActive($master_account_id, Yii::app()->user->id))
					return false;
				
				// if user is PM of project, allow
				if (ProjectMember::model()->isProjectManager($task->project_id, $account_id))
					return true;
				
				// if user is still valid member & owner of the doc, allow
				if (TaskAssignee::model()->isValidMember($task->task_id, $account_id)
						&& $owner_id == $account_id)
					return true;
				break;
				
			case DOCUMENT_PARENT_TYPE_ISSUE_COMMENT:
				// get comment
				$issueComment = IssueComment::model()->findByPk($doc->document_parent_id);
				// get issue
				$issue = Issue::model()->findByPk($issueComment->issue_id);
				
				//allow if master account of project
				$project = Project::model()->findByPk($issue->project_id);
				if ($project->isOfMasterAccount($account_id))
					return true;
				
				// if issue is done, deny delete
				$issueStatus = SystemListItem::model()->getItemIdByCode(ISSUE_OPEN);
				if ($issue->issue_status != $issueStatus)
					return false;
				
				// if deactivated user, deny
				$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id
						, $issue->project_id);
				if (!AccountTeamMember::model()->isActive($master_account_id, Yii::app()->user->id))
					return false;
				
				// if user is PM of project, allow
				if (ProjectMember::model()->isProjectManager($issue->project_id, $account_id))
					return true;
				
				// if user is still valid member & owner of the doc, allow
				if (IssueAssignee::model()->isValidMember($issue->issue_id, $account_id)
						&& $owner_id == $account_id)
					return true;
				break;
				
			case DOCUMENT_PARENT_TYPE_IMPLEMENTATION:
				// get implementation
				$impl = Implementation::model()->findByPk($doc->document_parent_id);
				
				//allow if master account of project
				$project = Project::model()->findByPk($impl->project_id);
				if ($project->isOfMasterAccount($account_id))
					return true;
				
				// if implementation is done, deny delete
				$implStatus = SystemListItem::model()->getItemIdByCode(IMPLEMENTATION_STATUS_PENDING);
				if ($impl->implementation_status != $implStatus)
					return false;
				
				// if deactivated user, deny
				$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id
						, $impl->project_id);
				if (!AccountTeamMember::model()->isActive($master_account_id, Yii::app()->user->id))
					return false;
				
				// if user is PM of project, allow
				if (ProjectMember::model()->isProjectManager($impl->project_id, $account_id))
					return true;
				
				// if user is still valid member & owner of the doc, allow
				if (ImplementationAssignee::model()->isValidMember($impl->implementation_id, $account_id)
						&& $owner_id == $account_id)
					return true;
				break;
				
			case DOCUMENT_PARENT_TYPE_PROJECT:
				// get project
				$project = Project::model()->findByPk($doc->document_parent_id);
				
				// if project is not active, deny delete
				if ($project->project_status != PROJECT_STATUS_ACTIVE)
					return false;
				
				//allow if master account of project
				if ($project->isOfMasterAccount($account_id))
					return true;
				
				// if deactivated user, deny
				$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id
						, $project->project_id);
				if (!AccountTeamMember::model()->isActive($master_account_id, Yii::app()->user->id))
					return false;
				
				// if user is PM of project, allow
				if (ProjectMember::model()->isProjectManager($project->project_id, $account_id))
					return true;
				
				// if user is still valid member & owner of the doc, allow
				if (ProjectMember::model()->isValidMember($project->project_id, $account_id)
						&& $owner_id == $account_id)
					return true;
				break;
				
			case DOCUMENT_PARENT_TYPE_WIKI_PAGE:
				// get wiki
				$wiki = WikiPage::model()->findByPk($doc->document_parent_id);
				
				// deny customer account
				$subscription = AccountSubscription::model()->findByPk( $wiki->account_subscription_id );
				$master_account_id = $subscription->account_id;
				if (AccountTeamMember::model()->isCustomer($master_account_id, $account_id))
					return false;
				
				// if deactivated user, deny
				if (!AccountTeamMember::model()->isActive($master_account_id, Yii::app()->user->id))
					return false;
				
				// if wiki is part of a project
				if ($wiki->project_id > 0)
				{
					// get project
					$project = Project::model()->findByPk($wiki->project_id);
					
					// if project is not active, deny delete
					if ($project->project_status != PROJECT_STATUS_ACTIVE)
						return false;
					
					// if user is PM of project, allow
					if (ProjectMember::model()->isProjectManager($project->project_id, $account_id))
						return true;
					
					// if user is still valid member & owner of the doc, allow
					if (ProjectMember::model()->isValidMember($project->project_id, $account_id)
							&& $owner_id == $account_id)
						return true;
				}
				
				// else has to be owner to delete
				if ($owner_id == $account_id)
				{
					return true;
				}
				
				break;
				
			default:
				break;
		}
		
		return false;
	}
	
	public static function checkPermission_account_update($account)
	{
		// check permission
		if (Yii::app()->user->account_email == 'admin'
				|| Yii::app()->user->id == $account->account_id)
		{
			//throw new CHttpException(401,'You are not given the permission to view this page.');
			return true;
		}
		
		return false;
	}

	public static function checkPermission_account_profile_update($accountProfile)
	{
		// check permission
		if (Yii::app()->user->account_email == 'admin'
				|| Yii::app()->user->id == $accountProfile->account_id)
		{
			//throw new CHttpException(401,'You are not given the permission to view this page.');
			return true;
		}
	
		return false;
	}
	
	/**
	 * only allow master account to add into his her own team
	 * 
	 * @param unknown $accountTeamMember
	 * @return boolean
	 */
	public static function checkPermission_account_team_member_create($accountTeamMember)
	{
		// check permission
		if (Yii::app()->user->id == $accountTeamMember->master_account_id
				&& AccountSubscription::model()->isSubscriber(Yii::app()->user->id))
		{
			return true;
		}
	
		return false;
	}
	
	/**
	 * only allow master account to update his her own team
	 *
	 * @param unknown $accountTeamMember
	 * @return boolean
	 */
	public static function checkPermission_account_team_member_update($accountTeamMember)
	{
		// check permission
		if (Yii::app()->user->id == $accountTeamMember->master_account_id
				&& AccountSubscription::model()->isSubscriber(Yii::app()->user->id))
		{
			return true;
		}
	
		return false;
	}
	
	/**
	 * only allow master account to delete his her own team
	 *
	 * @param unknown $accountTeamMember
	 * @return boolean
	 */
	public static function checkPermission_account_team_member_delete($accountTeamMember)
	{
		// check permission
		if (Yii::app()->user->id == $accountTeamMember->master_account_id
				&& AccountSubscription::model()->isSubscriber(Yii::app()->user->id))
		{
			return true;
		}
	
		return false;
	}
	
	public static function checkPermission_account_profile_view($accountProfile)
	{
		// check permission
		if (Yii::app()->user->account_email == 'admin' // ADMIN
				|| Yii::app()->user->id == $accountProfile->account_id // own profile
				|| AccountTeamMember::model()->isValidMember(Yii::app()->user->id, $accountProfile->account_id) // i'm master account, the other is my team member
				|| AccountTeamMember::model()->isMyTeamMember(Yii::app()->user->id, $accountProfile->account_id)) // team mate profile
		{
			//throw new CHttpException(401,'You are not given the permission to view this page.');
			return true;
		}
	
		return false;
	}
	
	/**
	 * If not admin, user can only view his/her own scriptioon
	 * 
	 * @param unknown $accountSubscription
	 * @return boolean
	 */
	public static function checkPermission_account_subscription_view($accountSubscription)
	{
		// check permission
		if (Yii::app()->user->account_email == 'admin' // ADMIN
				|| Yii::app()->user->id == $accountSubscription->account_id) // own profile
		{
			//throw new CHttpException(401,'You are not given the permission to view this page.');
			return true;
		}
	
		return false;
	}
	
	/**
	 * admin duoc view tat ca
	 * user chi dc view cua minh va cua nguoi khac thuoc team cua minh
	 * customer chi dc view cua minh
	 * 
	 * @param unknown $account
	 */
	public static function checkPermission_account_view($account)
	{
		// admin can see everything
		if (Yii::app()->user->account_email == 'admin'
				|| Yii::app()->user->account_email == 'admin@localhost'
				|| Yii::app()->user->account_email == 'admin@localhost.com')
			return true;
		
		// if same account allow
		if ($account->account_id == Yii::app()->user->id)
			return true;
		
		// if not the same team, reject right away
		if (!AccountTeamMember::model()->isMyTeamMember(Yii::app()->user->id, $account->account_id))
			return false;
		
		// if master account, and viewing own team, allow
		if (AccountSubscription::model()->isSubscriber(Yii::app()->user->id)
				&& AccountTeamMember::model()->isValidMember(Yii::app()->user->id, $account->account_id))
			return true;
		
		// if not master account
		$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id);
		
		// check permission
		if ((AccountTeamMember::model()->isCustomer($master_account_id[0], Yii::app()->user->id) 
						&& $account->account_id == Yii::app()->user->id)
				|| !AccountTeamMember::model()->isCustomer($master_account_id[0], Yii::app()->user->id))
		{
			//throw new CHttpException(401,'You are not given the permission to view this page.');
			return true;
		}
		
		return false;
	}
        
        public static function checkPermission_milestone_create($milestone)
        {
            // only project member can create
            if (ProjectMember::model()->isValidMember($milestone->project_id, Yii::app()->user->id))
            {
                return true;
            }
            
            return false;
        }
        
        public static function checkPermission_milestone_update($milestone)
        {
            // only project member can update
            if (ProjectMember::model()->isValidMember($milestone->project_id, Yii::app()->user->id))
            {
                return true;
            }
            
            return false;
        }
        
        public static function checkPermission_milestone_list($milestone)
        {
            // only project member can list
            if (ProjectMember::model()->isValidMember($milestone->project_id, Yii::app()->user->id))
            {
                return true;
            }
            
            return false;
        }
}