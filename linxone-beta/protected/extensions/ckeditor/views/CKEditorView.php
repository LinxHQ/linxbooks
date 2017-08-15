<?php
/*
 * Created on 10.10.2010
 *
 * Copyright: Shahram Monshi Pouri
 * Based on Christian Kütbach's FCKEditorWidget
 *
 * GNU LESSER GENERAL PUBLIC LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Requirements:
 * The CK-Editor have to be installed and configured. The Editor itself is
 * not includet to this extension.
 *
 * This extension have to be installed into:
 * <Yii-Application>/proected/extensions/ckeditor
 *
 * Usage:
 * see-> readme.txt
 */

require_once($ckEditor);

$oCKeditor = new CKeditor(get_class($model).'['.$attribute.']');
$oCKeditor->basePath = $ckBasePath;

if(isset($config) && is_array($config)){
	foreach($config as $key=>$value){
		$oCKeditor->config[$key] = $value;
	}
}

$oCKeditor->editor(get_class($model).'['.$attribute.']',$defaultValue);
?>