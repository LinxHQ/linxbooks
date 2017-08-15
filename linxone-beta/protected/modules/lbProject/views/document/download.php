<?php
/* @var model Documents model */
//echo $model->getDocumentPath(); return;
if (!$model)
{
	return;
}

header('MIME-Version: 1.0');
header( 'Pragma: public');
header( 'Cache-Control: must-revalidate');
//header( 'Content-length: ' . $model->document_file_size);
//if ($model->document_type)
//{
	//header( 'Content-type: ' . $model->document_type);
//}

header( 'Content-transfer-encoding: 8bit');
header( 'Content-disposition: attachment; filename="' . $model->document_real_name .'"' );

$handle = fopen($model->getDocumentPath(), 'rb');

ob_start();
if ($handle)
{
        // ditry trrick to remove errorous empty line at the beginning of file
        $line = 1;
	while ( !feof($handle) ) {
            $content = fread($handle, 8192);
            if ($line == 1) 
            {
                $content = ltrim($content);
            }
		print $content;
                $line++;
	}
	
	fclose($handle);
}

flush();