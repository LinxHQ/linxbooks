<?php
/* @var $this WikiPageController */
/* @var $model WikiPage */
/* @var $form CActiveForm */
/* @var $project_id */
/* @var $project_name */
/* @var $is_category YES or NO*/
/* @var $page_tree array */
/* @var $attachments */

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=> 'wiki-page-form',
    'htmlOptions'=>array('class'=>'well'),
	'action' => isset($update) && $update == YES ? 
		array('wikiPage/update', 'id' => $model->wiki_page_id, 'project_id' => isset($project_id) ? $project_id : 0) 
		: array('wikiPage/create', 'project_id' => isset($project_id) ? $project_id : 0),
)); ?>
 
<fieldset>
 
    <?php 
    
    // if currently selected sub is available, use it
    if (Utilities::getCurrentlySelectedSubscription())
    {
    	echo $form->hiddenField($model,'account_subscription_id', 
    			array('value' => Utilities::getCurrentlySelectedSubscription()));
    } else {
	    // if this account is linked to more than 2 subscriptions
	    // must choose which subscription to create this project in
	    // $accountSubscriptions = Yii::app()->user->account_subscriptions;
	    $accountSubscriptions = AccountSubscription::model()->findSubscriptions(Yii::app()->user->id);
	    if ($accountSubscriptions)
	    {
	    	if (count($accountSubscriptions) > 1)
	    	{
	    		// show choices
	    		echo $form->dropDownListRow($model,'account_subscription_id', $accountSubscriptions);
	    	} else if (count($accountSubscriptions) == 1) {
	    		// else hide it by default since there's nothing to select
	    		// TODO: back end needs to validate that user has right.
	    		reset($accountSubscriptions);
	    		$first_key = key($accountSubscriptions);
	    		echo $form->hiddenField($model,'account_subscription_id', array('value' => $first_key));
	    	}
	    }
    }
    // END choosing account subscriptions
    ?>
    <?php echo CHtml::hiddenField('WikiPage[session_date]', '', array('id' => 'WikiPage_session_date')); ?>
    <?php echo $form->hiddenField($model,'wiki_page_id', array('value' => $model->wiki_page_id)); ?>
 	<?php 
 	
 	// CHOOSE PROJECT
 	// if project_id is given when form is called, hide it
 	// Otherwise, give a dropbox for user to choose project.
 	if (isset($project_id) && $project_id > 0)
	{
 		echo $form->hiddenField($model,'project_id', array('value' => $project_id)); 
	} else {
		echo $form->dropDownListRow($model, 'project_id', 
			array(0 => 'None') + Project::model()->getActiveProjects(Yii::app()->user->id, 'datasourceArray', true),
			array('onchange' => 'js: loadWikiTree($(this).val())'));
	}
	// END CHOOSING PROJECT
	
 	?>
    <?php echo $form->textFieldRow($model, 'wiki_page_title', array('style' => 'width: 100%')); ?>
    <?php 
    // Are we adding a new category?
    if ($is_category == YES) 
    {
    	echo $form->hiddenField($model, 'wiki_page_is_category', array('value' => YES));
    } else {
		echo $form->hiddenField($model, 'wiki_page_is_category', array('value' => NO));
	}
	
	// Are we adding a new template?
	if ($is_template == YES)
	{
		echo $form->hiddenField($model, 'wiki_page_is_template', array('value' => YES));
	} else {
		echo $form->hiddenField($model, 'wiki_page_is_template', array('value' => NO));
	}
	?>
	
	<?php 
	/**
	 * POPUP MODAL FOR TEMPLATES
	 */
	$this->beginWidget('bootstrap.widgets.TbModal', 
		array('id'=>'wiki-template-form-popover-' . $model->wiki_page_id)); ?>
 
	<div class="modal-header">
	    <a class="close" data-dismiss="modal">&times;</a>
	    <h4>Wiki Templates</h4>
	</div>
	 
	<div class="modal-body">
	    <?php echo 'loading...'; ?>
	</div>
	 
	<div class="modal-footer">
	    <?php $this->widget('bootstrap.widgets.TbButton', array(
	        'type'=>'primary',
	        'label'=>'Insert',
	        'url'=>'#',
	        'htmlOptions'=>array('data-dismiss'=>'modal'),
	    )); ?>
	    <?php $this->widget('bootstrap.widgets.TbButton', array(
	        'label'=>'Close',
	        'url'=>'#',
	        'htmlOptions'=>array('data-dismiss'=>'modal'),
	    )); ?>
	</div>
	<?php
	$this->endWidget(); 
	// END POPUP MODAL
	?>
	
    <?php //echo $form->textAreaRow($model, 'wiki_page_content', array('class'=>'span8', 'rows'=>20)); ?>
    <?php 
    echo $form->labelEx($model, 'wiki_page_content');
    //echo CHtml::link("Insert Template", "#", array("onclick"=>'InsertHTML(); return false;'));
    echo CHtml::link(
    		'Insert Template',
    		array("#"),
    		array(
    				'data-toggle'=>'modal',
    				'data-target'=>'#wiki-template-form-popover-' . $model->wiki_page_id,
    				'onclick' =>'$("#wiki-template-form-popover-'. $model->wiki_page_id .' .modal-body")
						.load("'.Yii::app()->createUrl("wikiPage/popTemplates").'/subscription/" + $("#WikiPage_account_subscription_id").val());
						return false;',
    		) // end html options
    ); // end link

    $this->widget('ext.ckeditor.CKEditorWidget',array(
    		"model" => $model,                 # Data-Model
    		"attribute"=> 'wiki_page_content',          # Attribute in the Data-Model
    		"defaultValue" => $model->wiki_page_content,     # Optional

    		# Additional Parameter (Check http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html)
		    "config" => array(
		    		"height"=>"400px",
		    		"width"=>"100%",
		    		"toolbar"=>"Basic",
					"autoUpdateElement" => true
		    ),
    
  		#Optional address settings if you did not copy ckeditor on application root
		/**
      "ckEditor"=>Yii::app()->basePath."/../ckeditor/ckeditor.php",
    		# Path to ckeditor.php
    		"ckBasePath"=>Yii::app()->baseUrl."/ckeditor/",
    		# Realtive Path to the Editor (from Web-Root)
    		**/
	));
    ?>
    <?php 
    $page_tree = array( 0 => 'Select') + $page_tree;
    if ($is_category == NO && $is_template == NO) 
    {
    	$selected_items = array();
    	if (isset($wiki_page_parent_id) && $wiki_page_parent_id > 0)
    	{
    		$selected_items = array($wiki_page_parent_id => array('selected'=> true));
    	} else {
			$selected_items = array($model->wiki_page_parent_id=>array('selected'=>true));
		}
    	echo $form->dropDownListRow($model, 'wiki_page_parent_id', $page_tree, 
				array('options' => 
					$selected_items,
					'id' => 'wiki-page-parent'
				));
	}
		
    //echo var_dump($page_tree);
    ?>
    <?php 
    
    // TAGS AND ATTACHMENTS
    if ($is_template == NO)
    {
	    echo $form->textFieldRow($model, 'wiki_page_tags'); 
	    echo CHtml::label("Attachment", 'wiki_page_attachment'); 
	    
	    // show existing attachments
	    // Attachments
	    if (isset($attachments))
	    {
	    	echo '<br/><b>Attachments:</b><br/>';
	    	foreach ($attachments as $doc)
	    	{
	    		// generate ajax delete link
	    		// document delete ajax link
	    		$doc_delete_ajax_link = CHtml::ajaxLink(
	    				'<i class="icon-remove"></i>',
	    				array('document/ajaxDelete', 'id' => $doc->document_id), // Yii URL
	    				array('success' => 'function(data){
							if (data == "success") {
							$("#container-document-' . $doc->document_id . '").remove(); // remove doc div container
					}
					}'),
	    				array('id' => 'ajax-id-'.uniqid())
	    		);
	    
	    		echo '<div id="container-document-' . $doc->document_id . '">';
	    		echo CHtml::link($doc->document_real_name,
	    				Yii::app()->createUrl("document/download", array('id' => $doc->document_id)));
	    		echo '&nbsp;' . $doc_delete_ajax_link;
	    		echo '</div>';
	    		echo '<br/>';
	    	}
	    } // end for listing existing attachments
    ?>
	 	<iframe width="100%" frameborder="0" height="140" 
	 		src="<?php echo Yii::app()->createUrl("wikiPage/formUploadView", array(
 				'id' => $model->wiki_page_id > 0 ? $model->wiki_page_id : 0,
 				'project_id' => isset($project_id) ? $project_id : 0 ));?>"></iframe>
 	<?php 
    } // end if for showing TAGS and ATTACHMENTS
 	?>
</fieldset>

<div class="form-actions">
	<?php //echo CHtml::ajaxSubmitButton('Save','', 
		//		array('update' => '#content', 'id' => 'ajax-link' . uniqid()),
		//		array('live' => false)); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', 
    		array('buttonType'=>'submit',
				//'ajaxOptions' => array('update' => '#wiki-content', 'id' => 'ajax-link' . uniqid()),
				'htmlOptions' => array('live' => false, 'onClick' => 'js: beforePost();'), 
				'url' => isset($update) && $update == YES ? array('wikiPage/update', 'id' => $model->wiki_page_id) : array('wikiPage/create'),
				'type'=>'primary', 
				'label'=>'Submit',
			)); 
    
    // DELETE BUTTON
    if (Permission::checkPermission($model, PERMISSION_WIKI_PAGE_DELETE))
	{
		echo CHtml::ajaxLink(
				'<i class="icon-trash"></i> Delete',
				array('wikiPage/delete', 'id' => $model->wiki_page_id), // Yii URL
				array('success' => 
                                        $model->project_id > 0 ? 
                                        'function(data){
						if (data == "success")
						{
							var url = "' . Yii::app()->createUrl('project/view', array('id' => $model->project_id, 'tab' => 'wiki')) . '";
							workspaceLoadContent(url);
							workspacePushState(url);
						}
					}' : 
                                        'function(data){
						if (data == "success")
						{
							var url = "' . CHtml::normalizeUrl(Utilities::getAppLinkiWiki()) . '";
							workspaceLoadContent(url);
							workspacePushState(url);
						}
					}', // end success param 
					'type' => 'POST'), // jQuery selector
				array('id' => 'ajax-id-'.uniqid(), 'confirm' => 'Are you sure to delete this wiki page and its sub page(s)?')
		);
	}
    ?>
    <?php /**$this->widget('bootstrap.widgets.TbButton', 
    		array('buttonType'=>'ajaxButton',
				'label'=>'Cancel',
				'ajaxOptions' => array('update' => '#wiki-content', 'id' => 'ajax-link' . uniqid()),
				'htmlOptions' => array('live' => false),
				'url' => isset($update) && $update == YES ? array('wikiPage/update', 'id' => $model->wiki_page_id) : array('wikiPage/create')
			));**/ 
	?>
	<div style="display: inline; text-style: italic" id="wiki-page-form-auto-save-message-bottom"></div>
</div>

<div id="attachment-files-container"></div>
 
<?php $this->endWidget(); ?>
<?php 
Yii::app()->clientScript->registerScript('helpers', '
        baseUrl = ' . CJSON::encode(Yii::app()->baseUrl).';
',CClientScript::POS_BEGIN);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/wikiPageForm.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/utilities.js',CClientScript::POS_END);
?>
<script language="javascript">
var file_count = 0;
function handlePostTempUpload(documentID, originalName, type, size, secureName)
{	
	originalName = sanitizeFileName(originalName);
	var el = '<input type="hidden" name="temp_uploaded_file_names[]" value="' + secureName + '" id="id-temp-uploaded-file-name-' + file_count + '"/>';
	el += '<input type="hidden" name="' + secureName + '_original_name" value="' + originalName + '" id="'+ secureName + '_original_name"/>';
	el += '<input type="hidden" name="' + secureName + '_document_id" value="' + documentID + '" id="'+ secureName + '_document_id"/>';
	el += '<input type="hidden" name="' + secureName + '_document_type" value="' + type + '" id="'+ secureName + '_document_type"/>';
	file_count++;

	$("#attachment-files-container").append(el);
}

function loadWikiTree(project_id)
{
	$.get('<?php echo Yii::app()->createUrl('wikiPage/wikiTreeSource');?>/project_id/' + project_id, function(data){
		$('#wiki-page-parent').empty();
		$('#wiki-page-parent').append('<option value="0">Select</option>');
		var json_data = JSON.parse(data);
		$.each(json_data, function(k, v) {
			$('#wiki-page-parent').append('<option value="'+k+'">'+v+'</option>');
		});
	});
}

function beforePost()
{
	CKEDITOR.instances["WikiPage[wiki_page_content]"].updateElement();
}

function templateInsertHTML(content)
{
   // Get the editor instance that we want to interact with.
   var oEditor = CKEDITOR.instances["WikiPage[wiki_page_content]"];

   oEditor.insertHtml(content) ;
}
</script>