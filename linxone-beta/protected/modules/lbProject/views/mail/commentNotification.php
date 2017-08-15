<html>
<head>
	<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Fjalla+One">
</head>
<body style="background-color: #ffffff; width: 100%; font-size: 12px; text-align: left;">

<p style="color: #777777;">
	Write ABOVE THIS LINE to post a reply
</p>

<p style="color: #777777;">
	Project: <?php echo $project->project_name; ?>
</p>

<p>
	<h1 style="margin-top: 20px; margin-bottom: 20px;"><?php echo $entity_name; ?></h1>
</p>

<hr/>

<div class="comment-container">

	<div style="width: 100%">
		<?php
		// get profile info of commentor
		echo "<div>";
		
		// print photo
		echo "<div style='width: 45px; float: left;'>
		{$creatorProfile->getProfilePhoto()}</div>";
		
		// print content
		echo "<div style='display: table'>
		<b>{$creatorProfile->getShortFullName()}</b>: ";
		echo $entity_content . '<br/></div>';
		echo "</div>"; // end div comment-content-container-#
		
		// document listings
		foreach ($entity_documents as $doc)
		{
			echo '<div>';
			//echo CHtml::link($doc->document_real_name, array('document/download', 'id' => $doc->document_id));
			echo CHtml::link($doc->document_real_name, 
				"http://www.linxcircle.com/index.php/document/download?id={$doc->document_id}");
			echo '</div>';
		}
		
		?>
	</div>
	<div class="footer-container">
		<?php 
		echo "Posted on $entity_created_date";
		?>
	</div>

	<p>
		<a href="<?php  echo $entity_url; ?>">View this on LinxCircle.com.</a>
	</p>
</div><!-- end class comment-container -->

<p>
LinxCircle.com (c) <?php echo date('Y'); ?>. LinxHQ Pte Ltd.
</p>

<style type="text/css">
div.comment-container
{
	background-color: #FFFFFF;
	margin-bottom: 40px;
}

div.footer-container
{
	margin-top: 10px;
	border-top: 1px solid #ececec;
	clear: both;
	color: #777777;
	font-size: 11px;
	padding-top: 5px;
}

hr {
  margin: 20px 0;
  border: 0;
  border-top: 1px solid #eeeeee;
  border-bottom: 1px solid #ffffff;
}
</style>
</body>
</html>