<?php 
/* @var $wikiPage WikiPage */
/* @var $model XUploadForm */
/* @var $project_id integer */
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap.min.css">
<script src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap.min.js" type="text/javascript"></script>
<style>
div.span7 
{
	width: 100%;
}

body {
    overflow-x:hidden;
}
</style>	
<?php //Yii::app()->bootstrap->register(); ?>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/utilities.js');

$this->widget('xupload.XUpload', array(
		'url' => Yii::app()->createUrl("wikiPage/upload", array(
			'project_id' => $project_id,
			'wiki_page_id' => $wikiPage->wiki_page_id)),
		'model' => $model,
		'attribute' => 'file',
		'multiple' => true,
		'options' => array(
			'dataType' => 'json',
			'completed' => 'js:function(e, data){
				var result = data.result;
				var jsonData = result[0];
				//alert(jsonData);
				
				$.post("' . Yii::app()->createUrl("document/ajaxCreate") . '", {
					"Documents[document_real_name]": sanitizeFileName(jsonData.name),
					"Documents[document_temp_name]": jsonData.secure_name,
					"Documents[document_is_temp]": 1,
					"Documents[document_parent_type]": "WIKI_PAGE",
					"Documents[document_project_id]": ' . $project_id . ', 
					"Documents[document_type]": jsonData.type'
					. ($wikiPage->wiki_page_id ? ',"Documents[document_parent_id]":' . $wikiPage->wiki_page_id : '') . '
				}, function(data){
					if (data.status == "success") {
						parent.handlePostTempUpload(data.document_id, jsonData.name, jsonData.type, jsonData.size, jsonData.secure_name);
						$("#" + jsonData.secure_name)
							.prop("href", "' . Yii::app()->createUrl("document/download") . '/" + data.document_id);
						$("#" + jsonData.secure_name + "-delete-url")
							.attr("onclick", "$.post(\'' . Yii::app()->createUrl('document/ajaxDelete') .'/" + data.document_id + "\');");
					}
					else 
						alert("Upload not fully completed. Please delete and try again.");
				}, "json");
				return true;
			}',
			'downloadTemplate' => 'js: function (o) {
		        var rows = $();
		        $.each(o.files, function (index, file) {
		            var row = $(\'<tr class="template-download fade">\' +
		                (file.error ? \'<td></td><td class="name"></td>\' +
		                    \'<td class="size"></td><td class="error" colspan="2"></td>\' :
		                        \'<td class="preview"></td>\' +
		                            \'<td class="name"><a></a></td>\' +
		                            \'<td class="size"></td><td colspan="2"></td>\'
		                ) + \'<td class="delete"><button class="btn">Delete</button> \' +
		                    \'<input type="checkbox" name="delete" value="1"></td></tr>\');
		            row.find(\'.size\').text(o.formatFileSize(file.size));
		            if (file.error) {
		                row.find(\'.name\').text(file.name);
		                row.find(\'.error\').text(
		                    locale.fileupload.errors[file.error] || file.error
		                );
		            } else {
		                row.find(\'.name a\').text(file.name);
		                if (file.thumbnail_url) {
		                    row.find(\'.preview\').append(\'<a><img></a>\')
		                        .find(\'img\').prop(\'src\', file.thumbnail_url);
		                    row.find(\'a\').prop(\'rel\', \'gallery\');
		                }
		                row.find(\'a\').prop(\'href\', file.url).prop(\'id\', file.secure_name);
		                row.find(\'.delete\')
		                    .attr(\'data-type\', file.delete_type);
		                    //.attr(\'data-url\', file.delete_url);
						row.find(\'button\')
							.attr(\'id\', file.secure_name + \'-delete-url\');
		            }
		            rows = rows.add(row);
		        });
		        return rows;
		    }',
			'downloadTemplateId' => null,
		)
));
